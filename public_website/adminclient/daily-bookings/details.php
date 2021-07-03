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
require_once 'class/booking.php';
require_once 'class/product.php';
require_once 'class/productprice.php';
require_once 'class/invoice.php';
require_once 'class/invoiceitem.php';

$bookingObject 			= new class_booking();
$productObject 			= new class_product();
$productpriceObject	= new class_productprice();
$invoiceObject 			= new class_invoice();
$invoiceitemObject 	= new class_invoiceitem();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$bookingData = $bookingObject->getByCode($code);

	if(!$bookingData) {
		header('Location: /admin/daily-bookings/');
		exit;
	}
	
	$smarty->assign('bookingData', $bookingData);
	
} else if((isset($_GET['startdate']) && trim($_GET['startdate']) != '') && (isset($_GET['enddate']) && trim($_GET['enddate']) != '')){
	/* We are adding a new booking. */
	
	$startdate = trim($_REQUEST['startdate']); 
	$enddate = trim($_REQUEST['enddate']); 
	
	if((date('Y-m-d', strtotime($startdate)) == $startdate) && (date('Y-m-d', strtotime($enddate)) == $enddate)) {		
		
		$smarty->assign('startdate', $startdate);
		$smarty->assign('enddate', $enddate);
		
	} else {
		header('Location: /admin/daily-bookings/');
		exit;		
	}
} else {
	header('Location: /admin/daily-bookings/');
	exit;	
}

/* Ajax */
if(isset($_GET['product_code_search'])) {

	$productcode		= (isset($_GET['product_code_search']) && $_GET['product_code_search'] != '') ? $_GET['product_code_search'] : '';
	$productpricecode = isset($bookingData['productprice_code']) ? $bookingData['productprice_code'] : '';
	
	if ($productcode != '') {
		
		$html = '';
		
		$productpriceData = $productpriceObject->getByProduct($productcode);

		$html .= '<select name="productprice_code" id="productprice_code">';
		$html .= '<option value=""> ---- </option>';
		if($productpriceData) {
			foreach($productpriceData as $item) {
				$SELECTED = '';
				if($item['product_code'] == $productpricecode) $SELECTED = 'SELECTED';
				
				$html .= '<option '.$SELECTED.' value="'.$item['productprice_code'].'" label="'.$item['productprice_name'].' - R '.$item['productprice_price'].'">'.$item['productprice_name'].' - R '.$item['productprice_price'].'</option>';	
			}
		}
		$html .= '</select>'; 
		echo $html;		
	}
	
	exit;
}

$productPairs = $productObject->pairs();
if($productPairs) $smarty->assign('productPairs', $productPairs);

/* Check posted data. */
if(count($_POST) > 0) {
	
	$errorArray		= array();
	$data 				= array();
	$formValid		= true;
	$success			= NULL;
	
	if(isset($_POST['product_code']) && trim($_POST['product_code']) == '') {
		$errorArray['product_code'] = 'required';
		$formValid = false;		
	}
	
	
	if(isset($_POST['booking_startdate']) && date('Y-m-d', strtotime(trim($_POST['booking_startdate']))) != trim($_POST['booking_startdate'])) {
		$errorArray['booking_startdate'] = 'Date Required';
		$formValid = false;		
	} 
	
	if(isset($_POST['booking_enddate']) && date('Y-m-d', strtotime(trim($_POST['booking_enddate']))) != trim($_POST['booking_enddate'])) {
		$errorArray['booking_enddate'] = 'Date Required';
		$formValid = false;		
	}
	
	if(isset($_POST['participant_code']) && trim($_POST['participant_code']) == '') {
		$errorArray['participant_code'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['productprice_code']) && trim($_POST['productprice_code']) == '') {
		$errorArray['productprice_code'] = 'required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$bookedcode = isset($bookingData) ? $bookingData['booking_code'] : null;
		
		$checkBooking = $bookingObject->checkBookingByProduct(trim($_POST['product_code']), trim($_POST['booking_startdate']), trim($_POST['booking_enddate']), $bookedcode);

		if($checkBooking) {
			$errorArray['product_code'] = 'Already booked.';
			$formValid = false;				
		}
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();				
		$data['participant_code']				= trim($_POST['participant_code']);		
		$data['product_code']						= trim($_POST['product_code']);						
		$data['productprice_code']				= trim($_POST['productprice_code']);
		$data['booking_startdate']				= trim($_POST['booking_startdate']);		
		$data['booking_enddate']				= trim($_POST['booking_enddate']);			
		$data['booking_message']				= trim($_POST['booking_message']);	
		
		if(isset($bookingData)) {
			
			$data['invoice_paid'] 			= trim($_POST['invoice_paid_date']) != '' ? 1 : 0;
			$data['invoice_paid_date']	= trim($_POST['invoice_paid_date']);
			
			/*Update. */
			$where		= $bookingObject->getAdapter()->quoteInto('booking_code = ?', $bookingData['booking_code']);
			$success	= $bookingObject->updateBooking($data, $where, $bookingData['booking_code']);
			
		} else {
			$success = $bookingObject->insert($data);		
		}
		
		header('Location: /admin/daily-bookings/');
		exit;	
	}

	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

/* Display the template */
$smarty->display('adminclient/MU3H/daily-bookings/details.tpl');
?>