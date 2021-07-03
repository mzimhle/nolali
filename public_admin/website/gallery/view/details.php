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

/* objects. */
require_once 'class/gallery.php';
require_once 'class/gallerytype.php';

$galleryObject 				= new class_gallery();
$gallerytypeObject 		= new class_gallerytype();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$galleryData = $galleryObject->getByCode($code);

	if($galleryData) {
		
		$smarty->assign('galleryData', $galleryData);

	} else {
		header('Location: /website/gallery/view/');
		exit;
	}
}

$gallerytypepairs = $gallerytypeObject->pairs();
if($gallerytypepairs) $smarty->assign('gallerytypepairs', $gallerytypepairs);

/* Check posted data. */
if(count($_POST) > 0) {
	$errorArray		= array();
	$data 			= array();
	$formValid		= true;
	$success		= NULL;
	$areaByName		= NULL;
	
	if(isset($_POST['gallery_name']) && trim($_POST['gallery_name']) == '') {
		$errorArray['gallery_name'] = 'Name is required';
		$formValid = false;		
	}

	if(isset($_POST['gallerytype_code']) && trim($_POST['gallerytype_code']) == '') {
		$errorArray['gallerytype_code'] = 'Type is required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();		
		$data['gallery_name'] 			= trim($_POST['gallery_name']);	
		$data['gallerytype_code'] 		= trim($_POST['gallerytype_code']);	
		$data['gallery_description'] 	= htmlspecialchars_decode(stripslashes(trim($_POST['gallery_description'])));			
		
		if(isset($galleryData)) {
		
			/*Update. */
			$where		= $galleryObject->getAdapter()->quoteInto('gallery_code = ?', $galleryData['gallery_code']);
			$success	= $galleryObject->update($data, $where);						
			$success	= $galleryData['gallery_code'];
			
		} else {
			$success = $galleryObject->insert($data);			
		}
		
		if(count($errorArray) == 0) {							
			header('Location: /website/gallery/view/image.php?code='.$galleryData['gallery_code']);		
			exit;		
		}			
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('website/gallery/view/details.tpl');

?>