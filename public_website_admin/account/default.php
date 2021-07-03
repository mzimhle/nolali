<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';


/* Check posted data. */
if(count($_POST) > 0) {

	/* objects. */	
	require_once 'class/administrator.php';
	require_once 'class/File.php';
	
	$administratorObject	= new class_administrator();
	$fileObject			= new File(array('gif', 'png', 'jpg', 'jpeg'));
	
	$errorArray		= array();
	$data 				= array();
	$formValid		= true;
	$success			= NULL;
	
	if(isset($_POST['administrator_name']) && trim($_POST['administrator_name']) == '') {
		$errorArray['administrator_name'] = 'Name is required';
		$formValid = false;		
	}
	
	if(isset($_POST['administrator_surname']) && trim($_POST['administrator_surname']) == '') {
		$errorArray['administrator_surname'] = 'Surname is required';
		$formValid = false;		
	}
	
	if(isset($_POST['administrator_cellphone']) && trim($_POST['administrator_cellphone']) != '') {
		if($administratorObject->validateCell(trim($_POST['administrator_cellphone'])) == '') {
			$errorArray['administrator_cellphone'] = 'Needs to be a valid cellphone number';
			$formValid = false;	
		} else {
			
			$cellData = $administratorObject->getByCell(trim($_POST['administrator_cellphone']), $zfsession->identity);

			if($cellData) {
				$errorArray['administrator_cellphone'] = 'Cellphone already exists';
				$formValid = false;				
			}
		}
	} else {
		$errorArray['administrator_cellphone'] = 'Cellphone is required';
		$formValid = false;					
	}
	
	if(isset($_POST['administrator_password']) && trim($_POST['administrator_password']) == '') {
		$errorArray['administrator_password'] = 'Password is required';
		$formValid = false;		
	}	else if(isset($_POST['administrator_password_2']) && trim($_POST['administrator_password_2']) == '') {
		$errorArray['administrator_password_2'] = 'Re-Type password is required';
		$formValid = false;			
	} else if(trim($_POST['administrator_password']) != trim($_POST['administrator_password_2'])) {
		$errorArray['administrator_password_2'] = 'Please make sure that the passwords are similar';
		$formValid = false;			
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();				
		$data['administrator_name']		= trim($_POST['administrator_name']);		
		$data['administrator_surname']	= trim($_POST['administrator_surname']);	
		$data['administrator_cellphone']	= $administratorObject->validateCell(trim($_POST['administrator_cellphone']));
		$data['administrator_password']	= trim($_POST['administrator_password']);
		
		$where 	= array();
		$where[]	= $administratorObject->getAdapter()->quoteInto('campaign_code = ?', $zfsession->domainData['campaign_code']);
		$where[]	= $administratorObject->getAdapter()->quoteInto('administrator_code = ?', $zfsession->identity);
		$success	= $administratorObject->update($data, $where);									
		
		header('Location: /');
		exit;

	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

 /* Display the template  */	
$smarty->display('account/default.tpl');
?>