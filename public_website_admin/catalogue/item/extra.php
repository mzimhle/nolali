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
require_once 'class/productitem.php';
require_once 'class/productitemdata.php';

$productitemObject			= new class_productitem();
$productitemdataObject		= new class_productitemdata();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$productitemData = $productitemObject->getByCode($code);
	
	if(!$productitemData) {
		header('Location: /catalogue/item/');
		exit;
	}
	
	$smarty->assign('productitemData', $productitemData);
	
	$productitemdataData = $productitemdataObject->getByItem($code);

	if($productitemdataData) {
		$smarty->assign('productitemdataData', $productitemdataData);
	}
} else {
	header('Location: /catalogue/item/');
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
		$data['productitemdata_deleted'] = 1;
		
		$where 	= array();
		$where[]	= $productitemdataObject->getAdapter()->quoteInto('campaign_code = ?', $zfsession->domainData['campaign_code']);
		$where[]	= $productitemdataObject->getAdapter()->quoteInto('productitemdata_code = ?', $code);
		$success	= $productitemdataObject->update($data, $where);	
		
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
if(count($_POST) > 0) {

	$errorArray	= array();
	$data 			= array();
	$formValid	= true;
	$success		= NULL;

	if(isset($_POST['productitemdata_type']) && trim($_POST['productitemdata_type']) == '') {
		$errorArray['productitemdata_type'] = 'Type is required';
		$formValid = false;		
	}
	
	if(isset($_POST['productitemdata_name']) && trim($_POST['productitemdata_name']) == '') {
		$errorArray['productitemdata_name'] = 'Name is required';
		$formValid = false;		
	}
	
	if(isset($_POST['productitemdata_description']) && trim($_POST['productitemdata_description']) == '') {
		$errorArray['productitemdata_description'] = 'Description is required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data = array();
		$data['productitemdata_type'] 			= trim($_POST['productitemdata_type']);
		$data['productitemdata_name'] 			= trim($_POST['productitemdata_name']);
		$data['productitemdata_description'] 	= trim($_POST['productitemdata_description']);
		$data['productitem_code']					= $productitemData['productitem_code'];

		$success	= $productitemdataObject->insert($data);			
		
		if($success) {
			header('Location: /catalogue/item/extra.php?code='.$productitemData['productitem_code']);
			exit;
		}

	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
	
}

$smarty->display('catalogue/item/extra.tpl');


?>