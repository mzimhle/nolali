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
require_once 'class/invoice.php';
require_once 'class/invoiceitem.php';

$invoiceObject			= new class_invoice();
$invoiceitemObject		= new class_invoiceitem();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$invoiceData = $invoiceObject->getByCode($code);

	if(!$invoiceData) {
		header('Location: /invoice/');
		exit;
	}
	
	$smarty->assign('invoiceData', $invoiceData);
	
	$invoiceitemData = $invoiceitemObject->getByInvoice($code);

	if($invoiceitemData) {
		$smarty->assign('invoiceitemData', $invoiceitemData);
	}
} else {
	header('Location: /invoice/');
	exit;
}

if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$code						= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['invoiceitem_deleted'] = 1;
		
		$where 	= array();
		$where[]	= $invoiceitemObject->getAdapter()->quoteInto('invoice_code = ?', $invoiceData['invoice_code']);
		$where[]	= $invoiceitemObject->getAdapter()->quoteInto('invoiceitem_code = ?', $code);
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

 if(isset($_POST['update_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 1;	
	$formValid				= true;
	$success					= NULL;
	$code						= trim($_POST['update_code']);
	
	if(!isset($_POST['name'])) {
		$errorArray['error']	= 'Please add a name';
		$errorArray['result']	= 0;		
	} else if(trim($_POST['name']) == ''){
		$errorArray['error']	= 'Please add a name';
		$errorArray['result']	= 0;			
	}
	
	if(!isset($_POST['description'])) {
		$errorArray['error']	= 'Please add a description';
		$errorArray['result']	= 0;		
	} else if(trim($_POST['description']) == ''){
		$errorArray['error']	= 'Please add a description';
		$errorArray['result']	= 0;			
	}

	if(!isset($_POST['price'])) {
		$errorArray['error']	= 'Please add a price';
		$errorArray['result']	= 0;		
	} else if((int)trim($_POST['price']) == 0){
		$errorArray['error']	= 'Please add a price';
		$errorArray['result']	= 0;			
	}
	
	if(!isset($_POST['quantity'])) {
		$errorArray['error']	= 'Please add a quantity';
		$errorArray['result']	= 0;		
	} else if((int)trim($_POST['quantity']) == 0){
		$errorArray['error']	= 'Please add a quantity';
		$errorArray['result']	= 0;			
	}
	
	$invoiceitemData = $invoiceitemObject->getByCode($code);

	if(!$invoiceitemData) {
		$errorArray['error']	= 'This is not a valid item to update';
		$errorArray['result']	= 0;			
	}
	
	if($errorArray['error']  == '' && $errorArray['result']  == 1 ) {
	
		$data	= array();
		$data['invoiceitem_name']			= trim($_POST['name']);	
		$data['invoiceitem_amount']		= trim($_POST['price']);	
		$data['invoiceitem_quantity']		= trim($_POST['quantity']);	
		$data['invoiceitem_description']	= trim($_POST['description']);
		
		$where			= array();
		$where[]		= $invoiceitemObject->getAdapter()->quoteInto('invoiceitem_code = ?', $invoiceitemData['invoiceitem_code']);
		$where[]		= $invoiceitemObject->getAdapter()->quoteInto('invoice_code = ?', $invoiceData['invoice_code']);
		$success 		= $invoiceitemObject->update($data, $where);	
		
		if(!$success) {
			$errorArray['error']	= 'Could not delete, please try again.';
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

	if(isset($_POST['invoiceitem_name']) && trim($_POST['invoiceitem_name']) == '') {
		$errorArray['invoiceitem_name'] = 'Name is required';
		$formValid = false;		
	}
	
	if(isset($_POST['invoiceitem_description']) && trim($_POST['invoiceitem_description']) == '') {
		$errorArray['invoiceitem_description'] = 'Description is required';
		$formValid = false;		
	}
	
	if(isset($_POST['invoiceitem_quantity']) && trim($_POST['invoiceitem_quantity']) == '') {
		$errorArray['invoiceitem_quantity'] = 'Quantity is required';
		$formValid = false;		
	}
	
	if(isset($_POST['invoiceitem_amount']) && (int)trim($_POST['invoiceitem_amount']) == 0) {
		$errorArray['invoiceitem_amount'] = 'Amount is required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data = array();
		$data['invoiceitem_name'] 			= trim($_POST['invoiceitem_name']);
		$data['invoiceitem_quantity'] 		= trim($_POST['invoiceitem_quantity']);
		$data['invoiceitem_description'] 	= trim($_POST['invoiceitem_description']);
		$data['invoiceitem_amount'] 		= trim($_POST['invoiceitem_amount']);
		$data['invoice_code']					= $invoiceData['invoice_code'];

		$success	= $invoiceitemObject->insert($data);			
		
		if($success) {
			header('Location: /invoice/item.php?code='.$invoiceData['invoice_code']);
			exit;
		}
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
	
}

$smarty->display('invoice/item.tpl');


?>