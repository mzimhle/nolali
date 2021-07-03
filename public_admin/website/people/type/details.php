<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/* Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/* Check for login */
require_once 'includes/auth.php';

/* objects. */
require_once 'class/participantcategory.php';

$participantcategoryObject = new class_participantcategory();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$participantcategoryData = $participantcategoryObject->getByCode($code);

	if($participantcategoryData) {
		$smarty->assign('participantcategoryData', $participantcategoryData);
	} else {
		header('Location: /website/people/type/');
		exit;
	}
}

/* Check posted data. */
if(count($_POST) > 0) {
	$errorArray	= array();
	$data 		= array();
	$formValid	= true;
	$success	= NULL;
	
	if(isset($_POST['participantcategory_name']) && trim($_POST['participantcategory_name']) == '') {
		$errorArray['participantcategory_name'] = 'Name is required';
		$formValid = false;		
	}
	
	if(!isset($participantcategoryData)) {
		if(isset($_POST['participantcategory_code']) && trim($_POST['participantcategory_code']) == '') {
			$errorArray['participantcategory_code'] = 'Code is required';
			$formValid = false;		
		} else if(strlen(trim($_POST['participantcategory_code'])) > 4) {
			$errorArray['participantcategory_code'] = 'Code should be less or equal to 4 numbers';
			$formValid = false;				
		}
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
	
		$data 	= array();				
		$data['participantcategory_name']			= trim($_POST['participantcategory_name']);				
		
		if(isset($participantcategoryData)) {
			$where		= $participantcategoryObject->getAdapter()->quoteInto('participantcategory_code = ?', $participantcategoryData['participantcategory_code']);
			$success	= $participantcategoryObject->update($data, $where);			
		} else {			
			$data['participantcategory_code']		= strtoupper(trim($_POST['participantcategory_code']));				
			$success = $participantcategoryObject->insert($data);
		}

		header('Location: /website/people/type/');	
		exit;		
		
		
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('website/people/type/details.tpl');

?>