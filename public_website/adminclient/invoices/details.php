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
require_once 'class/booking.php';

$invoiceObject			= new class_invoice();
$bookingObject		= new class_booking();

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
if(count($_POST) > 0) {
	$errorArray		= array();
	$data 				= array();
	$formValid		= true;
	$success			= NULL;
	$areaByName	= NULL;
			

	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();					
		$data['invoice_notes'] 			= htmlspecialchars_decode(stripslashes(trim($_POST['invoice_notes'])));	

		/*Update. */
		$where		= $invoiceObject->getAdapter()->quoteInto('invoice_code = ?', $invoiceData['invoice_code']);
		$success	= $invoiceObject->update($data, $where);
									
		header('Location: /admin/invoices/items.php?code='.$invoiceData['invoice_code']);
		exit;		
	
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

 /* Display the template  */	
$smarty->display('adminclient/MU3H/invoices/details.tpl');
?>