<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/* Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/* Check for login */
require_once 'includes/auth.php';

/* objects. */
require_once 'class/template.php';
require_once 'class/File.php';

$templateObject	= new class_template();
$htmlObject			= new File(array('html', 'htm'));
$imageObject		= new File(array('jpeg', 'jpg', 'png', 'gif'));
$cssObject			= new File(array('css'));

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$templateData = $templateObject->getByCode($code);

	if($templateData) {
		$smarty->assign('templateData', $templateData);
	} else {
		header('Location: /website/templates/');
		exit;		
	}
}

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray	= array();
	$data 			= array();
	$formValid	= true;
	$success		= NULL;
	
	if(isset($_POST['template_type']) && trim($_POST['template_type']) == '') {
		$errorArray['template_type'] = 'Type of template';
		$formValid = false;		
	}
	
	if(isset($_POST['template_name']) && trim($_POST['template_name']) == '') {
		$errorArray['template_name'] = 'Name of template is required';
		$formValid = false;		
	}

	if(isset($_FILES['htmlfile'])) {
		/* Check validity of the CV. */
		if((int)$_FILES['htmlfile']['size'] != 0 && trim($_FILES['htmlfile']['name']) != '') {
			/* Check if its the right file. */
			$ext = $htmlObject->file_extention($_FILES['htmlfile']['name']); 

			if($ext != '') {				
				$checkExt = $htmlObject->getValidateExtention('htmlfile', $ext);				
				if(!$checkExt) {
					$errorArray['htmlfile'] = 'Invalid file type something funny with the file format';
					$formValid = false;						
				} else {
					/* Check width and height */
					$htmlfile = $htmlObject->getValidateSize($_FILES['htmlfile']['size']);
					
					if(!$htmlfile) {
						$errorArray['htmlfile'] = 'File needs to be less than 2MB.';
						$formValid = false;							
					}
				}
			} else {
				$errorArray['htmlfile'] = 'Invalid file type';
				$formValid = false;									
			}
		} else {			
			switch((int)$_FILES['htmlfile']['error']) {
				case 1 : $errorArray['htmlfile'] = 'The uploaded file exceeds the maximum upload file size, should be less than 1M'; $formValid = false; break;
				case 2 : $errorArray['htmlfile'] = 'File size exceeds the maximum file size'; $formValid = false; break;
				case 3 : $errorArray['htmlfile'] = 'File was only partically uploaded, please try again'; $formValid = false; break;
				//case 4 : $errorArray['htmlfile'] = 'No file was uploaded'; $formValid = false; break;
				case 6 : $errorArray['htmlfile'] = 'Missing a temporary folder'; $formValid = false; break;
				case 7 : $errorArray['htmlfile'] = 'Faild to write file to disk'; $formValid = false; break;
			}
		}
	}

	if(isset($_FILES['imagefiles']['name']) && count($_FILES['imagefiles']['name']) > 0) {
		for($i = 0; $i < count($_FILES['imagefiles']['name'][$i]); $i++) {
			/* Check validity of the CV. */
			if((int)$_FILES['imagefiles']['size'][$i] != 0 && trim($_FILES['imagefiles']['name'][$i]) != '') {
				/* Check if its the right file. */
				$ext = $imageObject->file_extention($_FILES['imagefiles']['name'][$i]); 

				if($ext != '') {
					$checkExt = $imageObject->getValidateExtention('imagefiles', $ext, $i);

					if(!$checkExt) {
						$errorArray['imagefiles'] = 'Invalid file type something funny with the file format';
						$formValid = false;						
					} else {
						/* Check width and height */
						$imagefiles = $imageObject->getValidateSize($_FILES['imagefiles']['size'][$i]);
						
						if(!$imagefiles) {
							$errorArray['imagefiles'] = 'File needs to be less than 2MB.';
							$formValid = false;							
						}
					}
				} else {
					$errorArray['imagefiles'] = 'Invalid file type';
					$formValid = false;									
				}
			} else {			
				switch((int)$_FILES['imagefiles']['error'][$i]) {
					case 1 : $errorArray['imagefiles'] = 'The uploaded file exceeds the maximum upload file size, should be less than 1M'; $formValid = false; break;
					case 2 : $errorArray['imagefiles'] = 'File size exceeds the maximum file size'; $formValid = false; break;
					case 3 : $errorArray['imagefiles'] = 'File was only partically uploaded, please try again'; $formValid = false; break;
					//case 4 : $errorArray['imagefiles'] = 'No file was uploaded'; $formValid = false; break;
					case 6 : $errorArray['imagefiles'] = 'Missing a temporary folder'; $formValid = false; break;
					case 7 : $errorArray['imagefiles'] = 'Faild to write file to disk'; $formValid = false; break;
				}
			}
		}
	}
	
	if(isset($_FILES['cssfile'])) {
		/* Check validity of the CV. */
		if((int)$_FILES['cssfile']['size'] != 0 && trim($_FILES['cssfile']['name']) != '') {
			/* Check if its the right file. */
			$ext = $cssObject->file_extention($_FILES['cssfile']['name']); 

			if($ext != '') {				
				$checkExt = $cssObject->getValidateExtention('cssfile', $ext);				
				if(!$checkExt) {
					$errorArray['cssfile'] = 'Invalid file type something funny with the file format';
					$formValid = false;						
				} else {
					/* Check width and height */
					$cssfile = $cssObject->getValidateSize($_FILES['cssfile']['size']);
					
					if(!$cssfile) {
						$errorArray['cssfile'] = 'File needs to be less than 2MB.';
						$formValid = false;							
					}
				}
			} else {
				$errorArray['cssfile'] = 'Invalid file type';
				$formValid = false;									
			}
		} else {			
			switch((int)$_FILES['cssfile']['error']) {
				case 1 : $errorArray['cssfile'] = 'The uploaded file exceeds the maximum upload file size, should be less than 1M'; $formValid = false; break;
				case 2 : $errorArray['cssfile'] = 'File size exceeds the maximum file size'; $formValid = false; break;
				case 3 : $errorArray['cssfile'] = 'File was only partically uploaded, please try again'; $formValid = false; break;
				//case 4 : $errorArray['cssfile'] = 'No file was uploaded'; $formValid = false; break;
				case 6 : $errorArray['cssfile'] = 'Missing a temporary folder'; $formValid = false; break;
				case 7 : $errorArray['cssfile'] = 'Faild to write file to disk'; $formValid = false; break;
			}
		}
	}	
	
	if(count($errorArray) == 0 && $formValid == true) {
	
		$data 	= array();				
		$data['template_name']	= trim($_POST['template_name']);				
		$data['template_type']	= trim($_POST['template_type']);

		if(isset($templateData)) {
			$where		= array();
			$where[]		= $templateObject->getAdapter()->quoteInto('campaign_code = ?', $zfsession->domainData['campaign_code']);
			$where[]		= $templateObject->getAdapter()->quoteInto('template_code = ?', $templateData['template_code']);
			$success	= $templateObject->update($data, $where);			
			$success 	= $templateData['template_code'];
		} else {
			$success = $templateObject->insert($data);
			
			$directory	= realpath(__DIR__.'/../../../').$zfsession->domainData['campaign_directory'].'/media/templates/'.$success.'/';		
			if(!is_dir($directory)) mkdir($directory, 0777, true);

			$imagedirectory	= realpath(__DIR__.'/../../../').$zfsession->domainData['campaign_directory'].'/media/templates/'.$success.'/images/';		
			if(!is_dir($imagedirectory)) mkdir($imagedirectory, 0777, true);					
		}
			
		if(count($errorArray) == 0) {
			/* Upload actual .html and .htm file. */
			if(isset($templateData) && isset($_FILES['htmlfile'])) {
				if((int)$_FILES['htmlfile']['size'] != 0 && trim($_FILES['htmlfile']['name']) != '') {
				
					$ext 			= strtolower($htmlObject->file_extention($_FILES['htmlfile']['name']));					
					$filename	= $success.'.'.$ext;
					$directory	= realpath(__DIR__.'/../../../').$zfsession->domainData['campaign_directory'].'/media/templates/'.$success.'/';	
					$file			= $directory.'/'.$filename;
				
					if(file_put_contents($file, file_get_contents($_FILES['htmlfile']['tmp_name']))) {
						
						$template = array();
						$template['template_file']	= '/media/templates/'.$success.'/'.$filename;
						
						$where		= array();
						$where[]	= $templateObject->getAdapter()->quoteInto('campaign_code = ?', $zfsession->domainData['campaign_code']);
						$where[]	= $templateObject->getAdapter()->quoteInto('template_code = ?', $templateData['template_code']);
						$templateObject->update($template, $where);	
						
					} else {
						$errorArray['htmlfile'] = 'could not upload file, please try again';
						$formValid = false;			
					}
				}
			}
		}
		
		if(count($errorArray) == 0) {
			/* Upload actual .html and .htm file. */
			if(isset($templateData) && isset($_FILES['cssfile'])) {
				if((int)$_FILES['cssfile']['size'] != 0 && trim($_FILES['cssfile']['name']) != '') {
				
					$ext 			= strtolower($cssObject->file_extention($_FILES['cssfile']['name']));					
					$filename	= $success.'.'.$ext;
					$directory	= realpath(__DIR__.'/../../../').$zfsession->domainData['campaign_directory'].'/media/templates/'.$success.'/';	
					$file			= $directory.'/'.$filename;
				
					if(!file_put_contents($file, file_get_contents($_FILES['cssfile']['tmp_name']))) {						
						$errorArray['cssfile'] = 'could not upload file, please try again';
						$formValid = false;						
					}
				}
			}
		}
		
		if(count($errorArray) == 0) {
			/* Upload image files. */
			if(isset($templateData) && isset($_FILES['imagefiles']) && count($_FILES['imagefiles']['name']) > 0) {
				for($i = 0; $i < count($_FILES['imagefiles']['name']); $i++) {
					if(isset($_FILES['imagefiles']['size'][$i])) {
						if((int)$_FILES['imagefiles']['size'][$i] != 0 && trim($_FILES['imagefiles']['name'][$i]) != '') {
							$filename	= $_FILES['imagefiles']['name'][$i];
							$directory	= realpath(__DIR__.'/../../../').$zfsession->domainData['campaign_directory'].'/media/templates/'.$success.'/images/';
							$file			= $directory.'/'.$filename;
						
							if(!file_put_contents($file, file_get_contents($_FILES['imagefiles']['tmp_name'][$i]))) {					
								$errorArray['imagefiles'] = 'could not upload file, please try again';
								$formValid = false;			
							}
						}
					}
				}
			}
		}
		
		if(count($errorArray) == 0) {
			header('Location: /website/templates/details.php?code='.$success);	
			exit;		
		}
		
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('website/templates/details.tpl');

?>