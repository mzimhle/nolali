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

$bookingObject 		= new class_booking();
$productObject 		= new class_product();
$productpriceObject	= new class_productprice();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$bookingData = $bookingObject->getByCode($code);

	if(!$bookingData) {
		header('Location: /admin/daily-bookings/');
		exit;
	}
	
	$smarty->assign('bookingData', $bookingData);
}

/* Ajax */
if(isset($_GET['product_code_search'])) {

	$productcode		= (isset($_GET['product_code_search']) && $_GET['product_code_search'] != '') ? $_GET['product_code_search'] : '';
	$productpricecode = isset($bookingData['productprice_code']) ? $bookingData['productprice_code'] : '';
	
	if ($productcode != '') {
		
		$html = '';
		
		$productpriceData = $productpriceObject->getAllByProduct($productcode);
		
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
	} else {
		if(isset($_POST['booking_startdate']) && trim($_POST['booking_startdate']) == '') {
			$errorArray['booking_startdate'] = 'Date Required';
			$formValid = false;		
		} else {
			if(isset($_POST['booking_enddate']) && trim($_POST['booking_enddate']) == '') {
				$errorArray['booking_enddate'] = 'required';
				$formValid = false;		
			} else {
				
				if(isset($bookingData)) {
					$checkDate = $bookingObject->checkAvailableDateForUpdate($bookingData['booking_code'], trim($_POST['product_code']), trim($_POST['booking_startdate']), trim($_POST['booking_enddate']));
				} else {
					$checkDate = $bookingObject->checkAvailableDate(trim($_POST['product_code']), trim($_POST['booking_startdate']), trim($_POST['booking_enddate']));
				}
				
				var_dump($checkDate); exit;
				if($checkDate) {
					$errorArray['booking_enddate'] = 'Booking already Made for this date range';
					$errorArray['booking_startdate'] = 'required';
					$formValid = false;						
				}
			}	
		}	
	}
	
	if(isset($_POST['participant_code']) && trim($_POST['participant_code']) == '') {
		$errorArray['participant_code'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['productprice_code']) && trim($_POST['productprice_code']) == '') {
		$errorArray['productprice_code'] = 'required';
		$formValid = false;		
	}
	//print_r($_POST); exit;
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();				
		$data['participant_code']							= trim($_POST['participant_code']);		
		$data['product_code']					= trim($_POST['product_code']);						
		$data['productprice_code']			= trim($_POST['productprice_code']);				
		$data['booking_startdate']			= trim($_POST['booking_startdate']);		
		$data['booking_enddate']				= trim($_POST['booking_enddate']);		
		$data['booking_number_children']	= trim($_POST['booking_number_children']);	
		$data['booking_active']					= isset($_POST['booking_active']) && trim($_POST['booking_active']) == 1 ? 1 : 0;
		
		if(isset($bookingData)) {
		
			/*Update. */
			$where		= $bookingObject->getAdapter()->quoteInto('booking_code = ?', $bookingData['booking_code']);
			$success	= $bookingObject->update($data, $where);
			
			if(count($errorArray) == 0) {							
				header('Location: /admin/daily-bookings/');
				exit;		
			}							
			
		} else {
			
			$data['campaign_code'] 						= $zfsession->domainData['campaign_code'];			
			$data['booking_code']			= $bookingObject->createReference();
			$data['bookingtype_code']	= 'MERXJ';
			
			$success = $bookingObject->insert($data);

			if(count($errorArray) == 0) {							
				header('Location: /admin/daily-bookings/');
				exit;		
			}				
		}					
	}

	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}
 /* Display the template  */	
$smarty->display('adminclient/MU3H/daily-bookings/calendar.tpl');
?>