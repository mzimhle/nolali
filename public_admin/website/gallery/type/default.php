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
require_once 'class/gallerytype.php';

$gallerytypeObject = new class_gallerytype();
 
 if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$code						= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['gallerytype_deleted'] = 1;
		
		$where 	= array();
		$where[] 	= $gallerytypeObject->getAdapter()->quoteInto('campaign_code = ?', $zfsession->domainData['campaign_code']);
		$where[] 	= $gallerytypeObject->getAdapter()->quoteInto('gallerytype_code = ?', $code);
		$success	= $gallerytypeObject->update($data, $where);	
		
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
$gallerytypeData = $gallerytypeObject->getAll();
if($gallerytypeData) $smarty->assign_by_ref('gallerytypeData', $gallerytypeData);

/* End Pagination Setup. */

$smarty->display('website/gallery/type/default.tpl');
?>