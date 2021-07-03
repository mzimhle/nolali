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
require_once 'class/_component.php';
require_once 'class/_product.php';

$packageObject		= new class_package();
$componentObject	= new class_component();
$productObject		= new class_product();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$packageData = $packageObject->getByCode($code);
	
	if(!$packageData) {
		header('Location: /products/package/');
		exit;
	}
	
	$smarty->assign('packageData', $packageData);
	
	$componentData = $componentObject->getByPackage($code);

	if($componentData) {
		$smarty->assign('componentData', $componentData);
	}
} else {
	header('Location: /products/package/');
	exit;
}

$productPairs = $productObject->pairs();
if($productPairs) $smarty->assign('productPairs', $productPairs);

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray	= array();
	$data 			= array();
	$formValid	= true;
	$success		= NULL;

	if(isset($_POST['_product_code']) && trim($_POST['_product_code']) == '') {
		$errorArray['_product_code'] = 'Please select product / service to link to package';
		$formValid = false;		
	} else {
		/* Check if already exists. */
		$check = $componentObject->getProductByPackage(trim($_POST['_product_code']), $packageData['_package_code']);
		
		if($check) {
			$errorArray['_product_code'] = 'Product already linked to package.';
			$formValid = false;				
		}
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data = array();
		$data['_product_code'] 	= trim($_POST['_product_code']);
		$data['_package_code']	= $packageData['_package_code'];

		$success	= $componentObject->insert($data);			
		
		if($success) {
			header('Location: /products/package/component.php?code='.$packageData['_package_code']);
			exit;
		}

	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
	
}

$smarty->display('products/package/component.tpl');


?>