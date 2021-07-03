<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';

/* objects. */
require_once 'class/booking.php';
require_once 'class/product.php';
require_once 'class/productprice.php';
require_once 'class/_priceitem.php';
require_once 'class/_price.php';
require_once 'captcha/recaptchalib.php';

$bookingObject 		= new class_booking();
$productObject 		= new class_product();
$productitemObject 	= new class_productitem();
$priceitemObject	= new class_priceitem();
$priceObject		= new class_price();

$publickey = "6LeHxP0SAAAAAJRI4czgJWLG5rPzFmQNV2ZYoXD_ ";
$privatekey = "6LeHxP0SAAAAAHvkfLAM51xfxd9K_cZEsqW7RM8j";

# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;

if((isset($_GET['startdate']) && trim($_GET['startdate']) != '') && (isset($_GET['enddate']) && trim($_GET['enddate']) != '')){
	/* We are adding a new booking. */
	
	$startdate = trim($_REQUEST['startdate']); 
	$enddate = trim($_REQUEST['enddate']); 
	
	if((date('Y-m-d', strtotime($startdate)) == $startdate) && (date('Y-m-d', strtotime($enddate)) == $enddate)) {		
		
		$smarty->assign('startdate', $startdate);
		$smarty->assign('enddate', $enddate);
		
	} else {
		header('Location: /booking/');
		exit;		
	}
} else {
	header('Location: /booking/');
	exit;	
}

/* Ajax */
if(isset($_GET['product_code_search'])) {

	$productcode= (isset($_GET['product_code_search']) && $_GET['product_code_search'] != '') ? $_GET['product_code_search'] : '';	
	
	if ($productcode != '') {
		
		$html = '';
		
		$productitemData = $productitemObject->getByProduct($productcode);

		$html .= '<select name="productitem_code" id="productitem_code">';
		$html .= '<option value=""> ---- </option>';
		if($productitemData) {
			foreach($productitemData as $item) {
				$html .= '<option value="'.$item['productitem_code'].'" label="'.$item['productitem_name'].'">'.$item['productitem_name'].'</option>';	
			}
		}
		$html .= '</select>'; 
		echo $html;		
	}
	
	exit;
}

if(isset($_GET['productitem_code_search'])) {

	$productitemcode	= (isset($_GET['productitem_code_search']) && $_GET['productitem_code_search'] != '') ? $_GET['productitem_code_search'] : '';	
	
	if ($productitemcode != '') {
		
		$html = '';
		
		$priceData = $priceObject->getByProduct('PRODUCTITEM',$productitemcode);

		$html .= '<option value=""> ---- </option>';
		if($priceData) {
			foreach($priceData as $item) {
				$html .= '<option value="'.$item['_price_code'].'" label="For '.$item['_price_number'].' person R '.number_format($item['_price_cost'],2,",",".").'">For '.$item['_price_number'].' person R '.number_format($item['_price_cost'],2,",",".").'</option>';	
			}
		}

		echo $html;		
	}
	
	exit;
}

$productPairs = $productObject->pairs();
if($productPairs) $smarty->assign('productPairs', $productPairs);

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray	= array();
	$data 		= array();
	$formValid	= true;
	$success	= NULL;
	/* Do nothing. 
	$resp = recaptcha_check_answer ($privatekey,  $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
	
	if ($resp->is_valid) {
		
	} else {
		//$errorArray['booking_captcha'] = $resp->error;
		//$formValid = false;	
	}
	*/
	if(isset($_POST['booking_startdate']) && date('Y-m-d', strtotime(trim($_POST['booking_startdate']))) != trim($_POST['booking_startdate'])) {
		$errorArray['booking_startdate'] = 'Date Required';
		$formValid = false;		
	} 

	if(isset($_POST['booking_enddate']) && date('Y-m-d', strtotime(trim($_POST['booking_enddate']))) != trim($_POST['booking_enddate'])) {
		$errorArray['booking_enddate'] = 'Date Required';
		$formValid = false;		
	}
	
	if(isset($_POST['booking_person_name']) && trim($_POST['booking_person_name']) == '') {
		$errorArray['booking_person_name'] = 'Person name required';
		$formValid = false;		
	}
	
	if(isset($_POST['booking_person_email']) && trim($_POST['booking_person_email']) != '') {
		if($bookingObject->validateEmail(trim($_POST['booking_person_email'])) == '') {
			$errorArray['booking_person_email'] = 'Needs to be a valid email address';
			$formValid = false;	
		}
	} else {
		$errorArray['booking_person_email'] = 'Please add an email address';
		$formValid = false;		
	}
	
	if(isset($_POST['_price_code']) && trim($_POST['_price_code']) == '') {
		$errorArray['_price_code'] = 'Product item price is required';
		$formValid = false;		
	} else {
		$booked = $bookingObject->checkBooking(trim($_POST['booking_startdate']), trim($_POST['booking_enddate']), trim($_POST['_price_code']));
		
		if($booked) {
			$errorArray['_price_code'] = 'This item has already been booked for the booking date range';
			$formValid = false;				
		}	
	}

	if(count($errorArray) == 0 && $formValid == true) {
		
		/* Add participant. */
		$data 	= array();		
		$data['booking_startdate']		= trim($_POST['booking_startdate']);		
		$data['booking_enddate']		= trim($_POST['booking_enddate']);			
		$data['booking_person_name']	= trim($_POST['booking_person_name']);		
		$data['booking_person_email']	= $bookingObject->validateEmail(trim($_POST['booking_person_email']));		
		$data['booking_person_number']	= trim($_POST['booking_person_number']);	
		$data['booking_message']		= trim($_POST['booking_message']);	
		$data['areapost_code']			= trim($_POST['areapost_code']);
		$data['booking_active']			= 0;

		$bookingcode	= $bookingObject->insert($data);

		$item = array();
		$item['_price_code'] 			= trim($_POST['_price_code']);
		$item['_priceitem_quantity'] 	= 1;
		$item['_priceitem_type']		= 'BOOKING';
		$item['_priceitem_reference']	= $bookingcode;

		$itemcode	= $priceitemObject->insert($item);		
		
		if($itemcode) {
			$smarty->assign('success', 1);	
		}
	}

	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
	if(!isset($itemcode)) $smarty->assign('bookingData', $_POST);	
}

//$smarty->assign('captchahtml', recaptcha_get_html($publickey, $error));

/* End Pagination Setup. */
$smarty->display('booking/details.tpl');

?>