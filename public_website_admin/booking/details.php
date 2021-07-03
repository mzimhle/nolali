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

/* objects. */
require_once 'class/booking.php';

$bookingObject 			= new class_booking();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$bookingData = $bookingObject->getByCode($code);

	if(!$bookingData) {
		header('Location: /booking/');
		exit;
	}
	
	$smarty->assign('bookingData', $bookingData);
	
}

/* Check posted data. */
if(count($_POST) > 0) {
	
	$errorArray		= array();
	$data 				= array();
	$formValid		= true;
	$success			= NULL;
	
	if(isset($_POST['booking_startdate']) && date('Y-m-d H:i', strtotime(trim($_POST['booking_startdate']))) != trim($_POST['booking_startdate'])) {
		$errorArray['booking_startdate'] = 'Date Required';
		$formValid = false;		
	} 

	if(isset($_POST['booking_enddate']) && date('Y-m-d H:i', strtotime(trim($_POST['booking_enddate']))) != trim($_POST['booking_enddate'])) {
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
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();		
		$data['booking_startdate']				= trim($_POST['booking_startdate']);		
		$data['booking_enddate']				= trim($_POST['booking_enddate']);			
		$data['booking_person_name']		= trim($_POST['booking_person_name']);		
		$data['booking_person_email']		= trim($_POST['booking_person_email']);		
		$data['booking_person_number']	= trim($_POST['booking_person_number']);	
		$data['booking_message']				= trim($_POST['booking_message']);	
		$data['areapost_code']					= trim($_POST['areapost_code']);	

		if(isset($bookingData)) {
			/*Update. */
			$where		= $bookingObject->getAdapter()->quoteInto('booking_code = ?', $bookingData['booking_code']);
			$success	= $bookingObject->update($data, $where);
			$success	= $bookingData['booking_code'];
		} else {
			$success = $bookingObject->insert($data);		
		}
		
		header('Location: /booking/item.php?code='.$success);
		exit;	
	}

	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	

}

$smarty->display('booking/details.tpl');

?>