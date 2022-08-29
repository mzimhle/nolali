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
	
$invoiceObject      = new class_invoice();
$invoiceitemObject  = new class_invoiceitem();
$statementObject	= new class_statement();
$commObject         = new class_comm();

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
		} else if(!is_file($zfsession->config['path'].'/'.ltrim($invoiceData['template_file'], '/'))) {
			$errorArray['error'] = 'Invoice template was not found. Please add it first.';
		}
	}

	if($errorArray['error']  == '') {
		/* Get invoice template */
		$templateData = $commObject->_template->getTemplate('EMAIL', 'INVOICE');

		if($templateData) {
			$recipient							= array();
			$recipient['recipient_id'] 			= $invoiceData['invoice_id'];
			$recipient['recipient_name'] 		= $invoiceData['participant_name'];
			$recipient['recipient_cellphone'] 	= $invoiceData['participant_cellphone'];
			$recipient['recipient_email']		= $invoiceData['participant_email'];
			$recipient['recipient_type']		= 'INVOICE';
			$recipient['recipient_from_name']	= $zfsession->activeEntity['entity_name'];
			$recipient['recipient_from_email']	= $zfsession->activeEntity['entity_contact_email'];
			$recipient['recipient_media'] 		= $zfsession->config['site'].'/media/template/'.strtolower($invoiceData['template_id']).'/media/';
			/* Check if all is good. */
			if($commObject->sendEmail(array_merge($invoiceData, $recipient, $templateData, $zfsession->activeEntity))) {
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
	$filter[] = array('filter_type' => 'ONCEOFF');
	
	$invoiceData = $invoiceObject->paginate($start, $length, $filter);

	$invoices = array();

	if($invoiceData) {
		for($i = 0; $i < count($invoiceData['records']); $i++) {

			$item = $invoiceData['records'][$i];
			$invoices[$i] = array(
				$item['template_code'],			
				($item['entity_name'] != '' ? '<span alt="'.$item['entity_contact_cellphone'].'" title="'.$item['entity_contact_cellphone'].'">'.$item['entity_name'].'</span>' : '<span alt="'.$item['participant_cellphone'].'" title="'.$item['participant_cellphone'].'">'.$item['participant_name'].'</span>'),
				'<a href="/invoice/details.php?id='.$item['invoice_id'].'" '.((int)$item['invoice_paid'] == 1 ? 'class="success"' : 'class="error"').'>'.$item['invoice_code'].'</a>',
				'R '.number_format($item['invoice_amount_total'],2,",","."),
				'R '.number_format($item['invoice_amount_paid'],2,",","."),
				'R '.number_format($item['invoice_amount_due'],2,",","."),
                ($item['invoice_file_pdf'] == '' ? 
				'<a href="/invoice/download.php?id='.$item['invoice_id'].'">Download</a>' : 
                '<a href="/invoice/view.php?id='.$item['invoice_id'].'" target="_blank">View</a>'),
				'<button type="button" onclick="javascript:openInvoiceModal(\''.$item['invoice_id'].'\');">Send</button>',
				($item['invoice_paid'] == 0 ? '<button type="button" onclick="javascript:deleteModal(\''.$item['invoice_id'].'\', \'\', \'default\');">Delete</button>' : 'N/A'),
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
$smarty->display('invoice/default.tpl');

?>