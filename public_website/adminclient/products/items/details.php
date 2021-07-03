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

require_once 'class/MU3H/campaignproductitem.php';
require_once 'class/MU3H/campaignproduct.php';

$campaignproductitemObject		= new class_campaignproductitem();
$campaignproductObject	= new class_campaignproduct();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$campaignproductData = $campaignproductObject->getByCode($code);

	if(!$campaignproductData) {
		header('Location: /admin/products/');
		exit;
	}
	
	$smarty->assign('campaignproductData', $campaignproductData);
} else {
	header('Location: /admin/products/');
	exit;
}

if (isset($_GET['item']) && trim($_GET['item']) != '') {
	
	$item = trim($_GET['item']);
	
	$campaignproductitemData = $campaignproductitemObject->getByCode($item);

	if(!$campaignproductitemData) {
		header('Location: /admin/products/');
		exit;
	}
	
	$smarty->assign('campaignproductitemData', $campaignproductitemData);
	
}

/* Check posted data. */
if(count($_POST) > 0) {
	
	$errorArray		= array();
	$data 				= array();
	$formValid		= true;
	$success			= NULL;
	
	if(isset($_POST['campaignproductitem_name']) && trim($_POST['campaignproductitem_name']) == '') {
		$errorArray['campaignproductitem_name'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['campaignproductitem_description']) && trim($_POST['campaignproductitem_description']) == '') {
		$errorArray['campaignproductitem_description'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['campaignproductitem_price']) && (int)trim($_POST['campaignproductitem_price']) == 0) {
		$errorArray['campaignproductitem_price'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['campaignproductitem_description']) && trim($_POST['campaignproductitem_description']) == '') {
		$errorArray['campaignproductitem_description'] = 'required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();						
		$data['campaignproductitem_name']			= trim($_POST['campaignproductitem_name']);		
		$data['campaignproductitem_description']	= trim($_POST['campaignproductitem_description']);				
		$data['campaignproductitem_price']			= trim($_POST['campaignproductitem_price']);
		$data['campaignproductitem_active']			= isset($_POST['campaignproductitem_active']) && trim($_POST['campaignproductitem_active']) == 1 ? 1 : 0;
		
		if(isset($campaignproductitemData)) {
		
			/*Update. */
			$where		= array();
			$where[]		= $campaignproductitemObject->getAdapter()->quoteInto('campaignproductitem_code = ?', $campaignproductitemData['campaignproductitem_code']);
			$where[]		= $campaignproductitemObject->getAdapter()->quoteInto('campaignproduct_code = ?', $campaignproductData['campaignproduct_code']);
			
			$success	= $campaignproductitemObject->update($data, $where);
							
			
		} else {
		
			$data['campaignproduct_code']				= $campaignproductData['campaignproduct_code'];
			$data['campaign_code'] 							= $zfsession->domainData['campaign_code'];			
			$data['campaignproductitem_code']			= $campaignproductitemObject->createReference();
			
			$success = $campaignproductitemObject->insert($data);
							
		}
			
		header('Location: /admin/products/items/?code='.$campaignproductData['campaignproduct_code']);
		exit;	
		
	}

	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}
 /* Display the template  */	
$smarty->display('adminclient/MU3H/products/items/details.tpl');
?>