<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';

require_once 'class/invoicemonthly.php';
require_once 'class/invoiceitem.php';

$invoicemonthlyObject	= new class_invoicemonthly();
$invoiceitemObject	= new class_invoiceitem();

if (!empty($_GET['id']) && $_GET['id'] != '') {
	
	$id = trim($_GET['id']);
	
	$invoicemonthlyData = $invoicemonthlyObject->getById($id);
	
	if($invoicemonthlyData) {
		$smarty->assign('invoicemonthlyData', $invoicemonthlyData);

		$invoiceitemData = $invoiceitemObject->getByMonthlyInvoice($id);

		if($invoiceitemData) {
			$smarty->assign('invoiceitemData', $invoiceitemData);
		}
	} else {
		header('Location: /invoice/monthly/');
		exit;	
	}
} else {
	header('Location: /invoice/monthly/');
	exit;
}

if(isset($_GET['getproducts'])) {

	require_once 'class/product.php';

	$productObject	= new class_product();
	
	$html = "<select id='invoiceproduct' name='invoiceproduct' class='form-control is-invalid'>";
	$productData = $productObject->getAll();
	if($productData) {
		$html .= "<option value=''> --- </option>";
		foreach($productData as $item) {
			$html .= "<option value='".$item['product_id']."'> ".$item['product_name']." </option>";
		}
	} else {
		$html = "<option value=''> --- No products added --- </option>";
	}
	$html .= '</select>';
	echo $html; 
	exit;
}

if(isset($_GET['addproduct'])) {
	
	require_once 'class/product.php';
	require_once 'class/price.php';
	
	$productObject	= new class_product();
	$priceObject	= new class_price();
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$errors					= array();
	
	if(!isset($_GET['modal_product_id'])) {
		$errors[] = 'Please select a product';	
	} else if(trim($_GET['modal_product_id']) == '') {
		$errors[] = 'Please select a product';	
	} else {
		$productData = $productObject->getById(trim($_GET['modal_product_id']));
		
		if(!$productData) {
			$errors[] = 'Product was not found';	
		} else {
			if(!isset($_GET['modal_product_price'])) {
				$errors[] = 'Please select a price';	
			} else if(trim($_GET['modal_product_price']) == '') {
				$errors[] = 'Please select a price';	
			} else {
				$priceData = $priceObject->getProductPrice($productData['product_id'], trim($_GET['modal_product_price']));
				if(!$priceData) {
					$errors[] = 'Price was not found';	
				}
			}

			if(!isset($_GET['modal_product_quantity'])) {
				$errors[] = 'Please add the quantity';	
			} else if(trim($_GET['modal_product_quantity']) == '') {
				$errors[] = 'Please add the quantity';	
			} else if((int)trim($_GET['modal_product_quantity']) == 0) {
				$errors[] = 'Please add the quantity';	
			} else if((int)$productData['product_left'] == 0 && $productData['product_type'] == 'ITEM') {
				$errors[] = 'There are no available items for this product';	
			} else if((int)trim($_GET['modal_product_quantity']) > (int)$productData['product_left'] && $productData['product_type'] == 'ITEM') {
				$errors[] = 'You have entered too many items, the available limit is '.(int)$productData['product_left'];	
			}
		}
	}

	if(count($errors)  == 0) {
		$data                               = array();	
		$data['invoicemonthly_id']			= $invoicemonthlyData['invoicemonthly_id'];		
		$data['price_id']					= trim($priceData['price_id']);
		$data['invoiceitem_title']          = trim($productData['product_name']);			
		$data['invoiceitem_text']		    = trim($productData['product_text']);			
		$data['invoiceitem_amount_unit']    = trim($priceData['price_amount']);	
		$data['invoiceitem_quantity']       = trim($_GET['modal_product_quantity']);	

		$success = $invoiceitemObject->insert($data);

		if(!$success) {
			$errors[] = 'Could not add the product, try again.';		
		} else {
			$errorArray['result']	= 1;	
		}
	}

	$errorArray['error'] = implode('', $errors);	

	echo json_encode($errorArray);
	exit;
}

 if(isset($_GET['delete_id'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success				= NULL;
	$code					= trim($_GET['delete_id']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['invoiceitem_deleted'] = 1;
		
		$where = array();
		$where[] = $invoiceitemObject->getAdapter()->quoteInto('invoiceitem_id = ?', $code);
		$where[] = $invoiceitemObject->getAdapter()->quoteInto('invoicemonthly_id = ?', $invoicemonthlyData['invoicemonthly_id']);
		$success	= $invoiceitemObject->update($data, $where);	
		
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


$smarty->display('invoice/monthly/item.tpl');

?>