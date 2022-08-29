<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';
/* Class files */
require_once 'class/product.php';
/* Class objects */
$productObject		= new class_product(); 

if(isset($_GET['id']) && trim($_GET['id']) != '') {

	$id		= trim($_GET['id']);
	$productData	= $productObject->getById($id);

	if($productData) {
		$smarty->assign('productData', $productData);
	} else {
		header('Location: /');
		exit;		
	}
}
/* Check posted data. */
if(count($_POST) > 0) {

	$errors	= array();
	$data		= array();

	if(!isset($_POST['product_name'])) {
		$errors[] = 'Please add name of the product';	
	} else if(trim($_POST['product_name']) == '') {
		$errors[] = 'Please add name of the product';	
	}
	
	if(!isset($_POST['product_type'])) {
		$errors[] = 'Please add type of the product';	
	} else if(trim($_POST['product_type']) == '') {
		$errors[] = 'Please add type of the product';	
	}
    
	if(count($errors) == 0) {
		/* Add the details. */
		$data                   = array();				
		$data['product_name']	= trim($_POST['product_name']);
        $data['product_type']	= trim($_POST['product_type']);		
        $data['product_text']	= trim($_POST['product_text']);		
		/* Insert or update. */
		if(!isset($productData)) {
			/* Insert */
			$success = $productObject->insert($data);
			/* Check if all is well. */
			if(!$success) {
				$errors[] = 'We could not add the product, please try again.';
			}
		} else {
			$where		= $productObject->getAdapter()->quoteInto('product_id = ?', $productData['product_id']);
			$productObject->update($data, $where);		
			$success	= $productData['product_id'];			
		}
	}
	/* Check errors and redirect if there are non. */
	if(count($errors) != 0) {
		/* if we are here there are errors. */
		$smarty->assign('errors', implode('<br />', $errors));
	} else {
		header('Location: /product/price.php?id='.$success);
		exit;
	}
}

$smarty->display('product/details.tpl');
?>