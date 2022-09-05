<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';
/* Other resources. */
require_once 'class/content.php';
require_once 'class/media.php';
require_once 'class/File.php';

$contentObject	= new class_content();
$mediaObject	= new class_media();
$fileObject		= new File(array('png', 'jpg', 'jpeg'));

if(isset($_GET['id']) && trim($_GET['id']) != '') {

	$id = trim($_GET['id']);

	$contentData = $contentObject->getById($id);
	
	if(!$contentData) {
		header('Location: /');
		exit;
	}

	$smarty->assign('contentData', $contentData);
	
	$mediaData = $mediaObject->getByType('CONTENT', $id);

	if($mediaData) {
		$smarty->assign('mediaData', $mediaData);
	}
} else {
	header('Location: /content/gallery/');
	exit;
}

if(isset($_GET['delete_id'])) {

	$errors				= array();
	$errors['error']	= '';
	$errors['result']	= 1;
	$deactivate				= trim($_GET['delete_id']);
	/* The delete if not. */
	if($errors['error']  == '' && $errors['result']  == 1 ) {

		$data					= array();
		$data['media_deleted']	= 1;

		$where		= array();
		$where[]	= $mediaObject->getAdapter()->quoteInto('media_id = ?', $deactivate);
		$mediaObject->update($data, $where);
	}

	echo json_encode($errors);
	exit;
}

/* Check posted data. */
if(isset($_GET['status_id'])) {

	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;
	$id                     = trim($_GET['status_id']);

	$mediaData = $mediaObject->getById($id);

	if($mediaData) {
		$mediaObject->updatePrimary('CONTENT', $contentData['content_id'], $mediaData['media_id'], $mediaData['media_category']);	
	} else {
		$errorArray['error']	= 'Did not update.';
		$errorArray['result']	= 1;		
	}

	$errorArray['error']	= '';
	$errorArray['result']	= 1;				

	echo json_encode($errorArray);
	exit;
}

/* Check posted data. */
if(count($_FILES) > 0 && isset($_FILES['mediafiles'])) {

	$errorArray	= array();

	if(isset($_FILES['mediafiles']['name']) && count($_FILES['mediafiles']['name']) > 0) {
		for($i = 0; $i < count($_FILES['mediafiles']['name']); $i++) {
			if((int)$_FILES['mediafiles']['size'][$i] != 0 && trim($_FILES['mediafiles']['name'][$i]) != '') {
				/* Check if its the right file. */
				$ext = $fileObject->file_extention($_FILES['mediafiles']['name'][$i]); 
				if($ext != '') {
					$checkExt = $fileObject->getValidateExtention('mediafiles', $ext, $i);
					if(!$checkExt) {
						$errorArray[] = 'Invalid file type something funny with the file format';					
					}
				} else {
					$errorArray[] = 'Invalid file type';								
				}
			} else {			
				switch((int)$_FILES['mediafiles']['error'][$i]) {
					case 1 : $errorArray[] = 'The uploaded file exceeds the maximum upload file size, should be less than 1M';
					case 2 : $errorArray[] = 'File size exceeds the maximum file size';
					case 3 : $errorArray[] = 'File was only partically uploaded, please try again';
					case 4 : $errorArray[] = 'No file was uploaded';
					case 6 : $errorArray[] = 'Missing a temporary folder';
					case 7 : $errorArray[] = 'Faild to write file to disk';
				}
			}
		}
	}

	if(count($errorArray) == 0) {
		if(isset($_FILES['mediafiles']) && count($_FILES['mediafiles']['name']) > 0) {
			for($i = 0; $i < count($_FILES['mediafiles']['name']); $i++) {
				$data 								= array();
				$data['media_code']			= $mediaObject->createCode();		
				$data['media_item_id']      = $contentData['content_id'];
				$data['media_item_type']    = 'CONTENT';
				$data['media_category']		= 'IMAGE';
                $data['media_text']         = trim($_POST['media_text']);
                
				$ext		= strtolower($fileObject->file_extention($_FILES['mediafiles']['name'][$i]));					
				$filename	= $data['media_code'].'.'.$ext;		
				$directory	= $zfsession->config['path'].'/media/content/gallery/'.$contentData['content_id'].'/'.$data['media_code'];
				$file		= $directory.'/'.$filename;	
				if(!is_dir($directory)) mkdir($directory, 0777, true); 
				/* Create files for this catalog type. */ 
				foreach($fileObject->image as $catalog) {
					/* Change file name. */
					$newfilename = str_replace($filename, $catalog['code'].$filename, $file);
					/* Resize media. */
					$fileObject->resize_crop_image($catalog['width'], $catalog['height'], $_FILES['mediafiles']['tmp_name'][$i], $newfilename);
				}
				$data['media_path']	= '/media/content/gallery/'.$contentData['content_id'].'/'.$data['media_code'].'/';
				$data['media_ext']		= '.'.$ext ;
				/* Check for other medias. */
				$primary = $mediaObject->getPrimary('CONTENT', $contentData['content_id'], 'IMAGE');		
				if($primary) {
					$data['media_primary']	= 0;
				} else {
					$data['media_primary']	= 1;
				}
				$success	= $mediaObject->insert($data);	
			}
		}
		header('Location: /content/gallery/media.php?id='.$contentData['content_id']);
		exit;
	}
	/* if we are here there are errors. */
	$smarty->assign('errors', implode('<br />', $errorArray));
}

$smarty->display('content/gallery/media.tpl');
?>