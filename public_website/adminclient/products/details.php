<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';
require_once 'adminclient/MU3H/includes/auth.php';


/* objects. */
require_once 'class/product.php';

$productObject		= new class_product();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$productData = $productObject->getByCode($code);

	if(!$productData) {
		header('Location: /admin/products/');
		exit;
	}
	
	$smarty->assign('productData', $productData);
}

/* Check posted data. */
if(count($_POST) > 0) {
	
	$errorArray		= array();
	$data 				= array();
	$formValid		= true;
	$success			= NULL;
	
	if(isset($_POST['product_name']) && trim($_POST['product_name']) == '') {
		$errorArray['product_name'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['product_description']) && trim($_POST['product_description']) == '') {
		$errorArray['product_description'] = 'required';
		$formValid = false;		
	}

	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();						
		$data['product_name']			= trim($_POST['product_name']);		
		$data['product_description']	= trim($_POST['product_description']);		
		$data['product_page'] 			= htmlspecialchars_decode(stripslashes(trim($_POST['product_page'])));	
		$data['product_active']			= isset($_POST['product_active']) && trim($_POST['product_active']) == 1 ? 1 : 0;
		
		if(isset($productData)) {
			/*Update. */
			$where		= $productObject->getAdapter()->quoteInto('product_code = ?', $productData['product_code']);
			$success	= $productObject->update($data, $where);				
		} else {
			$success = $productObject->insert($data);
		}
		
		header('Location: /admin/products/');
		exit;			
	}

	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}
 /* Display the template  */	
$smarty->display('adminclient/MU3H/products/details.tpl');
?>