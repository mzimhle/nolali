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

require_once 'class/participant.php';

$participantObject = new class_participant();

if(isset($_GET['participant_code_delete'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success				= NULL;
	$code					= trim($_GET['participant_code_delete']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {	
		$data	= array();
		$data['participant_deleted'] = 1;
		
		$where = $participantObject->getAdapter()->quoteInto('participant_code = ?', $code);
		
		$success	= $participantObject->update($data, $where);	
		
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
$participantData = $participantObject->getAll();

if($participantData) $smarty->assign_by_ref('participantData', $participantData);

/* Display the template */	
$smarty->display('adminclient/MU3H/participants/default.tpl');
?>