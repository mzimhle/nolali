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
require_once 'class/invoicepayment.php';
require_once 'class/booking.php';

$invoiceObject				= new class_invoice();
$invoiceitemObject 		= new class_invoiceitem();
$invoicepaymentObject	= new class_invoicepayment();
$bookingObject				= new class_booking();

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

/* Get invoice items. */
$invoiceitemsData = $invoiceitemObject->getByInvoiceCode($invoiceData['invoice_code']);
if($invoiceitemsData) $smarty->assign('invoiceitemsData', $invoiceitemsData);

$invoicepaymentsData = $invoicepaymentObject->getByInvoiceCode($invoiceData['invoice_code']);
if($invoicepaymentsData) $smarty->assign('invoicepaymentsData', $invoicepaymentsData);

$invoicePayments = $invoiceObject->sumInvoicePayments($invoiceitemsData, $invoicepaymentsData);
$smarty->assign('invoicePayments', $invoicePayments);

if(count($_POST) > 0) {

	if(isset($_POST['invoicecreate']) && trim($_POST['invoicecreate']) == 1 && $invoiceData['total_amount'] > 0) {
		
		if($bookingObject->createInvoice($invoiceData['booking_code'])) {
			header('Location: /admin/invoices/details.php?code='.$invoiceData['invoice_code']);	
			exit;				
		}
	}		
}

 /* Display the template
 */	
$smarty->display('adminclient/MU3H/invoices/invoice.tpl');

?>