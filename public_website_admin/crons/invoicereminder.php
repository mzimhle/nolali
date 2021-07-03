<?php
//ini_set('max_execution_time', 300); //300 seconds = 5 minutes
ini_set('max_execution_time', 120); //300 seconds = 1 minute

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';


require_once 'class/_comm.php';
require_once 'class/template.php';
require_once 'class/invoice.php';
require_once 'class/invoiceremind.php';

$commObject 				= new class_comm();
$invoiceremindObject 	= new class_invoiceremind();
$invoiceObject 				= new class_invoice();
$templateObject			= new class_template();

$invoiceData = $invoiceObject->getUnpaidToRemind(3);

if($invoiceData) {
	
	$error = '';
	$error .= '<b><h3>Remind Clients - '.date('Y-m-d h:i:s').'</h3></b>';
		
	$emailData = $templateObject->getByParent('standard', 'automated');
	
	if($emailData) {
	
		foreach($invoiceData as $item) {

			$error .= '===================<br />';
			$error .= '<b>'.$item['client_name'].'</b><br />';
			$error .= $item['clientcontact_email'].'<br />';
			$error .= $item['clientcontact_name'].'<br />';
			
			$error .= 'Remind Counter '.($item['remindercount']+1).'. for invoice: REF#'.$item['invoice_reference'].'<br />';
			$error .= '<a href="http://www.collop.co.za/media/'.$item['company_reference'].'/invoices/'.$item['client_reference'].'/'.$item['invoice_code'].'/'.$item['invoice_code'].'.html" target="_blank">View linked Invoice</a><br />';	
			
			$attachments = array();
			$attachments[] = array('name' => $item['invoice_reference'].'.pdf', 'path' => $_SERVER['DOCUMENT_ROOT'].str_replace('.html', '.pdf', $item['invoice_file']));
			$commcode = $commObject->sendInvoice($emailData['template_code'], 'Reminder - '.$item['_comm_name'], $item['clientcontact_code'], $item, $attachments);
			
			if($commcode) {
				$error .= '<b>Email successfully sent</b><br />';
				/* Add invoice reminder record. */
				$data = null; 
				$data = array();
				$data['invoice_code'] 		= $item['invoice_code'];
				$data['clientcontact_code']	= $item['clientcontact_code'];
				$data['_comm_code'] 		= $commcode;
				
				$invoiceremindObject->insert($data);					
			} else {
				$error .= '<b>Email WAS NOT sent</b><br />';
			}

			$error .= "===================<br /><br />";			
		}
		
		$commObject->sendAdmin('Monthly Invoices - '.date('F Y'), $error);	
		echo $error;
	}
}