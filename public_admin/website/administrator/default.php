<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

//error_reporting(!E_ALL);

/**
 * Check for login
 */
require_once 'includes/auth.php';

require_once 'class/administrator.php';

$administratorObject = new class_administrator();

 if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$code						= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['administrator_deleted'] = 1;
		
		$where = $administratorObject->getAdapter()->quoteInto('administrator_code = ?', $code);
		$success	= $administratorObject->update($data, $where);	
		
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

if(isset($_GET['login_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	
	if (isset($_GET['login_code']) && trim($_GET['login_code']) != '') {
		
		$code = trim($_GET['login_code']);
		
		$administratorData = $administratorObject->getByCode($code);

		if(!$administratorData) {
			$errorArray['error']	= 'Administrator does not exist.';
			$errorArray['result']	= 1;	
		}
	} else {
		$errorArray['error']	= 'Administrator does not exist.';
		$errorArray['result']	= 1;		
	}
	
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {	
		
		require_once 'class/_comm.php';
		
		$commObject = new class_comm();
		
		$administratorData['_custom_reference']		= $administratorData['administrator_code'];	
		$administratorData['_custom_category']		= 'ADMINISTRATOR';	
		$administratorData['_comm_reference']		= 'ADMINISTRATOR_PASSWORD';

		$success = $commObject->sendEmailAdmin($administratorData, null, 'Username and Password for '.$administratorData['campaign_company'].' administrator', 'templates/'.$administratorObject->_campaign->_campaigncode.'/administrator/login.html');
			
		if($success) {
			$errorArray['error']	= '';
			$errorArray['result']	= 1;			
		} else {
			$errorArray['error']	= 'Could not send email, error.';
			$errorArray['result']	= 0;				
		}
	}
	
	echo json_encode($errorArray);
	exit;
}


/* Setup Pagination. */
$administratorData = $administratorObject->getAll();

$smarty->assign_by_ref('administratorData', $administratorData);

/* End Pagination Setup. */ 
$smarty->display('website/administrator/default.tpl');
?>