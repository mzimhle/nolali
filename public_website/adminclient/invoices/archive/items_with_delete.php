<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';
require_once 'admin_guesthouse/includes/auth.php';

/* objects. */
require_once 'class/campaigninvoice.php';
require_once 'class/campaigninvoiceitem.php';
require_once 'class/campaignproduct.php';

$campaigninvoiceObject			= new class_campaigninvoice();
$campaigninvoiceitemObject 	= new class_campaigninvoiceitem();
$campaignproductObject 		= new class_campaignproduct();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$invoiceData = $campaigninvoiceObject->getByCode($code);

	if(!$invoiceData) {
		header('Location: /admin/invoices/');
		exit;
	}
	$smarty->assign('invoiceData', $invoiceData);
} else {
	header('Location: /admin/invoices/');
	exit;
}

$campaignproductPairs = $campaignproductObject->pairs();
if($campaignproductPairs) $smarty->assign('campaignproductPairs', $campaignproductPairs);

/* Check posted data. */
if(isset($_REQUEST['campaigninvoiceitem_code_delete'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$invoiceitemcode		= trim($_GET['campaigninvoiceitem_code_delete']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {	
		$data	= array();
		$data['campaigninvoiceitem_deleted'] = 1;
		
		$where		= array();
		$where[]	= $campaigninvoiceitemObject->getAdapter()->quoteInto('campaigninvoiceitem_code = ?', $invoiceitemcode);
		$where[]	= $campaigninvoiceitemObject->getAdapter()->quoteInto('campaigninvoice_code = ?', $invoiceData['campaigninvoice_code']);
		
		$success	= $campaigninvoiceitemObject->update($data, $where);	
		
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
if(isset($_GET['campaigninvoiceitem_code_update'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;
	$data 						= array();
	$formValid				= true;
	$success					= NULL;
	$invoiceitemcode		= trim($_GET['campaigninvoiceitem_code_update']);
	
	if(isset($_GET['campaigninvoiceitem_quantity']) && trim($_GET['campaigninvoiceitem_quantity']) == '') {
		$errorArray['error'] = 'quantity required.';	
	}	
	
	if(isset($_GET['campaigninvoiceitem_name']) && trim($_GET['campaigninvoiceitem_name']) == '') {
		$errorArray['error'] = 'name required.';	
	}
	
	if(isset($_GET['campaigninvoiceitem_description']) && trim($_GET['campaigninvoiceitem_description']) == '') {
		$errorArray['error'] = 'description required.';	
	}
	
	if(isset($_GET['campaigninvoiceitem_price']) && (int)trim($_GET['campaigninvoiceitem_price']) == 0) {
		$errorArray['error'] = 'price required.';	
	}
	
	if($errorArray['error']  == '') {

		$data 	= array();		
		$data['campaigninvoiceitem_quantity'] 		= trim($_GET['campaigninvoiceitem_quantity']);		
		$data['campaigninvoiceitem_name'] 			= trim($_GET['campaigninvoiceitem_name']);		
		$data['campaigninvoiceitem_description'] 	= trim($_GET['campaigninvoiceitem_description']);		
		$data['campaigninvoiceitem_price'] 			= (int)trim($_GET['campaigninvoiceitem_price']);		

		$where		= array();
		$where[]	= $campaigninvoiceitemObject->getAdapter()->quoteInto('campaigninvoiceitem_code = ?', $invoiceitemcode);
		$where[]	= $campaigninvoiceitemObject->getAdapter()->quoteInto('campaigninvoice_code = ?', $invoiceData['campaigninvoice_code']);
		$success	= $campaigninvoiceitemObject->update($data, $where);	
		
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
	
	if(isset($_POST['campaignproduct_code']) && $_POST['campaignproduct_code'] == '') {
		$errorArray['campaignproduct_code'] = 'product required.';	
	}	
	
	if(isset($_POST['campaigninvoiceitem_quantity']) && $_POST['campaigninvoiceitem_quantity'] == '') {
		$errorArray['campaigninvoiceitem_quantity'] = 'quantity required.';	
	}	
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();		
		$data['campaignproduct_code'] 				= trim($_POST['campaignproduct_code']);		
		$data['campaigninvoiceitem_quantity'] 	= trim($_POST['campaigninvoiceitem_quantity']);		
		$data['campaigninvoiceitem_code']			= $campaigninvoiceitemObject->createReference();
		$data['campaigninvoice_code']				= $invoiceData['campaigninvoice_code'];
		
		/* Get product. */
		$campaignproductData = $campaignproductObject->getCodeByCampaign($data['campaignproduct_code']);
		
		if($campaignproductData) {
		
			$data['campaigninvoiceitem_description'] 	= $campaignproductData['campaignproduct_shortDescription'];	
			$data['campaigninvoiceitem_name'] 			= $campaignproductData['campaignproduct_name'];
			$data['campaigninvoiceitem_price'] 			= $campaignproductData['campaignproduct_price'];
			
			/* Insert */
			$success = $campaigninvoiceitemObject->insert($data);	
								
			header('Location: /admin/invoices/items.php?code='.$data['campaigninvoice_code']);
			exit();				
		}
	}	
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
}


$campaigninvoiceitemData = $campaigninvoiceitemObject->getByInvoiceCode($invoiceData['campaigninvoice_code']);

if($campaigninvoiceitemData) {
	$smarty->assign('campaigninvoiceitemData', $campaigninvoiceitemData);
}


 /* Display the template
 */	
$smarty->display('admin_guesthouse/invoices/items.tpl');

?>