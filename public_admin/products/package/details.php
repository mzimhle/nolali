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
require_once 'includes/auth.php';

/* objects. */
require_once 'class/_package.php';

$packageObject 	= new class_package();


if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$packageData = $packageObject->getByCode($code);

	if($packageData) {
		
		$smarty->assign('packageData', $packageData);

	} else {
		header('Location: /products/package/');
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
	
	if(isset($_POST['_package_name']) && trim($_POST['_package_name']) == '') {
		$errorArray['_package_name'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['_package_description']) && trim($_POST['_package_description']) == '') {
		$errorArray['_package_description'] = 'required';
		$formValid = false;		
	}

	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();
		$data['_package_name'] 			= trim($_POST['_package_name']);	
		$data['_package_description'] 	= trim($_POST['_package_description']);								
		
		if(isset($packageData)) {		
			/*Update. */
			$where		= $packageObject->getAdapter()->quoteInto('_package_code = ?', $packageData['_package_code']);
			$success	= $packageObject->update($data, $where);
									
		} else {
			
			$success = $packageObject->insert($data);			
		}	
		
		if(count($errorArray) == 0) {							
			header('Location: /products/package/');				
			exit;		
		}			
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('products/package/details.tpl');

?>