<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';
/* Authentication */
require_once 'includes/auth.php';
/* Class files */
require_once 'class/entity.php';
/* Objects */
$entityObject	= new class_entity();

$results	= array();
$list		= array();	

if(isset($_REQUEST['term'])) {
		
	$q              = strtolower(trim($_REQUEST['term'])); 
	$entityData	= $entityObject->search($q, 10);
	
	if($entityData) {
		for($i = 0; $i < count($entityData); $i++) {
			$list[] = array(
				"id" 		=> $entityData[$i]["entity_id"],
				"label" 	=> $entityData[$i]['entity_name'].' ( '.($entityData[$i]['entity_contact_cellphone'] == '' ? $entityData[$i]['entity_email'] : $entityData[$i]['entity_contact_cellphone']).' )',
				"value" 	=> $entityData[$i]['entity_name'].' ( '.($entityData[$i]['entity_contact_cellphone'] == '' ? $entityData[$i]['entity_email'] : $entityData[$i]['entity_contact_cellphone']).' )'
			);			
		}	
	}
}

if(count($list) > 0) {
	echo json_encode($list); 
	exit;
} else {
	echo json_encode(array('id' => '', 'label' => 'No results')); 
	exit;
}
exit;
?>