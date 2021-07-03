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
require_once 'class/product.php';
require_once 'class/productitem.php';

$productObject 			= new class_product();
$productitemObject 	= new class_productitem();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$productitemData = $productitemObject->getByCode($code);

	if($productitemData) {
		
		$smarty->assign('productitemData', $productitemData);

	} else {
		header('Location: /website/catalogue/item/');
		exit;
	}
}

$productpairs = $productObject->pairs();
if($productpairs) $smarty->assign('productpairs', $productpairs);

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray		= array();
	$data 				= array();
	$formValid		= true;
	$success			= NULL;
	$areaByName	= NULL;
	
	if(isset($_POST['productitem_name']) && trim($_POST['productitem_name']) == '') {
		$errorArray['productitem_name'] = 'Name is required';
		$formValid = false;		
	}
	
	if(isset($_POST['product_code']) && trim($_POST['product_code']) == '') {
		$errorArray['product_code'] = 'Product is required';
		$formValid = false;		
	}
	
	if(isset($_POST['productitem_description']) && trim($_POST['productitem_description']) == '') {
		$errorArray['productitem_description'] = 'Description is required';
		$formValid = false;		
	}

	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();
		$data['productitem_name'] 		= trim($_POST['productitem_name']);	
		$data['product_code'] 				= trim($_POST['product_code']);
		$data['productitem_description'] 	= trim($_POST['productitem_description']);	
		$data['productitem_page'] 			= htmlspecialchars_decode(stripslashes(trim($_POST['productitem_page'])));			

		if(isset($productitemData)) {
			/*Update. */
			$where		= array();
			$where[]		= $productitemObject->getAdapter()->quoteInto('productitem_code = ?', $productitemData['productitem_code']);
			$where[]		= $productitemObject->getAdapter()->quoteInto('campaign_code = ?', $zfsession->domainData['campaign_code']);
			$success	= $productitemObject->update($data, $where);		
			$success 	= $productitemData['productitem_code'];
		} else {
			$success = $productitemObject->insert($data);			
		}					
		
		if(count($errorArray) == 0) {							
			header('Location: /website/catalogue/item/price.php?productitem='.$success);				
			exit;		
		}
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('website/catalogue/item/details.tpl');

?>