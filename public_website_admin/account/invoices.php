<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/*** Check for login */ 
require_once 'includes/auth.php';

require_once 'class/invoice.php';

$invoiceObject = new class_invoice();

if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$code						= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
	
		$data	= array();
		$data['invoice_deleted'] = 1;
		$data['invoice_active'] = 0;
		
		$where 	= array();
		$where[] 	= $invoiceObject->getAdapter()->quoteInto('invoice_code = ?', $code);
		$where[] 	= $invoiceObject->getAdapter()->quoteInto('account_code = ?', $zfsession->identity);
		$success	= $invoiceObject->update($data, $where);	
		
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
$invoiceData = $invoiceObject->getByAccount($zfsession->identity);

if($invoiceData) $smarty->assign_by_ref('invoiceData', $invoiceData);

/* End Pagination Setup. */
$smarty->display('account/invoices.tpl');

?>