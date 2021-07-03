<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';

require_once 'class/client.php';

$clientObject = new class_client();

/* Setup Pagination. */
$clientData = $clientObject->getAll();
if($clientData) $smarty->assign('clientData', $clientData);

if(isset($_GET['delete_code'])) {

	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success				= NULL;
	$code					= trim($_GET['delete_code']);

	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['client_deleted'] = 1;
		
		$where 	= $clientObject->getAdapter()->quoteInto('client_code = ?', $code);
		$success	= $clientObject->update($data, $where);	
		
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

/* Display the template */	
$smarty->display('client/default.tpl');

?>