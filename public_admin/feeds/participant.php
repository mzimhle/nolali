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
require_once 'administration/includes/auth.php';

require_once 'class/participant.php';

$participantObject	= new class_participant();

$results 				= array();

if(isset($_REQUEST['term'])) {
	
	$q						= trim($_REQUEST['term']); 
	$participantData	= $participantObject->search($q);	
	
	if($participantData) {
		for($i = 0; $i < count($participantData); $i++) {
			$results[] = array(
				"id" 		=> $participantData[$i]["participant_code"],
				"label" 	=> $participantData[$i]['participant_name'].' '.$participantData[$i]['participant_surname'],
				"value" 	=> $participantData[$i]['participant_name'].' '.$participantData[$i]['participant_surname']
			);			
		}	
	}
}

if(count($results) > 0) {
	echo json_encode($results); 
	exit;
} else {
	echo json_encode(array('id' => '', 'label' => 'no results')); 
	exit;
}
exit;

?>