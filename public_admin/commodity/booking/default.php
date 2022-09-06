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
	
$invoiceObject		= new class_invoice();
$invoiceitemObject	= new class_invoiceitem();

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
/* Setup Pagination. */
if(isset($_GET['action']) && trim($_GET['action']) == 'search') {

	$filter	= array();
	$csv	= 0;
	$start 	= isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'] : 0;
	$length	= isset($_REQUEST['iDisplayLength']) ? $_REQUEST['iDisplayLength'] : 20;

	if(isset($_REQUEST['filter_search']) && trim($_REQUEST['filter_search']) != '') $filter[] = array('filter_search' => trim($_REQUEST['filter_search']));
	$filter[] = array('filter_template' => 'BOOK');
	
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
				'<a href="/commodity/booking/details.php?id='.$item['invoice_id'].'" '.((int)$item['invoice_paid'] == 1 ? 'class="success"' : 'class="error"').'>'.$item['invoice_code'].'</a>',
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
$smarty->display('commodity/booking/default.tpl');

?>