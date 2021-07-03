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

require_once 'class/_package.php';

$packageObject = new class_package();
 
if(isset($_GET['package_code_delete'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$code						= trim($_GET['package_code_delete']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['_package_deleted'] = 1;
		
		$where = $packageObject->getAdapter()->quoteInto('_package_code = ?', $code);
		
		$success	= $packageObject->update($data, $where);	
		
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
$packageData = $packageObject->getAll();

$smarty->assign_by_ref('packageData', $packageData);

/* End Pagination Setup. */


$smarty->display('products/package/default.tpl');

?>