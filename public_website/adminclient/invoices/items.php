<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';
require_once 'adminclient/MU3H/includes/auth.php';

/* objects. */
require_once 'class/invoice.php';
require_once 'class/invoiceitem.php';

$invoiceObject			= new class_invoice();
$invoiceitemObject 	= new class_invoiceitem();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$invoiceData = $invoiceObject->getByCode($code);

	if(!$invoiceData) {
		header('Location: /admin/invoices/');
		exit;
	}
	$smarty->assign('invoiceData', $invoiceData);
} else {
	header('Location: /admin/invoices/');
	exit;
}

/* Ajax */

/* Check posted data. */
if(isset($_GET['invoiceitem_code_update'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;
	$data 						= array();
	$formValid				= true;
	$success					= NULL;
	$invoiceitemcode		= trim($_GET['invoiceitem_code_update']);
	
	if(isset($_GET['invoiceitem_name']) && trim($_GET['invoiceitem_name']) == '') {
		$errorArray['error'] = 'name required.';	
	}
	
	if(isset($_GET['invoiceitem_description']) && trim($_GET['invoiceitem_description']) == '') {
		$errorArray['error'] = 'description required.';	
	}
	
	if(isset($_GET['invoiceitem_price']) && (int)trim($_GET['invoiceitem_price']) == 0) {
		$errorArray['error'] = 'price required.';	
	}
	
	if(isset($_GET['invoiceitem_quantity']) && (int)trim($_GET['invoiceitem_quantity']) == 0) {
		$errorArray['error'] = 'quantity required.';	
	}
	
	if($errorArray['error']  == '') {

		$data 	= array();		
		$data['invoiceitem_name'] 			= trim($_GET['invoiceitem_name']);		
		$data['invoiceitem_description'] 	= trim($_GET['invoiceitem_description']);		
		$data['invoiceitem_price'] 			= (int)trim($_GET['invoiceitem_price']);		
		$data['invoiceitem_quantity'] 		= (int)trim($_GET['invoiceitem_quantity']);		

		$where		= array();
		$where[]	= $invoiceitemObject->getAdapter()->quoteInto('invoiceitem_code = ?', $invoiceitemcode);
		$where[]	= $invoiceitemObject->getAdapter()->quoteInto('invoice_code = ?', $invoiceData['invoice_code']);
		$success	= $invoiceitemObject->update($data, $where);	
		
		if(is_numeric($success) && $success > 0) {		
			$errorArray['error']	= '';
			$errorArray['result']	= 1;			
		} else {
			$errorArray['error']	= 'Could not update, please try again.';
			$errorArray['result']	= 0;				
		}
	}
	
	echo json_encode($errorArray);
	exit;
}


$invoiceitemData = $invoiceitemObject->getByInvoiceCode($invoiceData['invoice_code']);

if($invoiceitemData) {
	$smarty->assign('invoiceitemData', $invoiceitemData);
}


 /* Display the template
 */	
$smarty->display('adminclient/MU3H/invoices/items.tpl');

?>