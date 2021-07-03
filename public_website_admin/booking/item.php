<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/*** Check for login */
require_once 'includes/auth.php';
/* Other resources. */

/* objects. */
require_once 'class/booking.php';
require_once 'class/_price.php';
require_once 'class/_priceitem.php';

$bookingObject		= new class_booking();
$priceObject			= new class_price();
$priceitemObject	= new class_priceitem();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$bookingData = $bookingObject->getByCode($code);
	
	if(!$bookingData) {
		header('Location: /booking/');
		exit;
	}
	
	$smarty->assign('bookingData', $bookingData);
	
	$priceitemData = $priceitemObject->getByReference($code, 'BOOKING');

	if($priceitemData) {
		$smarty->assign('priceitemData', $priceitemData);
	}
} else {
	header('Location: /booking/');
	exit;
}

if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$deletecode			= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['_priceitem_deleted'] = 1;
		
		$where 	= array();
		$where[] 	= $priceitemObject->getAdapter()->quoteInto('_priceitem_type = ?', 'BOOKING');
		$where[] 	= $priceitemObject->getAdapter()->quoteInto('_priceitem_reference = ?', $code);
		$where[] 	= $priceitemObject->getAdapter()->quoteInto('_priceitem_code = ?', $deletecode);
		$success	= $priceitemObject->update($data, $where);	
		
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

$pricePairs = $priceObject->pairs('PRODUCTITEM');
if($pricePairs) $smarty->assign('pricePairs', $pricePairs);

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray	= array();
	$data 			= array();
	$formValid	= true;
	$success		= NULL;

	if(isset($_POST['_price_code']) && trim($_POST['_price_code']) == '') {
		$errorArray['_price_code'] = 'Product item price is required';
		$formValid = false;		
	}
	
	if(isset($_POST['_priceitem_quantity']) && (int)trim($_POST['_priceitem_quantity']) == 0) {
		$errorArray['_priceitem_quantity'] = 'Quantity is required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$check = $priceitemObject->getByReference($bookingData['booking_code'], 'BOOKING', trim($_POST['_price_code']));
		
		if($check) {
			$errorArray['_price_code'] = 'This item has already been booked under this booking';
			$formValid = false;
		} else {
			$booked = $bookingObject->checkBooking($bookingData['booking_startdate'], $bookingData['booking_enddate'], trim($_POST['_price_code']), $bookingData['booking_code']);
			
			if($booked) {
				$errorArray['_price_code'] = 'This item has already been booked for the booking date range';
				$formValid = false;				
			}
		}		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data = array();
		$data['_price_code'] 				= trim($_POST['_price_code']);
		$data['_priceitem_quantity'] 	= trim($_POST['_priceitem_quantity']);
		$data['_priceitem_type']			= 'BOOKING';
		$data['_priceitem_reference']	= $bookingData['booking_code'];

		$success	= $priceitemObject->insert($data);			
		
		if($success) {
			header('Location: /booking/item.php?code='.$bookingData['booking_code']);
			exit;
		}

	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
	
}

$smarty->display('booking/item.tpl');


?>