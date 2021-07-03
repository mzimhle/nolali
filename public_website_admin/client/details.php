<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/*** Check for login */
require_once 'includes/auth.php';

/* objects. */
require_once 'class/client.php';

$clientObject 	= new class_client();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$clientData = $clientObject->getByCode($code);

	if($clientData) {
		$smarty->assign('clientData', $clientData);
	} else {
		header('Location: /client/');
		exit;		
	}
}

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray		= array();
	$data 				= array();
	$formValid		= true;
	$success			= NULL;
	$areaByName	= NULL;
	
	if(isset($_POST['client_name']) && trim($_POST['client_name']) == '') {
		$errorArray['client_name'] = 'Name required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {

		$data 	= array();						
		$data['client_name']		= trim($_POST['client_name']);						
		$data['website_code']		= $zfsession->websitecode;		

		if(isset($clientData)) {
			/*Update. */
			$where 	= array();
			$where[] 	= $clientObject->getAdapter()->quoteInto('client_code = ?', $clientData['client_code']);
			$success	= $clientObject->update($data, $where);
			
			$success	= $clientData['client_code'];
		} else {
			$success = $clientObject->insert($data);				
		}
			
		if(count($errorArray) == 0) {
			header('Location: /client/');	
			exit;		
		}
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('client/details.tpl');

?>