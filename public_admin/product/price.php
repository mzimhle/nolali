<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';
/* Other resources. */
require_once 'class/product.php';
require_once 'class/price.php';

$productObject	= new class_product();
$priceObject	= new class_price();

if(isset($_GET['id']) && trim($_GET['id']) != '') {

	$id = trim($_GET['id']);

	$productData = $productObject->getById($id);
	
	if(!$productData) {
		header('Location: /');
		exit;
	}

	$smarty->assign('productData', $productData);
	
	$priceData = $priceObject->getByProduct($id);

	if($priceData) {
		$smarty->assign('priceData', $priceData);
	}
} else {
	header('Location: /product/');
	exit;
}

if(isset($_GET['delete_id'])) {

	$errors				= array();
	$errors['error']	= '';
	$errors['result']	= 1;
	$deactivate				= trim($_GET['delete_id']);
	/* The delete if not. */
	if($errors['error']  == '' && $errors['result']  == 1 ) {

		$data					= array();
		$data['price_active']	= 0;
		$data['price_date_end']	= date('Y-m-d H:i:s');

		$where		= array();
		$where[]	= $priceObject->getAdapter()->quoteInto('price_id = ?', $deactivate);
		$priceObject->update($data, $where);
	}

	echo json_encode($errors);
	exit;
}
/* Check posted data. */
if(count($_POST) > 0) {

	$errors	= array();
	/* The price. */
	if(!isset($_POST['price_original'])) {
		$errors[] = 'Price amount is required';
	} else if(trim($_POST['price_original']) == '') {
		$errors[] = 'Price amount is required';
	} else if($priceObject->validateAmount(trim($_POST['price_original'])) == null) {
		$errors[] = 'Amount needs to be a valid decimal, e.g. 453.23';
	}
    
	if(!isset($_POST['price_quantity'])) {
		$errors[] = 'Quantity is required';
	} else if((int)trim($_POST['price_quantity']) == 0) {
		$errors[] = 'Quantity is required';
	}	
    
	if(!isset($_POST['price_type'])) {
		$errors[] = 'Monthly or once off payment';
	} else if(trim($_POST['price_type']) == '') {
		$errors[] = 'Monthly or once off payment';
	}	
    
	/* The discount. */
	if(isset($_POST['price_discount']) && trim($_POST['price_discount']) != '0') {
		if((int)trim($_POST['price_discount']) == 0) {
			$errors[] = 'Please add a valid discount number from 0 and 100';
		} else if((int)trim($_POST['price_discount']) > 101) {
			$errors[] = 'Please add a valid discount number from 0 and 100';
		}
	}

	if(count($errors) == 0) {

		$data					= array();
		$data['product_id']		= $productData['product_id'];		
		$data['price_original']	= trim($_POST['price_original']);
		$data['price_type']	    = trim($_POST['price_type']);
		$data['price_quantity']	= trim($_POST['price_quantity']);   
		$data['price_name']	    = trim($_POST['price_name']);        
		$data['price_discount']	= (int)trim($_POST['price_discount']);

		$success	= $priceObject->insert($data);			

		if($success) {
			header('Location: /product/price.php?id='.$productData['product_id']);
			exit;
		}

	}
	/* if we are here there are errors. */
	$smarty->assign('errors', implode('<br />', $errors));
}

$smarty->display('product/price.tpl');
?>