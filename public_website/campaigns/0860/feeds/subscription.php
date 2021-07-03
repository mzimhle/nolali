<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';

/* objects. */
require_once 'class/MU3H/participant.php';
require_once 'class/MU3H/participantdetail.php';

$participantObject 			= new class_participant();
$participantdetailObject	= new class_participantdetail();

/* Check posted data. */
if(count($_REQUEST) > 0) {

	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 1;	
	$formValid				= true;
	$success					= NULL;
	
	if(isset($_REQUEST['name']) && trim($_REQUEST['name']) == '') {
		$errorArray['error']	= 'Please add your full name.';
		$errorArray['result']	= 0;		
	}	
	
	
	if(isset($_REQUEST['email']) && trim($_REQUEST['email']) != '') {
		if(!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', trim($_REQUEST['email']))) {
			$errorArray['error']	= 'Please add a valid email address.';
			$errorArray['result']	= 0;		
		} 	
	} else {
		$errorArray['error']	= 'Please add a valid email address.';
		$errorArray['result']	= 0;			
	}
	
	if(isset($_REQUEST['cell']) && trim($_REQUEST['cell']) != '') {
		if(!preg_match("/[0-9]+/", trim($_REQUEST['cell']))) {
			$errorArray['error']	= 'Please add a valid cell number.';
			$errorArray['result']	= 0;		
		} 	
	}
	
	if($errorArray['error'] == '' && $errorArray['result'] == 1) {
		
		$data 	= array();				
		$data['participant_name']				= trim($_REQUEST['name']);	
		$data['participant_active']				= 1;
		
		if(isset($participantData)) {
		
			/*Update. */
			$where		= $participantObject->getAdapter()->quoteInto('participant_code = ?', $participantData['participant_code']);
			$success	= $participantObject->update($data, $where);					
			
			$data['participant_code']	= $participantData['participant_code'];
			
		} else {
			
			$data['campaign_code'] 					= $zfsession->domainData['campaign_code'];		
			$data['participant_code']				= $participantObject->createReference();
			$data['participant_password']			= $participantObject->createPassword();
			$data['participant_username']			= $data['participant_code'];
			$data['participantcategory_code']	= 'VX';
			
			$success = $participantObject->insert($data);			
		}
			
		$ddata 	= array();		
		$ddata['participantdetail_email'] 	= trim($_REQUEST['email']);		
		$ddata['participantdetail_cell'] 	= trim($_REQUEST['cell']);			
		
		$participantDetailData = $participantdetailObject->getSingleByParticipantCode($data['participant_code']);
		
		if($participantDetailData) {
		
			$where		= array();
			$where[]	= $participantdetailObject->getAdapter()->quoteInto('participantdetail_code = ?', $participantDetailData['participantdetail_code']);
			$where[]	= $participantdetailObject->getAdapter()->quoteInto('participant_code = ?', $data['participant_code']);
			
			$success	= $participantdetailObject->update($ddata, $where);	

			$errorArray['error']	= '';
			$errorArray['result']	= 1;		
			
		} else {
	
			$ddata['participant_code']			= $data['participant_code'];
			$ddata['participantdetail_code']	= $participantdetailObject->createReference();

			$success = $participantdetailObject->insert($ddata);	

			$errorArray['error']	= '';
			$errorArray['result']	= 1;					
		}
	}
	
	echo json_encode($errorArray);
	exit;	
}

?>