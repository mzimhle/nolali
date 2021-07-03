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
require_once 'class/productprice.php';
require_once 'class/File.php';

$productObject			= new class_product();
$productpriceObject		= new class_productprice();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$productData = $productObject->getByCode($code);

	if(!$productData) {
		header('Location: /admin/products/');
		exit;
	}
	$smarty->assign('productData', $productData);
} else {
	header('Location: /admin/products/');
	exit;
}

/* Check posted data. */
if(isset($_GET['productprice_code_delete'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success				= NULL;
	$itemcode				= trim($_GET['productprice_code_delete']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {	
		$data	= array();
		$data['productprice_deleted'] = 1;
		
		$where		= array();
		$where[]	= $productpriceObject->getAdapter()->quoteInto('productprice_code = ?', $itemcode);
		$where[]	= $productpriceObject->getAdapter()->quoteInto('product_code = ?', $productData['product_code']);
		
		$success	= $productpriceObject->update($data, $where);	
		
		if(is_numeric($success) && $success > 0) {		
			$errorArray['error']	= '';
			$errorArray['result']	= 1;			
		} else {
			$errorArray['error']	= 'Could not delete, please try again.';
			$errorArray['result']	= 0;				
		}
	}
	
	echo json_encode($errorArray);
	exit;
}

/* Check posted data. */
if(isset($_GET['productprice_code_update'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;
	$data 						= array();
	$formValid				= true;
	$success					= NULL;
	$itemcode	= trim($_GET['productprice_code_update']);
	
	if(isset($_GET['productprice_name']) && trim($_GET['productprice_name']) == '') {
		$errorArray['error'] = 'Name required. ';	
	}
	
	if(isset($_GET['productprice_count']) && trim($_GET['productprice_count']) == '') {
		$errorArray['error'] = 'Quantity required. ';	
	}	
	
	if(isset($_GET['productprice_price']) && trim($_GET['productprice_price']) == '') {
		$errorArray['error'] = 'Price required. ';	
	}	
	
	if(isset($_GET['productprice_description']) && trim($_GET['productprice_description']) == '') {
		$errorArray['error'] = 'Description required. ';	
	}

	if($errorArray['error']  == '') {

		$data 	= array();		
		$data['productprice_name']			= trim($_GET['productprice_name']);			
		$data['productprice_description']	= trim($_GET['productprice_description']);	
		$data['productprice_price']	= trim($_GET['productprice_price']);	
		$data['productprice_count']	= trim($_GET['productprice_count']);	
		
		$where		= array();
		$where[]	= $productpriceObject->getAdapter()->quoteInto('productprice_code = ?', $itemcode);
		$where[]	= $productpriceObject->getAdapter()->quoteInto('product_code = ?', $productData['product_code']);
		$success	= $productpriceObject->update($data, $where);	
		
		if(is_numeric($success) && $success > 0) {		
			$errorArray['error']	= '';
			$errorArray['result']	= 1;			
		} else {
			$errorArray['error']	= 'Could not update, please try again.';
			$errorArray['result']	= 0;				
		}
	}
	
	echo json_encode($errorArray);
	exit;
}

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray	= array();
	$data 			= array();
	$formValid	= true;
	$success		= NULL;
	
	if(isset($_POST['productprice_name']) && trim($_POST['productprice_name']) == '') {
		$errorArray['productprice_name'] = 'Name required';
		$formValid = false;		
	}
	
	if(isset($_POST['productprice_count']) && trim($_POST['productprice_name']) == '') {
		$errorArray['productprice_count'] = 'Quantity required';
		$formValid = false;		
	}
	
	if(isset($_POST['productprice_price']) && trim($_POST['productprice_price']) == '') {
		$errorArray['productprice_price'] = 'Price required';
		$formValid = false;		
	}
	
	if(isset($_POST['productprice_description']) && trim($_POST['productprice_description']) == '') {
		$errorArray['productprice_description'] = 'Description required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
					
		$data['productprice_name'] 			= trim($_POST['productprice_name']);	
		$data['productprice_price'] 		= trim($_POST['productprice_price']);
		$data['productprice_count'] 		= trim($_POST['productprice_count']);
		$data['productprice_description'] 	= trim($_POST['productprice_description']);
		$data['product_code'] 				= $productData['product_code'];
		
		/* Insert. */
		$success = $productpriceObject->insert($data);
							
		if($success) {
			header('Location: /admin/products/prices.php?code='.$productData['product_code']);
			exit;	
		}
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$productpriceData = $productpriceObject->getByProduct($productData['product_code']);

if($productpriceData) {
	$smarty->assign('productpriceData', $productpriceData);
}

/* Display the template */	
$smarty->display('adminclient/MU3H/products/prices.tpl');

?>