<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';
/* Authentication */
require_once 'includes/auth.php';
/* Class files */
require_once 'class/participant.php';
/* Objects */
$participantObject	= new class_participant();

$results	= array();
$list		= array();	

if(isset($_REQUEST['term'])) {
		
	$q              = strtolower(trim($_REQUEST['term'])); 
	$participantData	= $participantObject->search($q, 10);
	
	if($participantData) {
		for($i = 0; $i < count($participantData); $i++) {
			$list[] = array(
				"id" 		=> $participantData[$i]["participant_id"],
				"label" 	=> $participantData[$i]['participant_name'].' ( '.($participantData[$i]['participant_cellphone'] == '' ? $participantData[$i]['participant_email'] : $participantData[$i]['participant_cellphone']).' )',
				"value" 	=> $participantData[$i]['participant_name'].' ( '.($participantData[$i]['participant_cellphone'] == '' ? $participantData[$i]['participant_email'] : $participantData[$i]['participant_cellphone']).' )'
			);			
		}	
	}
}

if(count($list) > 0) {
	echo json_encode($list); 
	exit;
} else {
	echo json_encode(array('id' => '', 'label' => 'No results')); 
	exit;
}
exit;
?>