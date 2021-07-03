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
require_once 'class/productitem.php';
require_once 'class/File.php';

$productObject			= new class_product();
$productitemObject		= new class_productitem();

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
if(isset($_GET['productitem_code_delete'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$itemcode					= trim($_GET['productitem_code_delete']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {	
		$data	= array();
		$data['productitem_deleted'] = 1;
		
		$where		= array();
		$where[]	= $productitemObject->getAdapter()->quoteInto('productitem_code = ?', $itemcode);
		$where[]	= $productitemObject->getAdapter()->quoteInto('product_code = ?', $productData['product_code']);
		
		$success	= $productitemObject->update($data, $where);	
		
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
if(isset($_GET['productitem_code_update'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;
	$data 						= array();
	$formValid				= true;
	$success					= NULL;
	$itemcode	= trim($_GET['productitem_code_update']);
	
	if(isset($_GET['productitem_name']) && trim($_GET['productitem_name']) == '') {
		$errorArray['error'] = 'name required. ';	
	}
	
	if($errorArray['error']  == '') {

		$data 	= array();		
		$data['productitem_name']			= trim($_GET['productitem_name']);			
		
		$where		= array();
		$where[]	= $productitemObject->getAdapter()->quoteInto('productitem_code = ?', $itemcode);
		$where[]	= $productitemObject->getAdapter()->quoteInto('product_code = ?', $productData['product_code']);
		$success	= $productitemObject->update($data, $where);	
		
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
		
		if(isset($_POST['productitem_name']) && trim($_POST['productitem_name']) == '') {
			$errorArray['productitem_name'] = 'name required.';	
		}
		
		if(count($errorArray) == 0 && $formValid == true) {
			
			$data 	= array();
			$data['productitem_name'] 			= trim($_POST['productitem_name']);	
			$data['product_code'] 				= $productData['product_code'];
		
			/* Insert */
			$success = $productitemObject->insert($data);	

			header('Location: /admin/products/items.php?code='.$productData['product_code']);
			exit();				

		}
		
		/* if we are here there are errors. */
		$smarty->assign('errorArray', $errorArray);
	
}

$productitemData = $productitemObject->getByProduct($productData['product_code']);

if($productitemData) {
	
	$smarty->assign('productitemData', $productitemData);
}
 /* Display the template
 */	
$smarty->display('adminclient/MU3H/products/items.tpl');

?>