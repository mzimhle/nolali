<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';

require_once 'class/booking.php';

$bookingObject = new class_booking();

 if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$code						= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['booking_deleted'] = 1;
		
		$where 	= array();
		$where[] 	= $bookingObject->getAdapter()->quoteInto('campaign_code = ?', $zfsession->domainData['campaign_code']);
		$where[] 	= $bookingObject->getAdapter()->quoteInto('booking_code = ?', $code);
		$success	= $bookingObject->update($data, $where);	

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

if(isset($_GET['status_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$code						= trim($_GET['status_code']);
	$status						= trim($_GET['status']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		
		$data	= array();
		$data['booking_status'] = $status;
		
		$where 	= array();
		$where[]	= $bookingObject->getAdapter()->quoteInto('booking_code = ?', $code);
		$where[]	= $bookingObject->getAdapter()->quoteInto('campaign_code = ?', $zfsession->domainData['campaign_code']);
		$success	= $bookingObject->update($data, $where);	
		
		if(is_numeric($success) && $success > 0) {
			$errorArray['error']	= '';
			$errorArray['result']	= 1;			
		} else {
			$errorArray['error']	= 'Could not change status, please try again.';
			$errorArray['result']	= 0;				
		}
	}
	
	echo json_encode($errorArray);
	exit;
}

if(isset($_GET['action']) && trim($_GET['action']) == 'tablesearch') {

	$search = isset($_REQUEST['search']) && trim($_REQUEST['search']) != '' ? trim($_REQUEST['search']) : null;
	$start 	= isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'] : 0;
	$length = isset($_REQUEST['iDisplayLength']) ? $_REQUEST['iDisplayLength'] : 20;
	
	$bookingData = $bookingObject->getSearch($search, $start, $length);
	$all = array();

	if($bookingData) {
		for($i = 0; $i < count($bookingData['records']); $i++) {
			$item = $bookingData['records'][$i];
			$all[$i] = array( 
					$item['booking_added'],
					$item['booking_person_name'],
					$item['booking_person_email'].' / '.$item['booking_person_number'],
					'<a class="'.($item['booking_status'] == 0 ? 'error' : 'success').'" alt="'.$item['booking_message'].'" title="'.$item['booking_message'].'" href="/booking/details.php?code='.$item['booking_code'].'">'.$item['booking_startdate'].' till '.$item['booking_enddate'].'</a>',
					"<button class='btn btn-notice' onclick=\"statusModal('".$item['booking_code']."', '".($item['booking_status'] == 0 ? '1' : '0')."', 'default'); return false;\">".($item['booking_status'] == 1 ? 'Unbook' : 'Book')."</button>", 
					"<button class='btn btn-danger' onclick=\"deleteModal('".$item['booking_code']."', '', 'default'); return false;\">Delete</button>");
		}
	}
	

	$response['sEcho'] = $_REQUEST['sEcho'];
	$response['iTotalRecords'] = $bookingData['displayrecords'];		
	$response['iTotalDisplayRecords'] = $bookingData['count'];
	$response['aaData']	= $all;

	
    echo json_encode($response);
    die();	
}

/* Display the template */	
$smarty->display('booking/default.tpl');

?>