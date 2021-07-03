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
require_once 'class/_comm.php';
require_once 'class/participant.php';

$commObject 		= new class_comm();
$participantObject 	= new class_participant();

$commDetails = $commObject->getCampaignSMSDetails();

if($commDetails['sms_count_remainding'] <= 0) {
	header('Location: /admin/bulk-sms/');
	exit;
}

$participantData = $participantObject->getAll('participant.participant_cellphone is not null');

if($participantData) {
	$smarty->assign('particiapntnumber', count($participantData));
}

/* Check posted data. */
if(count($_POST) > 0) {	
	
	$errorArray			= array();
	$data 					= array();
	$formValid			= true;
	$success				= NULL;
	
	
	if(isset($_POST['_comm_message']) && trim($_POST['_comm_message']) == '') {
		$errorArray['_comm_message'] = 'Message required';
		$formValid = false;		
	} else {
		if(strlen(trim($_POST['_comm_message'])) > 160) {
			$errorArray['_comm_message'] = 'Message limit of 160 characters';
			$formValid = false;					
		}
	}		
	
	if(!$participantData) {
		$errorArray['_comm_message'] = 'You do not any people to send sms\'s to. Please wait until people subscribed to your website.';
		$formValid = false;			
	}
	
	if(count($errorArray) == 0 && $formValid == true) {		
		
		$reference = md5(trim($_POST['_comm_message']));
		
		$failCounter = 0;
		$successCounter = 0;
		
		for($i = 0; $i < count($participantData); $i++) {
			
			$success = null;
			
			$participantData[$i]['reference'] = $reference;
			
			$success = $commObject->sendSMS(trim($_POST['_comm_message']), $participantData[$i]);
			
			if($success) {
				$successCounter++;
			} else {
				$failCounter++;
			}
		}
		
		$commData = $commObject->getAll("_comm._comm_reference = '$reference' and _comm._comm_type = 'SMS'");
		
		if($commData) $smarty->assign('commData', $commData);
		$smarty->assign('successCounter', $successCounter);
		$smarty->assign('failCounter', $failCounter);
		
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

if($commDetails) $smarty->assign('commDetails', $commDetails);

 /* Display the template  */	
$smarty->display('adminclient/MU3H/bulk-sms/details.tpl');
?>