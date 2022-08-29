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
require_once 'class/inventory.php';
/* Objects */
$inventoryObject	= new class_inventory();

$results	= array();
$list		= array();	

if(isset($_REQUEST['term'])) {
		
	$q				= strtolower(trim($_REQUEST['term'])); 
	$inventoryData	= $inventoryObject->unlinked($q, 10);

	if($inventoryData) {
		for($i = 0; $i < count($inventoryData); $i++) {
			$list[] = array(
				"id"	=> $inventoryData[$i]["inventory_id"],
				"label"	=> $inventoryData[$i]['inventory_quantity'].' worth of '.$inventoryData[$i]['product_name'].' bought for R '.$inventoryData[$i]['inventory_amount'].' on '.date('d F Y', strtotime($inventoryData[$i]['inventory_added'])),
				"value"	=> $inventoryData[$i]['inventory_quantity'].' worth of '.$inventoryData[$i]['product_name'].' bought for R '.$inventoryData[$i]['inventory_amount'].' on '.date('d F Y', strtotime($inventoryData[$i]['inventory_added']))
			);			
		}
	}
}

if(count($list) > 0) {
	echo json_encode($list); 
	exit;
} else {
	echo json_encode(array('id' => '', 'label' => 'no results')); 
	exit;
}
exit;
?>