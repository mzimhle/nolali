<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';

require_once 'class/invoice.php';
require_once 'class/invoiceitem.php';
require_once 'class/statement.php';
require_once 'class/_comm.php';
	
$invoiceObject		= new class_invoice();
$invoiceitemObject	= new class_invoiceitem();
$statementObject	= new class_statement();
$commObject			= new class_comm();

if(isset($_GET['delete_id'])) {

	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success				= NULL;
	$code					= trim($_GET['delete_id']);

	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data						= array();
		$data['invoice_deleted']	= 1;

		$where 		= $invoiceObject->getAdapter()->quoteInto('invoice_id = ?', $code);
		$success	= $invoiceObject->update($data, $where);	

		if($success) {
			$errorArray['error']	= '';
			$errorArray['result']	= 1;			
		} else {
			$errorArray['error']	= 'Could not delete, please try again.';
			$errorArray['result']	= 0;				
		}
	}

	echo json_encode($errorArray);
	exit;
}

if(isset($_GET['get_invoice_details'])) {

	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	

	$id						= trim($_GET['get_invoice_details']);

	$invoiceData = $invoiceObject->getById($id);

	if(!$invoiceData) {
		$errorArray['error']	= 'Invoice does not exist, please try another one.';
		$errorArray['result']	= 0;		
	} else {
		$errorArray['error']	= '';
		$errorArray['result']	= 1;				
		$errorArray['invoice']	= $invoiceData;				
	}

	echo json_encode($errorArray);
	exit;
}

