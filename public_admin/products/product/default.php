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

require_once 'class/_product.php';

$productObject = new class_product();
 
if(isset($_GET['product_code_delete'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$code						= trim($_GET['product_code_delete']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
	
		$data	= array();
		$data['_product_deleted'] = 1;
		
		$where = $productObject->getAdapter()->quoteInto('_product_code = ?', $code);
		
		$success	= $productObject->update($data, $where);	
		
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
$productData = $productObject->getAll();

$smarty->assign_by_ref('productData', $productData);

/* End Pagination Setup. */


$smarty->display('products/product/default.tpl');

?>