<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/**
 * Check for login
 */
require_once 'includes/auth.php';
require_once 'class/participantcategory.php';

$participantcategoryObject = new class_participantcategory();
 
 if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$code						= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['participantcategory_deleted'] = 1;
		
		$where 	= array();
		$where[] 	= $participantcategoryObject->getAdapter()->quoteInto('campaign_code = ?', $zfsession->domainData['campaign_code']);
		$where[] 	= $participantcategoryObject->getAdapter()->quoteInto('participantcategory_code = ?', $code);
		$success	= $participantcategoryObject->update($data, $where);	
		
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
$participantcategoryData = $participantcategoryObject->getAll();
if($participantcategoryData) $smarty->assign_by_ref('participantcategoryData', $participantcategoryData);

/* End Pagination Setup. */

$smarty->display('website/people/type/default.tpl');
?>