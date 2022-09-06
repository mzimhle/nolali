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
require_once 'class/product.php';
/* Objects */
$productObject	= new class_product();

$results	= array();
$list		= array();	

if(isset($_REQUEST['term'])) {
		
	$q				= strtolower(trim($_REQUEST['term'])); 
	$productData	= $productObject->search('BOOK', $q, 10);
	
	if($productData) {
		for($i = 0; $i < count($productData); $i++) {
			$list[] = array(
				"id" 		=> $productData[$i]["price_id"],
				"label" 	=> $productData[$i]['product_name'].' at R '.number_format($productData[$i]['price_amount'], 2, ',', ' ').' per day',
				"value" 	=> $productData[$i]['product_name'].' at R '.number_format($productData[$i]['price_amount'], 2, ',', ' ').' per day'
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