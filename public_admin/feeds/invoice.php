<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';
/* Authentication */
require_once 'includes/auth.php';
/* Class files */
require_once 'class/invoice.php';
/* Objects */
$invoiceObject	= new class_invoice();

$results	= array();
$list		= array();	

if(isset($_REQUEST['term'])) {
		
	$q                  = strtolower(trim($_REQUEST['term'])); 
	$invoiceData	= $invoiceObject->search($q, 10);
	
	if($invoiceData) {
		for($i = 0; $i < count($invoiceData); $i++) {
			$show = '';
			if($invoiceData[$i]['invoice_amount_unpaid'] == 0) {
				$show = 'Fully paid invoice';
			} else if($invoiceData[$i]['invoice_amount_unpaid'] > 0) {
				$show = 'Pending payment of R '.number_format($invoiceData[$i]['invoice_amount_unpaid'], 2, ',', ' ');
			} else {
				$show = 'Owing client amount of R '.number_format($invoiceData[$i]['invoice_amount_unpaid'], 2, ',', ' ');
			}
			$list[] = array(
				"id" 		=> $invoiceData[$i]["invoice_id"],
				"label" 	=> $invoiceData[$i]['invoice_code'].($invoiceData[$i]['participant_name'] != '' ? ' - '.$invoiceData[$i]['participant_name'].' ( '.$invoiceData[$i]['participant_cellphone'].' ) - ' : ' - ').$show,
				"value" 	=> $invoiceData[$i]['invoice_code'].($invoiceData[$i]['participant_name'] != '' ? ' - '.$invoiceData[$i]['participant_name'].' ( '.$invoiceData[$i]['participant_cellphone'].' ) - ' : ' - ').$show,
			);			
		}	
	}
}

if(count($list) > 0) {
	echo json_encode($list); 
	exit;
} else {
	echo json_encode(array('id' => '', 'label' => 'no results')); 
	exit;
}
exit;
?>