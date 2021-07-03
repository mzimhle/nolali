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
require_once 'class/_package.php';
require_once 'class/_price.php';

$packageObject	= new class_package();
$priceObject		= new class_price();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$packageData = $packageObject->getByCode($code);
	
	if(!$packageData) {
		header('Location: /products/package/');
		exit;
	}
	
	$smarty->assign('packageData', $packageData);
	
	$priceData = $priceObject->getByProduct('PACKAGE', $code);

	if($priceData) {
		$smarty->assign('priceData', $priceData);
	}
} else {
	header('Location: /products/package/');
	exit;
}

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray	= array();
	$data 			= array();
	$formValid	= true;
	$success		= NULL;

	if(isset($_POST['_price_type']) && trim($_POST['_price_type']) == '') {
		$errorArray['_price_type'] = 'Payment type required';
		$formValid = false;		
	}
	
	if(isset($_POST['_price_cost']) && trim($_POST['_price_cost']) == '') {
		$errorArray['_price_cost'] = 'Price is required';
		$formValid = false;		
	}	
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data = array();
		$data['_price_type'] 			= trim($_POST['_price_type']);
		$data['_price_cost'] 			= trim($_POST['_price_cost']);
		$data['_price_product']		= 'PACKAGE';
		$data['_price_reference']	= $packageData['_package_code'];

		$success	= $priceObject->insert($data);			
		
		if($success) {
			header('Location: /products/package/price.php?code='.$packageData['_package_code']);
			exit;
		}

	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
	
}

$smarty->display('products/package/price.tpl');


?>