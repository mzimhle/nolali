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

require_once 'class/booking.php';

$bookingObject = new class_booking();

/* Check posted data. */
if(isset($_GET['booking_code_delete'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success				= NULL;
	$bookingcode			= trim($_GET['booking_code_delete']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {	
		$data	= array();
		$data['booking_deleted'] = 1;
		
		$where	= array();
		$where	= $bookingObject->getAdapter()->quoteInto('booking_code = ?', $bookingcode);
		
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

/* Setup Pagination. */
$bookingData = $bookingObject->getAll();

if($bookingData) $smarty->assign_by_ref('bookingData', $bookingData);

/* End Pagination Setup. */


 /* Display the template
 */	
$smarty->display('adminclient/MU3H/daily-bookings/default.tpl');

?>