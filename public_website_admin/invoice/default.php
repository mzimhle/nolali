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

$invoiceObject = new class_invoice();

 if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$code						= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['invoice_deleted'] = 1;
		
		$where 	= array();
		$where[] 	= $invoiceObject->getAdapter()->quoteInto('campaign_code = ?', $zfsession->domainData['campaign_code']);
		$where[] 	= $invoiceObject->getAdapter()->quoteInto('invoice_code = ?', $code);
		$success	= $invoiceObject->update($data, $where);	

		if(is_numeric($success) && $success > 0) {
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

if(isset($_GET['status_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$code						= trim($_GET['status_code']);
	$status						= trim($_GET['status']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		
		$data	= array();
		$data['invoice_status'] = $status;
		
		$where 	= array();
		$where[]	= $invoiceObject->getAdapter()->quoteInto('invoice_code = ?', $code);
		$where[]	= $invoiceObject->getAdapter()->quoteInto('campaign_code = ?', $zfsession->domainData['campaign_code']);
		$success	= $invoiceObject->update($data, $where);	
		
		if(is_numeric($success) && $success > 0) {
			$errorArray['error']	= '';
			$errorArray['result']	= 1;			
		} else {
			$errorArray['error']	= 'Could not change status, please try again.';
			$errorArray['result']	= 0;				
		}
	}
	
	echo json_encode($errorArray);
	exit;
}

if(isset($_GET['action']) && trim($_GET['action']) == 'tablesearch') {

	$search = isset($_REQUEST['search']) && trim($_REQUEST['search']) != '' ? trim($_REQUEST['search']) : null;
	$start 	= isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'] : 0;
	$length = isset($_REQUEST['iDisplayLength']) ? $_REQUEST['iDisplayLength'] : 20;
	
	$invoiceData = $invoiceObject->getSearch($search, $start, $length);
	$all = array();

	if($invoiceData) {
		for($i = 0; $i < count($invoiceData['records']); $i++) {
			$item = $invoiceData['records'][$i];
			$all[$i] = array( 
					$item['invoice_added'],
					'<a href="/invoice/details.php?code='.$item['invoice_code'].'" title="'.$item['invoice_notes'].'" alt="'.$item['invoice_notes'].'">REF#'.$item['invoice_code'].'</a>',
					$item['invoice_person_name'],
					$item['invoice_person_number'].' / '.$item['invoice_person_email'],
					'R '.number_format($item['item_total'],2,",","."),
					'R '.number_format($item['payment_total'],2,",","."),
					'R '.number_format($item['payment_remainder'],2,",","."),
					($item['invoice_pdf'] == '' ? $item['invoice_make'] : '<a href="http://'.$item['campaign_domain'].$item['invoice_pdf'].'" target="_blank">'.$item['invoice_make'].'</a>'),
					"<button class='btn btn-danger' onclick=\"deleteModal('".$item['invoice_code']."', '', 'default'); return false;\">Delete</button>");
		}
	}
	

	$response['sEcho'] = $_REQUEST['sEcho'];
	$response['iTotalRecords'] = $invoiceData['displayrecords'];		
	$response['iTotalDisplayRecords'] = $invoiceData['count'];
	$response['aaData']	= $all;

	
    echo json_encode($response);
    die();	
}

/* Display the template */	
$smarty->display('invoice/default.tpl');

?>