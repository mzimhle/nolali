<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

/**
 * Check for login
 */
require_once 'includes/auth.php';

require_once 'class/invoice.php';

$invoiceObject				= new class_invoice();

if (!empty($_GET['code']) && $_GET['code'] != '') {
	
	$code = trim($_GET['code']);
	
	$invoiceData = $invoiceObject->getByCode($code);
	
	if($invoiceData) {
		$smarty->assign('invoiceData', $invoiceData);
	
	} else {
		header('Location: /catalogue/invoice/');
		exit;	
	}
} else {
	header('Location: /catalogue/invoice/');
	exit;
}

/* Check posted data. */
if(count($_POST) > 0 && isset($_POST['generate_invoice'])) {

	$errorArray					= array();
	$errorArray['result'] 		= true;
	$errorArray['generate_invoice'] 	= '';
			
	$success = $invoiceObject->createInvoice($code);
	
	if(!$success) {
		$errorArray['generate_invoice'] = 'We could not generate PDF, please try again.';
	} else {
		header('Location: /catalogue/invoice/generate.php?code='.$code);
		exit;	
	}

	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('catalogue/invoice/generate.tpl');

?>