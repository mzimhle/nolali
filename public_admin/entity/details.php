<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';
/* Class files */
require_once 'class/entity.php';
require_once 'class/account.php';
/* Class objects */
$entityObject	= new class_entity(); 
$accountObject	= new class_account(); 

if(isset($_GET['id']) && trim($_GET['id']) != '') {

	$code = trim($_GET['id']);

	$entityData = $entityObject->getById($code);

	if($entityData) {
		$smarty->assign('entityData', $entityData);
	} else {
		header('Location: /entity/');
		exit;		
	}
}

$accountPairs = $accountObject->pairs();
if($accountPairs) $smarty->assign('accountPairs', $accountPairs);

/* Check posted data. */
if(count($_POST) > 0) {

	$errors	= array();
	$data	= array();

	if(!isset($_POST['account_id'])) {
		$errors[] = 'Please add an account of the entity';	
	} else if(trim($_POST['account_id']) == '') {
		$errors[] = 'Please add an account of the entity';		
	}

	if(!isset($_POST['entity_name'])) {
		$errors[] = 'Please add name of the entity';	
	} else if(trim($_POST['entity_name']) == '') {
		$errors[] = 'Please add name of the entity';	
	}
	
	if(!isset($_POST['entity_address_physical'])) {
		$errors[] = 'Please add physical address of the entity';	
	} else if(trim($_POST['entity_address_physical']) == '') {
		$errors[] = 'Please add physical address of the entity';
	}

    if(!isset($_POST['entity_contact_cellphone'])) {
        $errors[] = 'Please add a valid South African cellphone number';
    } else if(trim($_POST['entity_contact_cellphone']) == '') {
        $errors[] = 'Please add a valid South African cellphone number';
    } else if($entityObject->validateNumber(trim($_POST['entity_contact_cellphone'])) == '') {
        $errors[] = 'Please add a valid cellphone number.';
    } else {
        /* Check if cellphone already exists. */
        $check = isset($entityData) ? $entityData['entity_id'] : null;
        $checkCellphone = $entityObject->getByCell(trim($_POST['entity_contact_cellphone']), $check);
        if($checkCellphone) {
            $errors[] = 'The cellphone number has already been used by another person.';
        }
    }

    if(!isset($_POST['entity_contact_email'])) {
        $errors[] = 'Please add a valid email address';
    } else if(trim($_POST['entity_contact_email']) == '') {
        $errors[] = 'Please add a valid email address';
    } else if($entityObject->validateEmail(trim($_POST['entity_contact_email'])) == '') {
        $errors[] = 'Please add a valid email address';
    } else {
        /* Check if cellphone already exists. */
        $check = isset($entityData) ? $entityData['entity_id'] : null;
        $checkCellphone = $entityObject->getByEmail(trim($_POST['entity_contact_email']), $check);
        if($checkCellphone) {
            $errors[] = 'The email address has already been used by another person.';
        }
    }

	if(count($errors) == 0) {
		/* Add the details. */
		$data								= array();				
		$data['entity_name']				= trim($_POST['entity_name']);
		$data['entity_url']					= trim($_POST['entity_url']);
		$data['account_id']					= trim($_POST['account_id']);		
		$data['entity_address_physical']	= trim($_POST['entity_address_physical']);
		$data['entity_address_postal']		= trim($_POST['entity_address_postal']);
		$data['entity_map_latitude']		= trim($_POST['entity_map_latitude']);
		$data['entity_map_longitude']		= trim($_POST['entity_map_longitude']);
		$data['entity_contact_email']		= trim($_POST['entity_contact_email']);
		$data['entity_contact_cellphone']	= trim($_POST['entity_contact_cellphone']);
		$data['entity_number_registration']	= trim($_POST['entity_number_registration']);
		$data['entity_number_tax']			= trim($_POST['entity_number_tax']);
		$data['entity_number_vat']			= trim($_POST['entity_number_vat']);
		
		/* Insert or update. */
		if(!isset($entityData)) {
			/* Insert */
			$success	= $entityObject->insert($data);
		} else {
			/* Update */
			$where		= $entityObject->getAdapter()->quoteInto('entity_id = ?', $entityData['entity_id']);
			$entityObject->update($data, $where);		
			$success	= $entityData['entity_id'];			
		}
	}
	/* Check errors and redirect if there are non. */
	if(count($errors) != 0) {
		/* if we are here there are errors. */
		$smarty->assign('errors', implode('<br />', $errors));
	} else {
		header('Location: /entity/');		
        exit;
	}
}

$smarty->display('entity/details.tpl');
?>