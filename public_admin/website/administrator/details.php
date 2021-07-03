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
require_once 'class/administrator.php';

$administratorObject	= new class_administrator();

/**
  * If the item exists populate the form with data
  */
if ((!empty($_GET['code']) && $_GET['code'] != '')) {
	
	$code 	= trim($_GET['code']);
	
	$administratorData = $administratorObject->getByCode($code);
	
	if($administratorData) {
		$smarty->assign('administratorData', $administratorData);
	}
}


/* Check posted data. */
if(count($_POST) > 0) {
	
	$errorArray	= array();
	$data 			= array();
	$formValid	= true;
	$success		= NULL;
	
	if(isset($_POST['administrator_name']) && trim($_POST['administrator_name']) == '') {
		$errorArray['administrator_name'] = 'Name is required';
		$formValid = false;
	}
	
	if(isset($_POST['administrator_surname']) && trim($_POST['administrator_surname']) == '') {
		$errorArray['administrator_surname'] = 'Surname is required';
		$formValid = false;
	}
	
	if(isset($_POST['administrator_email']) && trim($_POST['administrator_email']) != '') {
		if($administratorObject->validateEmail(trim($_POST['administrator_email'])) == '') {
			$errorArray['administrator_email'] = 'Needs to be a valid email address';
			$formValid = false;	
		} else {
			
			$email = isset($administratorData) ? $administratorData['administrator_code'] : null;
			
			$emailData = $administratorObject->getByEmail(trim($_POST['administrator_email']), $email);

			if($emailData) {
				$errorArray['administrator_email'] = 'Email already exists';
				$formValid = false;				
			}
		}
	} else {
		$errorArray['administrator_email'] = 'Email is required';
		$formValid = false;					
	}
	
	if(isset($_POST['administrator_cellphone']) && trim($_POST['administrator_cellphone']) != '') {
		if($administratorObject->validateCell(trim($_POST['administrator_cellphone'])) == '') {
			$errorArray['administrator_cellphone'] = 'Needs to be a valid cellphone number';
			$formValid = false;	
		} else {
			
			$cell = isset($administratorData) ? $administratorData['administrator_code'] : null;
			
			$cellData = $administratorObject->getByCell(trim($_POST['administrator_cellphone']), $cell);

			if($cellData) {
				$errorArray['administrator_cellphone'] = 'Cellphone already exists';
				$formValid = false;				
			}
		}
	} else {
		$errorArray['administrator_cellphone'] = 'Cellphone is required';
		$formValid = false;					
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		/* required. */
		$data['administrator_name']			= trim($_POST['administrator_name']); 
		$data['administrator_surname']		= trim($_POST['administrator_surname']); 
		$data['administrator_email']			= trim($_POST['administrator_email']); 
		$data['administrator_cellphone']		= trim($_POST['administrator_cellphone']); 
		
		if(isset($administratorData)) {
			/*Update. */
			$where		= $administratorObject->getAdapter()->quoteInto('administrator_code = ?', $administratorData['administrator_code']);
			$success	= $administratorObject->update($data, $where);
		} else {			
			/* Insert. */
			$success = $administratorObject->insert($data);
		}
		
		/* check if successful. */
		header('Location: /website/administrator/');
		exit;

	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('website/administrator/details.tpl');

?>