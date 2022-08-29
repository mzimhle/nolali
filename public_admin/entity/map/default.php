<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/** Check for login */
require_once 'includes/auth.php';
require_once 'class/entity.php';

$entityObject	    		= new class_entity(); 

if(isset($_GET['id']) && trim($_GET['id']) != '') {

	$code = trim($_GET['id']);

	$entityData = $entityObject->getById($code);

	if($entityData) {
		$smarty->assign('entityData', $entityData);
	} else {
		header('Location: /entity/');
		exit;		
	}
} else {
    header('Location: /entity/');
    exit;		
}

/* Check posted data. */
if(count($_POST) > 0) {

	$errors	= array();
	$data		= array();

	if(!isset($_POST['entity_map_latitude'])) {
		$errors[] = 'Please select a latitude';	
	} else if(trim($_POST['entity_map_latitude']) == '') {
		$errors[] = 'Please select a latitude';	
	}

	if(!isset($_POST['entity_map_longitude'])) {
		$errors[] = 'Please select a longitude';	
	} else if(trim($_POST['entity_map_longitude']) == '') {
		$errors[] = 'Please select a longitude';	
	}
    
	if(count($errors) == 0) {
		/* Add the details. */
		$data                           = array();				
		$data['entity_map_latitude']    = trim($_POST['entity_map_latitude']);
		$data['entity_map_longitude']   = trim($_POST['entity_map_longitude']);
        /* Update */
        $where		= $entityObject->getAdapter()->quoteInto('entity_id = ?', $entityData['entity_id']);
        $entityObject->update($data, $where);		
        $success	= $entityData['entity_id'];			
	}
	/* Check errors and redirect if there are non. */
	if(count($errors) != 0) {
		/* if we are here there are errors. */
		$smarty->assign('errors', implode('<br />', $errors));
	} else {
		header('Location: /entity/map/?id='.$entityData['entity_id']);		
        exit;
	}
}

$smarty->display('entity/map/default.tpl');
?>