if(isset($_GET['mail_invoice_message'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	
	$invoicecode				= trim($_GET['mail_invoice_message']);
	
	if(!isset($_GET['mail_invoice_message'])) {
		$errorArray['error']	= 'Please select an invoice to send';	
	} else if(trim($_GET['mail_invoice_message']) == '') {
		$errorArray['error']	= 'Please select an invoice to send';
	} else {
		$invoiceData = $invoiceObject->getById($invoicecode);
		if(!$invoiceData) {
			$errorArray['error']	= 'Invoice selected does not exist';				
		} else if(is_file($zfsession->config['path'].'/'.ltrim($invoiceData['template_file'], '/'))) {
			/* Add the smarty variables. */
			$invoiceitemData = $invoiceitemObject->getByInvoice($invoiceData['invoice_id']);		
			if($invoiceitemData) $smarty->assign('invoiceitemData', $invoiceitemData);
			/* Get payments. */
			$statementData = $statementObject->getByInvoice($invoiceData['invoice_id']);
			if($statementData)  $smarty->assign('statementData', $statementData);
			/* Get the invoice information. */
			$smarty->assign('invoiceData', $invoiceData);
			/* Fetch the file. */
			$html = $smarty->fetch($zfsession->config['path'].'/'.ltrim($invoiceData['template_file'], '/'));
			$html = str_replace('[mediapath]', $zfsession->config['site'].'/media/template/'.strtolower($invoiceData['template_id']).'/media/', $html);

			/* Save file. */
			$directory	= $zfsession->config['path'].'/media/invoice/'.$invoiceData['invoice_id'].'/';
			$filename	= $directory.$invoiceData['invoice_id'].'.html';
			$pdffile	= $directory.$invoiceData['invoice_id'].'.pdf';
			/* Create directory. */
			if(!is_dir($directory)) mkdir($directory, 0777, true);

			if(file_put_contents($filename, $html)) {
				/* Update file in invoice. */	
				$data						= array();
				$data['invoice_file_html']	= '/media/invoice/'.$invoiceData['invoice_id'].'/'.$invoiceData['invoice_id'].'.html';
				/* Update html file. */
				$where		= $invoiceObject->getAdapter()->quoteInto('invoice_id = ?', $invoiceData['invoice_id']);
				$success	= $invoiceObject->update($data, $where);
				try {
					/* Create pdf file. */
					$pdfdata = $invoiceObject->_PDFCROWD->_PDF->convertFile($filename);
					/* Upload the pdf data. */
					if(file_put_contents($pdffile, $pdfdata)) {
						/* Update file in invoice. */	
						$data						= array();
						$data['invoice_file_pdf']	= '/media/invoice/'.$invoiceData['invoice_id'].'/'.$invoiceData['invoice_id'].'.pdf';
						/* Update pdf file. */
						$where		= $invoiceObject->getAdapter()->quoteInto('invoice_id = ?', $invoiceData['invoice_id']);
						$success	= $invoiceObject->update($data, $where);
						
						$invoiceData['invoice_file_html']	= '/media/invoice/'.$invoiceData['invoice_id'].'/'.$invoiceData['invoice_id'].'.html';
						$invoiceData['invoice_file_pdf'] 	= '/media/invoice/'.$invoiceData['invoice_id'].'/'.$invoiceData['invoice_id'].'.pdf';
					} else {
						$errorArray['error'] = 'Could not create pdf';						
					}							
				} catch(Exception $e)  {
					$errorArray['error'] = 'Pdfcrowd Error: Could not create PDF file.';				
				}				
			} else {
				$errorArray['error'] = 'Could not upload file: '.$filename;					
			}			
		} else {
			$errorArray['error'] = 'Invoice template was not found. Please add it first.';		
		}
	}

	if($errorArray['error']  == '') {
		/* Get invoice template */
		$templateData = $commObject->_template->getTemplate('EMAIL', 'MESSAGE_INVOICE');

		if($templateData) {
			$recipient									= array();
			$recipient['recipient_id'] 				= $invoiceData['invoice_id'];
			$recipient['recipient_name'] 			= $invoiceData['participant_name'];
			$recipient['recipient_cellphone'] 		= $invoiceData['participant_cellphone'];
			$recipient['recipient_email']			= $invoiceData['participant_email'];
			$recipient['recipient_type']			= 'BOOKING';
			$recipient['recipient_from_name']	= $zfsession->activeEntity['company_name'];
			$recipient['recipient_from_email']	= $zfsession->activeEntity['company_contact_email'];
			$recipient['recipient_message']		= trim($_GET['message']);
			$recipient['recipient_media'] 			= $zfsession->config['site'].'/media/template/'.strtolower($invoiceData['template_id']).'/media/';
			/* Add attachment. */
			$attach		= array();
			$attach[]	= $zfsession->config['path'].$invoiceData['invoice_file_pdf'];
			/* Check if all is good. */
			if($commObject->sendEMAIL(array_merge($invoiceData, $recipient, $templateData, $zfsession->activeEntity), $attach)) {
				$errorArray['result']	= 1;	
			} else {
				$errorArray['error']	= 'Email was not sent, please try again or request developer';	
			}
		} else {
			$errorArray['error']	= 'There is no tempate for sending the mail.';		
		}
	}

	echo json_encode($errorArray);
	exit;
}

/* Setup Pagination. */
if(isset($_GET['action']) && trim($_GET['action']) == 'search') {

	$filter	= array();
	$csv	= 0;
	$start 	= isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'] : 0;
	$length	= isset($_REQUEST['iDisplayLength']) ? $_REQUEST['iDisplayLength'] : 20;

	if(isset($_REQUEST['filter_search']) && trim($_REQUEST['filter_search']) != '') $filter[] = array('filter_search' => trim($_REQUEST['filter_search']));
	$filter[] = array('filter_type' => 'BOOKING');
	
	$invoiceData = $invoiceObject->paginate($start, $length, $filter);

	$invoices = array();

	if($invoiceData) {
		for($i = 0; $i < count($invoiceData['records']); $i++) {

			$item = $invoiceData['records'][$i];
			$invoices[$i] = array(
				$item['invoiceitem_date_start'],
				$item['invoiceitem_date_end'],
				$item['participant_cellphone'],
				$item['participant_name'],
				'<a href="/invoice/booking/details.php?id='.$item['invoice_id'].'" '.((int)$item['invoice_paid'] == 1 ? 'class="success"' : 'class="error"').' title="'.($item['template_code'] == 'INVOICE' ? 'Invoice' : 'Quotation').'" alt="'.($item['template_code'] == 'INVOICE' ? 'Invoice' : 'Quotation').'">'.$item['invoice_code'].'</a>',
				'R '.number_format($item['invoiceitem_amount_total'], 2, ',', ' '),
				$item['invoiceitem_quantity'].' nights in the '.$item['product_name'].' at R '.number_format($item['invoiceitem_amount_unit'], 2, ',', ' ')
			);
		}

		$response['sEcho']					= $_REQUEST['sEcho'];
		$response['iTotalRecords']			= $invoiceData['displayrecords'];		
		$response['iTotalDisplayRecords']	= $invoiceData['count'];
		$response['aaData']					= $invoices;
	} else {
		$response['result']		= false;
		$response['message']	= 'There are no items to show.';			
	}

	echo json_encode($response);
	die();
}
/* Display the template */	
$smarty->display('invoice/booking/default.tpl');

?>