<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/* Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/* Check for login */
require_once 'includes/auth.php';

/* objects. */
require_once 'class/gallerytype.php';

$gallerytypeObject = new class_gallerytype();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$gallerytypeData = $gallerytypeObject->getByCode($code);

	if($gallerytypeData) {
		$smarty->assign('gallerytypeData', $gallerytypeData);
	} else {
		header('Location: /website/gallery/type/');
		exit;
	}
}

/* Check posted data. */
if(count($_POST) > 0) {
	$errorArray	= array();
	$data 		= array();
	$formValid	= true;
	$success	= NULL;
	
	if(isset($_POST['gallerytype_name']) && trim($_POST['gallerytype_name']) == '') {
		$errorArray['gallerytype_name'] = 'Name is required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
	
		$data 	= array();				
		$data['gallerytype_name']			= trim($_POST['gallerytype_name']);				
		
		if(isset($gallerytypeData)) {
			$where		= $gallerytypeObject->getAdapter()->quoteInto('gallerytype_code = ?', $gallerytypeData['gallerytype_code']);
			$success	= $gallerytypeObject->update($data, $where);			
		} else {
			$success = $gallerytypeObject->insert($data);
		}

		header('Location: /website/gallery/type/');	
		exit;		
		
		
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('website/gallery/type/details.tpl');

?>