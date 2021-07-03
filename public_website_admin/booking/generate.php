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
require_once 'class/booking.php';
require_once 'class/invoiceitem.php';
require_once 'class/invoicepayment.php';

$invoiceObject				= new class_invoice();
$bookingObject				= new class_booking();
$invoiceitemObject			= new class_invoiceitem();
$invoicepaymentObject	= new class_invoicepayment();

if (!empty($_GET['code']) && $_GET['code'] != '') {
	
	$code = trim($_GET['code']);
	
	$bookingData = $bookingObject->getByCode($code);

	if($bookingData) {
		$smarty->assign('bookingData', $bookingData);
	} else {
		header('Location: /booking');
		exit;	
	}
} else {
	header('Location: /booking');
	exit;
}

/* Check posted data. */
if(count($_POST) > 0 && isset($_POST['generate_invoice'])) {

	$errorArray					= array();
	$errorArray['result'] 		= true;
	$errorArray['generate_invoice'] 	= '';

	$invoice = array();
	$invoice['invoice_person_name'] 	= $bookingData['booking_person_name'];	
	$invoice['invoice_person_email']		= $bookingData['booking_person_email'];	
	$invoice['invoice_person_number']	= $bookingData['booking_person_number'];		
	$invoice['invoice_reference']			= $bookingData['booking_code'];	
	$invoice['invoice_make']				= 'INVOICE';
	$invoice['invoice_notes']					= 'The booking is for between '.date_format(date_create($bookingData['booking_startdate']), 'l jS F Y').' and '.date_format(date_create($bookingData['booking_enddate']), 'l jS F Y').'. '.trim($_POST['invoice_notes']);		
	$invoice['invoice_type']					= 'BOOKING';

	if($bookingData['invoice_code'] != '') {		
		/*Update. */
		$where			= array();
		$where[]		= $invoiceObject->getAdapter()->quoteInto('campaign_code = ?', $zfsession->domainData['campaign_code']); 
		$where[]		= $invoiceObject->getAdapter()->quoteInto('invoice_code = ?', $bookingData['invoice_code']);
		$success		= $invoiceObject->update($invoice, $where);	
		$invoicecode	= $bookingData['invoice_code'];
	} else {
		$invoicecode	= $invoiceObject->insert($invoice);		
	}

	/* Get and remove all current items in the invoice. Then add new items to the invoice. */
	$invoiceitemData = $invoiceitemObject->getByInvoice($invoicecode);

	if($invoiceitemData) {
		for($i = 0; $i < count($invoiceitemData); $i++) {		
			$invoiceitemObject->remove($invoiceitemData[$i]['invoiceitem_code']);	
	
		}
	}
	
	for($i = 0; $i < count($bookingData['priceitem']); $i++) {		
		
		$item = $bookingData['priceitem'][$i];
		
		$invoiceitem = array();
		$invoiceitem['price_code'] 						= $item['_price_code'];
		$invoiceitem['invoice_code'] 					= $invoicecode;
		$invoiceitem['invoiceitem_name'] 			= $item['product_name'];
		$invoiceitem['invoiceitem_description'] 	= $item['productitem_name'];
		$invoiceitem['invoiceitem_quantity'] 		= $item['_priceitem_quantity'];
		$invoiceitem['invoiceitem_amount'] 		= $item['_price_cost'];
		
		$invoiceitemObject->insert($invoiceitem);			
	}
	
	/* Get and remove all current payments in the invoice. */
	$invoicepaymentData = $invoicepaymentObject->getByInvoice($invoicecode);
	
	if($invoicepaymentData) {
		for($i = 0; $i < count($invoicepaymentData); $i++) {		
			$invoicepaymentObject->remove($invoicepaymentData[$i]['invoicepayment_code']);			
		}
	}
	
	for($i = 0; $i < count($bookingData['payment']); $i++) {		
		
		$item = $bookingData['payment'][$i];
		
		$invoicepayment = array();
		$invoicepayment['invoice_code'] 						= $invoicecode;
		$invoicepayment['invoicepayment_amount'] 		= $item['_payment_amount'];
		$invoicepayment['invoicepayment_paid_date'] 	= $item['_payment_paid_date'];
		$invoicepayment['invoicepayment_file'] 				= $item['_payment_file'];
		
		$invoicepaymentObject->insert($invoicepayment);			
	}
	
	$success = $invoiceObject->createInvoice($invoicecode);
	
	if(!$success) {
		$errorArray['generate_invoice'] = 'We could not generate PDF, please try again.';
	} else {
		header('Location: /booking/generate.php?code='.$code);
		exit;	
	}

	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('booking/generate.tpl');

?>