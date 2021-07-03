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

//error_reporting(!E_NOTICE);

/* Check for login */
//require_once 'administration/includes/auth.php';

require_once 'class/ADMIN/_comms.php';
require_once 'class/ADMIN/client.php';
require_once 'class/ADMIN/clientproduct.php';
require_once 'class/ADMIN/invoice.php';
require_once 'class/ADMIN/invoiceitem.php';
require_once 'pdfcrowd/pdfcrowd.php';

$commsObject 			= new class_wn_comms();
$clientObject 				= new class_wn_client();
$clientproductObject 	= new class_wn_clientproduct();
$invoiceObject 			= new class_wn_invoice();
$invoiceitemObject		= new class_wn_invoiceitem();

$clientData = $clientObject->getCurrentPayingDayClient();

if($clientData) {
	
	$error = '';
	$error .= '<b><h3>'.date('Y-m-d h:i:s').'</h3></b>';
	
	foreach($clientData as $item) {
		
		$error .= '===================<br />';
		$error .= '<b>'.$item['client_company'].'</b><br />';
		$error .= $item['client_contact_email'].'<br />';
		$error .= $item['client_contact_name'].' '.$item['client_contact_surname'].'<br />';
		
		/* Get client products. */
		$clientproduct = $clientproductObject->getMonthlyForInvoice($item['client_reference']);
		
		if($clientproduct) {
			
			$attachment = '';
			
			$error .= 'Client products available:<br />';
			
			/* Invoice insert. */
			$tempData = array();
			$tempData['invoice_reference']		= $invoiceObject->createReference();
			$tempData['fk_client_reference'] 	= $item['client_reference'];
			$tempData['invoice_type']			= 'monthly';
			$tempData['invoice_notes']			= null;
			$tempData['invoice_payment_date']	= date('Y-m-d h:i:s');				
			$tempData['invoice_file']			= '/media/invoices/WILLN/'.$item['client_reference'].'/'.$tempData['invoice_reference'].'.html';
			$tempData['invoice_send_to_client']	= 0;			
			$tempData['invoice_paid']			= 0;
			$tempData['invoice_paid_date']		= null;

			$total = 0;
			
			foreach($clientproduct as $clientitem) {
				$total += $clientitem['product_price'];				
			}
			
			$tempData['invoice_total']	= $total;
			
			$smarty->assign('client', $item);
			$smarty->assign('invoice', $tempData);
			$smarty->assign('due_amount', $tempData['invoice_total']);
			$smarty->assign('products', $clientproduct);
			$smarty->assign('paymentDate', $tempData['invoice_payment_date']);
					
			$html = $smarty->fetch('templates/invoice/wn/invoice_monthly.html');
			
			/* Save file. */
			$directory	= $_SERVER['DOCUMENT_ROOT'].'/media/invoices/WILLN/'.$item['client_reference'].'/';
			$filename		= $directory.$tempData['invoice_reference'].'.html';
			$pdffile		= $directory.$tempData['invoice_reference'].'.pdf';
			
			/* Create directory. */
			if(!is_dir($directory)) mkdir($directory, 0777, true);
				
			if(file_put_contents($filename, $html)) {
				
				$invoiceObject->insert($tempData);
				$error .= '<a href="http://'.$_SERVER['HTTP_HOST'].'/media/invoices/WILLN/'.$item['client_reference'].'/'.$tempData['invoice_reference'].'.html" target="_blank">View linked Invoice</a><br />';
				$error .= 'Invoice saved to database and inserted to database.<br />';
				
				foreach($clientproduct  as $item) {
					$invoiceitemdata = array();
					$invoiceitemdata['invoiceitem_name'] 			= $item['product_name'];
					$invoiceitemdata['invoiceitem_description']	= $item['product_description'];
					$invoiceitemdata['invoiceitem_price']				= $item['product_price'];
					$invoiceitemdata['fk_invoice_reference']			= $tempData['invoice_reference'];
					$invoiceitemObject->insert($invoiceitemdata);
					
					$error .= 'Item: '.$item['product_name'].' - R '.$item['product_price'].'<br />';										
				}
				
				try {
					/* Create pdf file. */
					$pdfObject	= new Pdfcrowd("willow_nettica", "6be184b78c92a8da33964db13d079b6e");
					
					$error .= '..... creating pdf invoice...<br />';	
					
					$pdfdata = $pdfObject->convertFile($filename);
					
					if(file_put_contents($pdffile, $pdfdata)) {
						
						$attachment = $_SERVER['DOCUMENT_ROOT'].str_replace('.html', '.pdf', $tempData['invoice_file']);						
						$error .= 'PDF successfully created.<br />';
						/* Send Email. */						
					} else {
						$error .= '<b>Could not create PDF</b><br />';
						$attachment = '';
					}
				} catch(PdfcrowdException $e) {
					$error .= "<b>Pdfcrowd Error: " . $e->getMessage().'</b><br />';
					$attachment = '';
				}				
			} else {
				$error = 'Could not upload file: '.$filename.'<br />';
				$attachment = '';
			}

			/* Send Email to client if there is an attachment. */
			if($attachment != '') {
				$error .= 'Attachment: '.$attachment.'<br />';
				$error .= 'Attachment created.....sending...<br />';
				
				$data = array();
				$data['email'] 				= $_SERVER['HTTP_HOST'] == 'campaign.dev' ? 'mzimhle.mosiwe@gmail.com' : $item['client_contact_email'];
				$data['type'] 				= 'email';
				$data['title']					= 'Monthly Invoice';
				$data['category'] 		= 'invoice';
				$data['reference'] 		= $tempData['invoice_reference'];
				$data['message'] 		= 'Hoping this finds you well.<br /><br />Please view attached invoice for the current monthly services we cater for you.<br /><br />Kind Regards,<br />Willow-Nettica Administration,<br />www.willow-nettica.co.za';
				$data['domain'] 			= $_SERVER['HTTP_HOST'];
				$data['client_code'] 	= 'WNT-V8IK-R3';
				$data['fullname']			= $item['client_contact_name'].' '.$item['client_contact_surname'];
				$data['cost']				= null;

				$result = $commsObject->sendEmailComm('templates/comms/WNT-V8IK-R3/standard.html', $data, 'Monthly Invoice: '.date('Y-m'), array('email' => 'info@willow-nettica.co.za', 'name' => 'Willow-Nettica'), $attachment);				
				
				if(!$result) {
					$error .= '<b>Error: Sending email.</b><br />';
				} else {
					$error .= 'EMAIL SENT<br />';
				}
				
			} else {
				$error .= '<b>Attachment NOT created and EMAIL NOT SENT</b><br />';
			}
			
		} else {
			$error = '<b>No client products.</b><br />';
		}
		
		$error .= '===================<br />';
	}
	
	$data = array();
	$data['email'] 			= 'admin@willow-nettica.co.za';
	$data['frommail'] 		= 'info@willow-nettica.co.za';
	$data['type'] 			= 'email';
	$data['title']			= 'Automated Monthly Invoices';
	$data['reference'] 		= 'invoicemonthly';
	$data['category']		= 'admin';
	$data['message'] 		= $error;
	$data['domain'] 		= $_SERVER['HTTP_HOST'];
	$data['client_code'] 	= 'WNT-V8IK-R3';
	$data['fullname']		= 'Mzimhle Mosiwe';
	$data['cost']			= null;

	$commsObject->sendEmailComm('templates/comms/WNT-V8IK-R3/standard.html', $data, 'Monthly Invoices: '.date('Y-m-d h:i:s'), array('email' => 'admin@willow-nettica.co.za', 'name' => 'Admin Willow-Nettica'));	

	echo $error;
}

?>