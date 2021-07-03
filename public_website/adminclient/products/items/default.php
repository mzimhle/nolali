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

error_reporting(!E_ALL);

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

if(isset($_GET['campaignproductitem_code_delete'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$item						= trim($_GET['campaignproductitem_code_delete']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {	
		$data	= array();
		$data['campaignproductitem_deleted'] = 1;
		
		$where = array();
		$where = $campaignproductitemObject->getAdapter()->quoteInto('campaignproduct_code = ?', $campaignproductData['campaignproduct_code']);
		$where = $campaignproductitemObject->getAdapter()->quoteInto('campaignproductitem_code = ?', $item);
		
		$success	= $campaignproductitemObject->update($data, $where);	
		
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

/* Setup Pagination. */
$campaignproductitemData = $campaignproductitemObject->getByProduct($campaignproductData['campaignproduct_code']);

if($campaignproductitemData) $smarty->assign_by_ref('campaignproductitemData', $campaignproductitemData);

/* End Pagination Setup. */


 /* Display the template
 */	
$smarty->display('adminclient/MU3H/products/items/default.tpl');

?>