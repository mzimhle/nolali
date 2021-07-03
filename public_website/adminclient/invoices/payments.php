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
require_once 'class/invoicepayment.php';

$invoiceObject			= new class_invoice();
$invoicepaymentObject 	= new class_invoicepayment();

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

/* Check posted data. */
if(isset($_GET['invoicepayment_code_delete'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$invoiceitemcode		= trim($_GET['invoicepayment_code_delete']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {	
		$data	= array();
		$data['invoicepayment_deleted'] = 1;
		
		$where		= array();
		$where[]	= $invoicepaymentObject->getAdapter()->quoteInto('invoicepayment_code = ?', $invoiceitemcode);
		$where[]	= $invoicepaymentObject->getAdapter()->quoteInto('invoice_code = ?', $invoiceData['invoice_code']);
		
		$success	= $invoicepaymentObject->update($data, $where);	
		
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

/* Check posted data. */
if(isset($_GET['invoicepayment_code_update'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;
	$data 						= array();
	$formValid				= true;
	$success					= NULL;
	$invoicepaymentcode	= trim($_GET['invoicepayment_code_update']);
	
	if(isset($_GET['invoicepayment_amount']) && trim($_GET['invoicepayment_amount']) == '') {
		$errorArray['error'] = 'quantity required.';	
	}
	
	if($errorArray['error']  == '') {

		$data 	= array();		
		$data['invoicepayment_amount'] 		= trim($_GET['invoicepayment_amount']);		
		$data['invoicepayment_description'] 	= htmlspecialchars_decode(stripslashes(trim($_GET['invoicepayment_description'])));			

		$where		= array();
		$where[]	= $invoicepaymentObject->getAdapter()->quoteInto('invoicepayment_code = ?', $invoicepaymentcode);
		$where[]	= $invoicepaymentObject->getAdapter()->quoteInto('invoice_code = ?', $invoiceData['invoice_code']);
		$success	= $invoicepaymentObject->update($data, $where);	
		
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

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray	= array();
	$data 			= array();
	$formValid	= true;
	$success		= NULL;
	
	if(isset($_POST['invoicepayment_amount']) && $_POST['invoicepayment_amount'] == '') {
		$errorArray['invoicepayment_amount'] = 'amount required.';	
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();		
		$data['invoicepayment_amount'] 		= trim($_POST['invoicepayment_amount']);		
		$data['invoicepayment_description'] 	= htmlspecialchars_decode(stripslashes(trim($_POST['invoicepayment_description'])));		
		$data['invoicepayment_code']			= $invoicepaymentObject->createReference();
		$data['invoice_code']						= $invoiceData['invoice_code'];
		
		/* Insert */
		$success = $invoicepaymentObject->insert($data);	
							
		header('Location: /admin/invoices/payments.php?code='.$data['invoice_code']);
		exit();				

	}	
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
}

$invoicepaymentData = $invoicepaymentObject->getByInvoiceCode($invoiceData['invoice_code']);

if($invoicepaymentData) {
	$smarty->assign('invoicepaymentData', $invoicepaymentData);
}


 /* Display the template
 */	
$smarty->display('adminclient/MU3H/invoices/payments.tpl');

?>