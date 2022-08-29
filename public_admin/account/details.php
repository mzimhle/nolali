<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';
/* Class files */
require_once 'class/account.php';
/* Class objects */
$accountObject	= new class_account(); 

if(isset($_GET['id']) && trim($_GET['id']) != '') {

	$code = trim($_GET['id']);

	$accountData = $accountObject->getById($code);

	if($accountData) {
		$smarty->assign('accountData', $accountData);
	} else {
		header('Location: /account/');
		exit;		
	}
}

/* Check posted data. */
if(count($_POST) > 0) {

	$errors	= array();
	$data		= array();

	if(!isset($_POST['account_name'])) {
		$errors[] = 'Please add name of the account';	
	} else if(trim($_POST['account_name']) == '') {
		$errors[] = 'Please add name of the account';	
	}
    
	if(!isset($_POST['account_password'])) {
		$errors[] = 'Please add password of the account';	
	} else if(trim($_POST['account_password']) == '') {
		$errors[] = 'Please add password of the account';	
	} else if(!isset($_POST['account_password_2'])) {
		$errors[] = 'Please add password of the account';	
	} else if(trim($_POST['account_password_2']) == '') {
		$errors[] = 'Please add password of the account';	
	} else if(trim($_POST['account_password']) != trim($_POST['account_password_2'])) {
        $errors[] = 'Please make sure the passwords are similar';	
    }
	
	if(!isset($_POST['account_email'])) {
		$errors[] = 'Please add a email address';
	} else if($accountObject->validateEmail(trim($_POST['account_email'])) == '') {
		$errors[] = 'Please add a email address';
	}

	if(!isset($_POST['account_cellphone'])) {
		$errors[] = 'Please add a cellphone number';
	} else if($accountObject->validateNumber(trim($_POST['account_cellphone'])) == '') {
		$errors[] = 'Please add a cellphone number';
	} else {
		$tempcode = isset($accountData) ? $accountData['account_id'] : null;
		$tempData = $accountObject->getByCell(trim($_POST['account_cellphone']), $tempcode);
		if($tempData) {
			$errors[] = 'Cellphone number is already being used.';
		}
	}

	if(count($errors) == 0) {
		/* Add the details. */
		$data						= array();				
		$data['account_name']		= trim($_POST['account_name']);
		$data['account_cellphone']	= $accountObject->validateNumber(trim($_POST['account_cellphone']));
		$data['account_password']	= trim($_POST['account_password']);
		$data['account_email']		= trim($_POST['account_email']);

		/* Insert or update. */
		if(!isset($accountData)) {
			/* Insert */
			$success	= $accountObject->insert($data);
		} else {
			/* Update */
			$where		= $accountObject->getAdapter()->quoteInto('account_id = ?', $accountData['account_id']);
			$accountObject->update($data, $where);		
			$success	= $accountData['account_id'];			
		}
	}
	/* Check errors and redirect if there are non. */
	if(count($errors) != 0) {
		/* if we are here there are errors. */
		$smarty->assign('errors', implode('<br />', $errors));
		if(!isset($accountData)) $smarty->assign('accountData', $_POST);
	} else {
        if(isset($zfsession->activeAccount)) {
            header('Location: /');		
        } else {
            header('Location: /account/');		
        }
        exit;
	}
}

$smarty->display('account/details.tpl');
?>