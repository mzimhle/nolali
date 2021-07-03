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
require_once 'class/_product.php';

$productObject 	= new class_product();


if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$productData = $productObject->getByCode($code);

	if($productData) {
		
		$smarty->assign('productData', $productData);

	} else {
		header('Location: /products/product/');
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
	
	if(isset($_POST['_product_name']) && trim($_POST['_product_name']) == '') {
		$errorArray['_product_name'] = 'Name is required';
		$formValid = false;		
	}
	
	if(isset($_POST['_product_description']) && trim($_POST['_product_description']) == '') {
		$errorArray['_product_description'] = 'Description is required';
		$formValid = false;		
	}
	
	if(!isset($productData)) {
	
		if(isset($_POST['_product_type']) && trim($_POST['_product_type']) == '') {
			$errorArray['_product_type'] = 'Type is required';
			$formValid = false;		
		} else {
			
			if(trim($_POST['_product_type']) == 'SERVICE') {
				if(isset($_POST['_product_service_quantity']) && (int)trim($_POST['_product_service_quantity']) == 0) {
					$errorArray['_product_service_quantity'] = 'Quantity is required';
					$formValid = false;		
				}
			}
			
			if(trim($_POST['_product_type']) == 'PAGE') {
				if(isset($_POST['_product_page_link']) && trim($_POST['_product_page_link']) == '') {
					$errorArray['_product_page_link'] = 'Page link is required';
					$formValid = false;		
				}
			}		
		}
		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();
		$data['_product_name'] 					= trim($_POST['_product_name']);	
		$data['_product_description'] 			= trim($_POST['_product_description']);										
		$data['_product_service_quantity'] 	= isset($_POST['_product_service_quantity']) ? (int)trim($_POST['_product_service_quantity']) : 1; 	
		$data['_product_page_link'] 			= isset($_POST['_product_page_link']) ? trim($_POST['_product_page_link']) : '';							
		
		if(isset($productData)) {		
			/*Update. */
			$where		= $productObject->getAdapter()->quoteInto('_product_code = ?', $productData['_product_code']);
			$success	= $productObject->update($data, $where);
		} else {			
			
			$data['_product_type'] 					= trim($_POST['_product_type']);		
			
			$success = $productObject->insert($data);			
		}	
		
		if(count($errorArray) == 0) {							
			header('Location: /products/product/');				
			exit;		
		}			
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('products/product/details.tpl');

?>