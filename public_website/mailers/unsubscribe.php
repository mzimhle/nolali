<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/** Standard includes */
require_once 'config/database.php';
	
/* Other resources. */
require_once 'includes/auth.php';

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	/* objects. */
	require_once 'class/participant.php';

	$participantObject 	= new class_participant();
	
	$code = trim($_GET['code']);
	
	$participantData = $participantObject->getByCode($code);

	if($participantData) {			
		/* Insert data. */
		$data = array();
		$data['participant_subscribe']	= 0;
		
		$where	= $participantObject->getAdapter()->quoteInto('participant_code = ?', $participantData['participant_code']);		
		$success	= $participantObject->update($data, $where);	
		
		echo '<h3>You have been successfully unsubscribed with your email address: '.$participantData['participant_name'].'</h3>';
		exit;
	}
}

header('Location: /');
exit;
	
?>

