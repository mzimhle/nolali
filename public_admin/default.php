<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';
require_once 'class/entity.php';
require_once 'class/account.php';	
// objects
$entityObject	= new class_entity();
$accountObject	= new class_account();

/* Check posted data. */
if(count($_POST) > 0 && isset($_POST['entity_id'])) {
	/* Check posted data. */
	if(trim($_POST['entity_id']) != '') {
		/* Get the account. */
		$entityData = $entityObject->getById(trim($_POST['entity_id']));
		
		if($entityData) {
			$zfsession->activeEntity	= $entityData;
			$zfsession->entity        	= $entityData['entity_id'];
		} else {
			$zfsession->activeEntity	= null;
			$zfsession->entity			= null;
			unset($zfsession->activeEntity);  
			unset($zfsession->entity);
		}
	} else {
		$zfsession->activeEntity	= null;
		$zfsession->entity 			= null;
		unset($zfsession->activeEntity);  
		unset($zfsession->entity);
	}

	header("Location: /");
	exit;
}

/* Check posted data. */
if(isset($_GET['getentity'])) {
	/* Get the account. */
	$entityData = $entityObject->getByAccount(trim($_GET['getentity']));
	$html		= '<option value=""> -- No Entities for Account -- </option>';
	
	if($entityData) {
		$html = '<option value=""> -- Select an entity -- </option>';
		foreach($entityData as $entity) {
            $selected = isset($zfsession->entity) && $zfsession->entity == $entity['entity_id'] ? 'selected' : '';
			$html .= '<option value="'.$entity['entity_id'].'" '.$selected.'> '.$entity['entity_name'].' </option>';
		}
	}
	
	echo $html;
	exit;
}

$accountPairs = $accountObject->pairs();
if($accountPairs) $smarty->assign('accountPairs', $accountPairs);

/* Display the template */	
$smarty->display('default.tpl');

?>