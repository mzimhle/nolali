<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';

require_once 'class/template.php';

$templateObject	= new class_template();
/* class file objects */
$htmlObject		= new File(array('html', 'htm'));
$imageObject	= new File(array('jpg', 'jpeg', 'png', 'gif', 'eot', 'css', 'woff', 'ttf', 'svg', 'ico'));

if (isset($_GET['id']) && trim($_GET['id']) != '') {
	
	$id 				= trim($_GET['id']);
	$templateData 	= $templateObject->getById($id);

	if($templateData) {
		$templateData['template_path'] = str_replace($zfsession->config['path'], '', $templateData['template_file']);
		$smarty->assign('templateData', $templateData);
	} else {
		header('Location: /template/');
		exit;		
	}
}

/* Check posted data. */
if(count($_POST) > 0) {
	$errors	= array();
	$data	= array();
	
	if(!isset($_POST['template_code'])) {
		$errors[] = 'Please add a code';	
	} else if(trim($_POST['template_code']) == '') {
		$errors[] = 'Please add a code';	
	}

	if(!isset($_POST['template_category'])) {
		$errors[] = 'Please add a category';	
	} else if(trim($_POST['template_category']) == '') {
		$errors[] = 'Please add a category';	
	} else {

		$category = trim($_POST['template_category']);

		if($category == 'EMAIL') {
			if(!isset($_POST['template_subject'])) {
				$errors[] = 'Please add a subject';	
			} else if(trim($_POST['template_subject']) == '') {
				$errors[] = 'Please add a subject';	
			}
		} else if($category == 'SMS') {
			if(!isset($_POST['template_message'])) {
				$errors[] = 'Please add a message';	
			} else if(trim($_POST['template_message']) == '') {
				$errors[] = 'Please add a message';	
			}
		} else {
			/* Check if it already exists. */
			$temp = isset($templateData) ? $templateData['template_id'] : null;
			/* Fetch in checking if it exists. */
			$templateTemp = $templateObject->getTemplate(trim($_POST['template_category']), trim($_POST['template_code']), $temp);

			if($templateTemp) {
				$errors[] = 'Template category and code already exists, please use another code.';
			}
		}
	}

	if(count($errors) == 0) {
		/* Add the details. */
		$data                       = array();				
		$data['template_category']	= trim($_POST['template_category']);
		$data['template_code']      = strtoupper(trim($_POST['template_code']));
		/* Check category if its email or sms. */
		if($category == 'SMS') {
			$data['template_message']	= trim($_POST['template_message']);
		} else if($category == 'EMAIL') {
			$data['template_subject']	= trim($_POST['template_subject']);
		}
		/* Insert or update. */
		if(!isset($templateData)) {
			$success	= $templateObject->insert($data);				
		} else {
			$where		= $templateObject->getAdapter()->quoteInto('template_id = ?', $templateData['template_id']);
			$templateObject->update($data, $where);		
			$success	= $templateData['template_id'];			
		}

		if($success && isset($category) && ($category == 'EMAIL' || $category == 'TEMPLATE')) {
			/* Upload the html. */
			if(isset($_FILES['htmlfile']['name']) && trim($_FILES['htmlfile']['name']) != '') {
				/* Check validity of the CV. */
				if((int)$_FILES['htmlfile']['size'] != 0 && trim($_FILES['htmlfile']['name']) != '') {
					/* Check if its the right file. */
					$ext = $htmlObject->file_extention($_FILES['htmlfile']['name']); 

					if($ext != '') {
						$checkExt = $htmlObject->getValidateExtention('htmlfile', $ext);

						if(!$checkExt) {
							$errors[] = 'Invalid file type something funny with the file format';
						}
					} else {
						$errors[] = 'Invalid file type';								
					}
				} else {
					switch((int)$_FILES['htmlfile']['error']) {
						case 1 : $errors[]= 'The uploaded file exceeds the maximum upload file size, should be less than 1M'; $formValid = false; break;
						case 2 : $errors[]= 'File size exceeds the maximum file size'; $formValid = false; break;
						case 3 : $errors[]= 'File was only partically uploaded, please try again'; $formValid = false; break;
						// case 4 : $errors[]= 'No file was uploaded'; $formValid = false; break;
						case 6 : $errors[]= 'Missing a temporary folder'; $formValid = false; break;
						case 7 : $errors[]= 'Faild to write file to disk'; $formValid = false; break;
					}
				}
				/* Upload the html file. */
				if(count($errors) == 0) {

					$ext        = strtolower($htmlObject->file_extention($_FILES['htmlfile']['name']));
					$filename	= $success.'.'.$ext;		
					$directory	= $zfsession->config['path'].'/media/template/'.strtolower($success).'/';
					$file       = $directory.strtolower($filename);	

					if(!is_dir($directory)) mkdir($directory, 0777, true); 

					if(file_put_contents($file,file_get_contents($_FILES['htmlfile']['tmp_name']))) {

						$data					= array();
						$data['template_file']	= '/media/template/'.strtolower($success).'/'.strtolower($filename);

						$where		= $templateObject->getAdapter()->quoteInto('template_id = ?', $success);
						$templateObject->update($data, $where);							
					}
				}
			}
			/* Upload images. */
			if(isset($_FILES['mediafiles']['name']) && count($_FILES['mediafiles']['name']) > 0) {
				for($i = 0; $i < count($_FILES['mediafiles']['name']); $i++) {
					if((int)$_FILES['mediafiles']['size'][$i] != 0 && trim($_FILES['mediafiles']['name'][$i]) != '') {
						/* Check if its the right file. */
						$ext = $imageObject->file_extention($_FILES['mediafiles']['name'][$i]); 

						if($ext != '') {
							$checkExt = $imageObject->getValidateExtention('mediafiles', $ext, $i);
							if(!$checkExt) {
								$errors[] = 'Invalid file type something funny with the file format';
								$formValid = false;						
							}
						} else {
							$errors[] = 'Invalid file type';
							$formValid = false;									
						}
					} else {			
						switch((int)$_FILES['mediafiles']['error'][$i]) {
							case 1 : $errors[] = 'The uploaded file exceeds the maximum upload file size, should be less than 1M'; $formValid = false; break;
							case 2 : $errors[] = 'File size exceeds the maximum file size'; $formValid = false; break;
							case 3 : $errors[] = 'File was only partically uploaded, please try again'; $formValid = false; break;
							// case 4 : $errors[] = 'No file was uploaded'; $formValid = false; break;
							case 6 : $errors[] = 'Missing a temporary folder'; $formValid = false; break;
							case 7 : $errors[] = 'Faild to write file to disk'; $formValid = false; break;
						}
					}
				}
				/* Upload images */
				if(count($errors) == 0) {
					if(isset($_FILES['mediafiles']) && count($_FILES['mediafiles']['name']) > 0) {
						for($i = 0; $i < count($_FILES['mediafiles']['name']); $i++) {
							if($_FILES['mediafiles']['name'][$i] != '') {
								$directory	= $zfsession->config['path'].DIRECTORY_SEPARATOR .'media'.DIRECTORY_SEPARATOR .'template'.DIRECTORY_SEPARATOR.strtolower($success).DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR;
								$file		= $directory.$_FILES['mediafiles']['name'][$i];	
								if(!is_dir($directory)) mkdir($directory, 0777, true); 
								file_put_contents($file,file_get_contents($_FILES['mediafiles']['tmp_name'][$i]));
							}
						}
					}
				}
			}
		}
	}
	/* Check errors and redirect if there are non. */
	if(count($errors) != 0) {
		/* if we are here there are errors. */
		$smarty->assign('errors', implode("<br />", $errors));
	} else {
		header('Location: /template/');
		exit;
	}
}

$smarty->display('template/details.tpl');

?>