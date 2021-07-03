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
require_once 'class/_comms.php';
require_once 'class/MU3H/participant.php';

$commsObject 		= new class_comms();
$participantObject 	= new class_participant();

$commsDetails = $commsObject->getCampaignSMSDetails($zfsession->domainData['campaign_code']);

if($commsDetails['sms_count_remainding'] <= 0) {
	header('Location: admin/resources/sms');
	exit;
}

$participantData = $participantObject->getAllWithCell();

if($participantData) {
	$smarty->assign('particiapntnumber', count($participantData));
}

/* Check posted data. */
if(count($_POST) > 0) {	
	
	$errorArray			= array();
	$data 					= array();
	$formValid			= true;
	$success				= NULL;
	
	
	if(isset($_POST['_comms_message']) && trim($_POST['_comms_message']) == '') {
		$errorArray['_comms_message'] = 'Message required';
		$formValid = false;		
	} else {
		if(strlen(trim($_POST['_comms_message'])) > 160) {
			$errorArray['_comms_message'] = 'Message limit of 160 characters';
			$formValid = false;					
		}
	}			
	
	if(!$participantData) {
		$errorArray['_comms_message'] = 'You do not any people to send sms\'s to. Please wait until people subscribed to your website.';
		$formValid = false;			
	}
	
	if(count($errorArray) == 0 && $formValid == true) {

		
		/* Send sms. ******************************************************************************************************/
	
		$user 			= $zfsession->domainData['sms_user'];
		$password 	= $zfsession->domainData['sms_password'];
		$api_id 			= $zfsession->domainData['sms_api_id'];  
		$baseurl 		= $zfsession->domainData['sms_baseurl']; 
		
		$text 			= urlencode(trim($_POST['_comms_message'])); 
		$to 				= ""; 
		
		$commsData = array();
		$i					= 0;
		
		$successCounter = 0;
		$failCounter = 0;
		
		foreach($participantData as $number) {	
			// auth call 		
			
			$commsData[$i]['fullname'] = $number['participant_name'].' '.$number['participant_surname'];
			$commsData[$i]['cell'] 		 = $number['participantdetail_cell'];
			
			if( preg_match( "/^0[0-9]{9}$/", trim($number['participantdetail_cell']))){
				
				$to = trim($number['participantdetail_cell']);
				
				$url = "$baseurl/http/auth?user=$user&password=$password&api_id=$api_id"; 
				echo $url.'<br /><br />';
				// do auth call 
				$ret = file($url); 
				print_r($ret); exit;
				// split our response. return string is on first line of the data returned 

				$sess = explode(":",$ret[0]); 
				
				if ($sess[0] == "OK") { 
				
					$sess_id = trim($sess[1]); // remove any whitespace 
					
					$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text"; 
					
					// do sendmsg call 
					$ret = file($url); 
					
					$send = explode(":",$ret[0]); 
					
					if ($send[0] == "ID") { 						

						$data		= array();
						$data['_comms_code']		= $commsObject->createReference();
						$data['campaign_code']		= $zfsession->domainData['campaign_code'];
						$data['participant_code']	= $number['participant_code'];
						$data['_comms_type']		= 'sms';
						$data['_comms_cost']		= '0.40';
						$data['_comms_cell']			= $to;
						$data['_comms_output']		= "success message ID: ". $send[1];
						$data['_comms_message']	= $text;
						
						$success = $commsObject->insert($data);
						
						$commsData[$i]['output'] =  "Success!"; 
						
						$successCounter ++;
						
					} else  {
						$commsData[$i]['output'] =  "Send message failed: ".$number['participantdetail_cell']; 
						$failCounter++;			  
					}
				} else { 
					$commsData[$i]['output'] =  "Authentication failure: ". $ret[0]; 
					$failCounter++;			  
				} 
			} else {
				$commsData[$i]['output'] =  "Invalid number: ".$number['participantdetail_cell'];	
				$failCounter++;			  
			}
		}		
		
		/* Send sms. ******************************************************************************************************/
		$smarty->assign('failCounter', $failCounter);
		$smarty->assign('successCounter', $successCounter);
		$smarty->assign('commsData', $commsData);
		
		$commsDetails = $commsObject->getCampaignSMSDetails($zfsession->domainData['campaign_code']);		
	}
	
	$smarty->assign('comms_message', trim($_POST['_comms_message']));
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

if($commsDetails) $smarty->assign('commsDetails', $commsDetails);

 /* Display the template  */	
$smarty->display('adminclient/MU3H/resources/sms/details.tpl');
?>