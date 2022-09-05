<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';
/* Class files */
require_once 'class/content.php';
/* Class objects */
$contentObject		= new class_content(); 

if(isset($_GET['id']) && trim($_GET['id']) != '') {

	$id		= trim($_GET['id']);
	$contentData	= $contentObject->getById($id);

	if($contentData) {
		$smarty->assign('contentData', $contentData);
	} else {
		header('Location: /');
		exit;		
	}
}
/* Check posted data. */
if(count($_POST) > 0) {

	$errors	= array();
	$data		= array();

	if(!isset($_POST['content_name'])) {
		$errors[] = 'Please add name of the content';	
	} else if(trim($_POST['content_name']) == '') {
		$errors[] = 'Please add name of the content';	
	}
    
	if(count($errors) == 0) {
		/* Add the details. */
		$data                   = array();				
		$data['content_name']	= trim($_POST['content_name']);
        $data['content_type']	= 'GALLERY';			
		/* Insert or update. */
		if(!isset($contentData)) {
			/* Insert */
			$success = $contentObject->insert($data);
			/* Check if all is well. */
			if(!$success) {
				$errors[] = 'We could not add the content, please try again.';
			}
		} else {
			$where		= $contentObject->getAdapter()->quoteInto('content_id = ?', $contentData['content_id']);
			$contentObject->update($data, $where);		
			$success	= $contentData['content_id'];			
		}
	}
	/* Check errors and redirect if there are non. */
	if(count($errors) != 0) {
		/* if we are here there are errors. */
		$smarty->assign('errors', implode('<br />', $errors));
	} else {
		header('Location: /content/gallery/media.php?id='.$success);
		exit;
	}
}

$smarty->display('content/gallery/details.tpl');
?>