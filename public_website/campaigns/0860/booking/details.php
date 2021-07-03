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
require_once 'class/participant.php';
require_once 'captcha/recaptchalib.php';

$bookingObject 			= new class_booking();
$productObject 			= new class_product();
$productpriceObject	= new class_productprice();
$participantObject		= new class_participant();

$publickey = "6LeHxP0SAAAAAJRI4czgJWLG5rPzFmQNV2ZYoXD_ ";
$privatekey = "6LeHxP0SAAAAAHvkfLAM51xfxd9K_cZEsqW7RM8j";

# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;

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
	$productpricecode = isset($_GET['price_code']) && trim($_GET['price_code']) != '' ? trim($_GET['price_code']) : '';
	
	if ($productcode != '') {
		
		$html = '';
		
		$productpriceData = $productpriceObject->getByProduct($productcode);

		$html .= '<select name="productprice_code" id="productprice_code">';
		$html .= '<option value=""> ---- </option>';
		if($productpriceData) {
			foreach($productpriceData as $item) {
				$SELECTED = '';
				if($item['productprice_code'] == $productpricecode) $SELECTED = 'SELECTED';

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
	
	$resp = recaptcha_check_answer ($privatekey,  $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
	
	if ($resp->is_valid) {
		/* Do nothing. */
	} else {
		$errorArray['booking_captcha'] = $resp->error;
		$formValid = false;	
	}
	
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
	
	if(isset($_POST['productprice_code']) && trim($_POST['productprice_code']) == '') {
		$errorArray['productprice_code'] = 'required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$checkBooking = $bookingObject->checkBookingByProduct(trim($_POST['product_code']), trim($_POST['booking_startdate']), trim($_POST['booking_enddate']));

		if($checkBooking) {
			$errorArray['product_code'] = 'Days already booked.';
			$formValid = false;				
		}
	}
	
	if(isset($_POST['areapost_code']) && trim($_POST['areapost_code']) == '') {
		$errorArray['areapost_code'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['participant_name']) && trim($_POST['participant_name']) == '') {
		$errorArray['participant_name'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['participant_surname']) && trim($_POST['participant_surname']) == '') {
		$errorArray['participant_surname'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['participant_email']) && trim($_POST['participant_email']) != '') {
		if($participantObject->validateEmail(trim($_POST['participant_email'])) == '') {
			$errorArray['participant_email'] = 'Needs to be a valid email address';
			$formValid = false;	
		}
	} else {
		$errorArray['participant_email'] = 'Email required';
		$formValid = false;					
	}
	
	if(isset($_POST['participant_cellphone']) && trim($_POST['participant_cellphone']) != '') {
		if($participantObject->validateCell(trim($_POST['participant_cellphone'])) == '') {
			$errorArray['participant_cellphone'] = 'Needs to be a valid cellphone number';
			$formValid = false;	
		}
	} else {
		$errorArray['participant_cellphone'] = 'Cellphone required';
		$formValid = false;					
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		/* Add participant. */
		$pdata = array();			
		$pdata['participant_name']			= trim($_POST['participant_name']);		
		$pdata['participant_surname']		= trim($_POST['participant_surname']);		
		$pdata['areapost_code']				= trim($_POST['areapost_code']);	
		$pdata['participant_email']			= $participantObject->validateEmail(trim($_POST['participant_email']));		
		$pdata['participant_cellphone']	= $participantObject->validateCell(trim($_POST['participant_cellphone']));				
		
		$participantData = $participantObject->getByEmail(trim($pdata['participant_email']));
		
		if($participantData) {
			/*Update. */
			$where					= $participantObject->getAdapter()->quoteInto('participant_code = ?', $participantData['participant_code']);
			$participantObject->update($data, $where);	
			$participantcode	= $participantData['participant_code'];
		} else {
			$participantcode	= $participantObject->insert($data);
		}
		
		$data 	= array();				
		$data['participant_code']				= $participantcode;		
		$data['product_code']						= trim($_POST['product_code']);						
		$data['productprice_code']				= trim($_POST['productprice_code']);					
		$data['booking_startdate']				= trim($_POST['booking_startdate']);		
		$data['booking_enddate']				= trim($_POST['booking_enddate']);			
		$data['booking_message']				= trim($_POST['booking_message']);	
		
		$success = $bookingObject->insert($data);		
		
		if($success) {
			
			$bookingObject->sendEmailConfirmation($success);
			
		}
		
		header('Location: /campaign/booking/');
		exit;	
	}

	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
	$smarty->assign('bookingData', $_POST);	
}

$smarty->assign('captchahtml', recaptcha_get_html($publickey, $error));

/* End Pagination Setup. */
$smarty->display($zfsession->domainData['smartypath'].'/booking/details.tpl');

?>