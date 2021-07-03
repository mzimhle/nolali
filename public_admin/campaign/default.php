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

require_once 'class/campaign.php';


$campaignObject = new class_campaign();
 
if(isset($_GET['status_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$code						= trim($_GET['status_code']);
	$status						= (int)trim($_GET['status']);
	
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['campaign_active'] = $status;
		
		$where = $campaignObject->getAdapter()->quoteInto('campaign_code = ?', $code);
		$success	= $campaignObject->update($data, $where);	
		
		if(is_numeric($success) && $success > 0) {
			$errorArray['error']	= '';
			$errorArray['result']	= 1;			
		} else {
			$errorArray['error']	= 'Could not change status, please try again.';
			$errorArray['result']	= 0;				
		}
	}
	
	echo json_encode($errorArray);
	exit;
}

/* Setup Pagination. */
$campaignData = $campaignObject->getAll();

$smarty->assign_by_ref('campaignData', $campaignData);

/* End Pagination Setup. */


$smarty->display('campaign/default.tpl');

?>