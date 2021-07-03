<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

/**
 * Check for login
 */
require_once 'includes/auth.php';

/* objects. */
require_once 'class/campaign.php';
require_once 'class/product.php';

$campaignObject 			= new class_campaign();
$productObject 				= new class_product();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$productData = $productObject->getByCode($code);

	if($productData) {
		
		$smarty->assign('productData', $productData);

	} else {
		header('Location: /website/catalogue/product/');
		exit;
	}
}

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray		= array();
	$data 				= array();
	$formValid		= true;
	$success			= NULL;
	$areaByName	= NULL;
	
	if(isset($_POST['product_name']) && trim($_POST['product_name']) == '') {
		$errorArray['product_name'] = 'Name is required';
		$formValid = false;		
	}
	
	if(isset($_POST['product_description']) && trim($_POST['product_description']) == '') {
		$errorArray['product_description'] = 'Description is required';
		$formValid = false;		
	}

	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();		
		$data['product_name'] 			= trim($_POST['product_name']);	
		$data['product_description'] 	= trim($_POST['product_description']);	
		$data['product_page'] 			= htmlspecialchars_decode(stripslashes(trim($_POST['product_page'])));			

		if(isset($productData)) {
			/*Update. */
			$where		= $productObject->getAdapter()->quoteInto('product_code = ?', $productData['product_code']);
			$success	= $productObject->update($data, $where);		
			$success 	= $productData['product_code'];
		} else {
			$success = $productObject->insert($data);			
		}					
		
		if(count($errorArray) == 0) {							
			header('Location: /website/catalogue/product/image.php?product='.$success);				
			exit;		
		}
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('website/catalogue/product/details.tpl');

?>