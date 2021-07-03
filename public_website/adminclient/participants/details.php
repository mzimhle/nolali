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
require_once 'class/participant.php';

$participantObject	= new class_participant();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$participantData = $participantObject->getByCode($code);

	if(!$participantData) {
		header('Location: /admin/participants/');
		exit;
	}
	$smarty->assign('participantData', $participantData);
}

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray		= array();
	$formValid		= true;
	
	
	if(isset($_POST['areapost_code']) && trim($_POST['areapost_code']) == '') {
		$errorArray['areapost_code'] = 'Area required';
		$formValid = false;		
	}	
	
	if(isset($_POST['participant_name']) && trim($_POST['participant_name']) == '') {
		$errorArray['participant_name'] = 'Name required';
		$formValid = false;		
	}	
	
	if(isset($_POST['participant_surname']) && trim($_POST['participant_surname']) == '') {
		$errorArray['participant_surname'] = 'Surname required';
		$formValid = false;		
	}
	
	if(isset($_POST['participant_email']) && trim($_POST['participant_email']) != '') {
		if($participantObject->validateEmail(trim($_POST['participant_email'])) == '') {
			$errorArray['participant_email'] = 'Needs to be a valid email address';
			$formValid = false;	
		} else {
			
			$email = isset($participantData) ? $participantData['participant_code'] : null;
			
			$emailData = $participantObject->getByEmail(trim($_POST['participant_email']), $email);

			if($emailData) {
				$errorArray['participant_email'] = 'Email already exists';
				$formValid = false;				
			}
		}
	} else {
		$errorArray['participant_email'] = 'Email required';
		$formValid = false;					
	}
	
	if(isset($_POST['participant_cellphone']) && trim($_POST['participant_cellphone']) != '') {
		if($participantObject->validateCell(trim($_POST['participant_cellphone'])) == '') {
			$errorArray['participant_cellphone'] = 'Needs to be a valid cellphone number';
			$formValid = false;	
		} else {
			
			$cell = isset($participantData) ? $participantData['participant_code'] : null;
			
			$cellData = $participantObject->getByCell(trim($_POST['participant_cellphone']), $cell);

			if($cellData) {
				$errorArray['participant_cellphone'] = 'Cellphone already exists';
				$formValid = false;				
			}
		}
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();				
		$data['participant_name']			= trim($_POST['participant_name']);		
		$data['participant_surname']		= trim($_POST['participant_surname']);		
		$data['areapost_code']				= trim($_POST['areapost_code']);	
		$data['participant_email']			= $participantObject->validateEmail(trim($_POST['participant_email']));		
		$data['participant_cellphone']		= $participantObject->validateCell(trim($_POST['participant_cellphone']));		
		
		if(isset($participantData)) {
			/*Update. */
			$where		= $participantObject->getAdapter()->quoteInto('participant_code = ?', $participantData['participant_code']);
			$success	= $participantObject->update($data, $where);						
		} else {
			$success = $participantObject->insert($data);			
		}

		if(count($errorArray) == 0) {							
			header('Location: /admin/participants/');	
			exit;		
		}
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

 /* Display the template  */	
$smarty->display('adminclient/MU3H/participants/details.tpl');
?>