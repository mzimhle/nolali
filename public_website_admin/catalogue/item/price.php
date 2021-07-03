<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/*** Check for login */
require_once 'includes/auth.php';
/* Other resources. */

/* objects. */
require_once 'class/productitem.php';
require_once 'class/_price.php';

$productitemObject	= new class_productitem();
$priceObject		= new class_price();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$productitemData = $productitemObject->getByCode($code);
	
	if(!$productitemData) {
		header('Location: /catalogue/item/');
		exit;
	}
	
	$smarty->assign('productitemData', $productitemData);
	
	$priceData = $priceObject->getByProduct('PRODUCTITEM', $code);

	if($priceData) {
		$smarty->assign('priceData', $priceData);
	}
} else {
	header('Location: /catalogue/item/');
	exit;
}

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray	= array();
	$data 			= array();
	$formValid	= true;
	$success		= NULL;
	
	if(isset($_POST['_price_cost']) && trim($_POST['_price_cost']) == '') {
		$errorArray['_price_cost'] = 'Price is required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data = array();
		$data['_price_number'] 		= trim($_POST['_price_number']);
		$data['_price_cost'] 			= trim($_POST['_price_cost']);
		$data['_price_product']		= 'PRODUCTITEM';
		$data['_price_reference']	= $productitemData['productitem_code'];

		$success	= $priceObject->insert($data);			
		
		if($success) {
			header('Location: /catalogue/item/price.php?code='.$productitemData['productitem_code']);
			exit;
		}

	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
	
}

$smarty->display('catalogue/item/price.tpl');


?>