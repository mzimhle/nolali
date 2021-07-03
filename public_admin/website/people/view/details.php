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
require_once 'class/participant.php';
require_once 'class/participantcategory.php';
require_once 'class/File.php';

$participantObject 				= new class_participant();
$participantcategoryObject = new class_participantcategory();
$fileObject							= new File(array('jpeg', 'jpg', 'png', 'gif'));

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$participantData = $participantObject->getByCode($code);

	if(!$participantData) {
		header('Location: /website/people/view/');
		exit;
	}
	
	$smarty->assign('participantData', $participantData);
}

$participantcategorypairs = $participantcategoryObject->pairs();
if($participantcategorypairs) $smarty->assign('participantcategorypairs', $participantcategorypairs);

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray		= array();
	$formValid		= true;
	
	
	if(isset($_POST['areapost_code']) && trim($_POST['areapost_code']) == '') {
		$errorArray['areapost_code'] = 'Area required';
		$formValid = false;		
	}	
	
	if(isset($_POST['participant_name']) && trim($_POST['participant_name']) == '') {
		$errorArray['participant_name'] = 'Name required';
		$formValid = false;		
	}	
	
	if(isset($_POST['participant_surname']) && trim($_POST['participant_surname']) == '') {
		$errorArray['participant_surname'] = 'Surname required';
		$formValid = false;		
	}

	if(isset($_POST['participant_email']) && trim($_POST['participant_email']) != '') {
		if($participantObject->validateEmail(trim($_POST['participant_email'])) == '') {
			$errorArray['participant_email'] = 'Needs to be a valid email address';
			$formValid = false;	
		} else {
			
			$email = isset($participantData) ? $participantData['participant_code'] : null;
			
			$emailData = $participantObject->getByEmail(trim($_POST['participant_email']), $email);

			if($emailData) {
				$errorArray['participant_email'] = 'Email already exists';
				$formValid = false;				
			}
		}
	} else {
		$errorArray['participant_email'] = 'Email required';
		$formValid = false;					
	}
	
	if(isset($_POST['participant_cellphone']) && trim($_POST['participant_cellphone']) != '') {
		if($participantObject->validateCell(trim($_POST['participant_cellphone'])) == '') {
			$errorArray['participant_cellphone'] = 'Needs to be a valid cellphone number';
			$formValid = false;	
		} else {
			
			$cell = isset($participantData) ? $participantData['participant_code'] : null;
			
			$cellData = $participantObject->getByCell(trim($_POST['participant_cellphone']), $cell);

			if($cellData) {
				$errorArray['participant_cellphone'] = 'Cellphone already exists';
				$formValid = false;				
			}
		}
	}
	
	if(isset($_POST['participantcategory_code']) && trim($_POST['participantcategory_code']) == '') {
		$errorArray['participantcategory_code'] = 'Category required';
		$formValid = false;		
	}	
	
	if(isset($_FILES['imagefile']['name']) && count($_FILES['imagefile']['name']) > 0) {
			/* Check validity of the CV. */
			if((int)$_FILES['imagefile']['size'] != 0 && trim($_FILES['imagefile']['name']) != '') {
				/* Check if its the right file. */
				$ext = $fileObject->file_extention($_FILES['imagefile']['name']); 

				if($ext != '') {
					$checkExt = $fileObject->getValidateExtention('imagefile', $ext);

					if(!$checkExt) {
						$errorArray['imagefile'] = 'Invalid file type something funny with the file format';
						$formValid = false;						
					} else {
						/* Check width and height */
						$imagefile = $fileObject->getValidateSize($_FILES['imagefile']['size']);
						
						if(!$imagefile) {
							$errorArray['imagefile'] = 'File needs to be less than 2MB.';
							$formValid = false;							
						}
					}
				} else {
					$errorArray['imagefile'] = 'Invalid file type';
					$formValid = false;									
				}
			} else {			
				switch((int)$_FILES['imagefile']['error']) {
					case 1 : $errorArray['imagefile'] = 'The uploaded file exceeds the maximum upload file size, should be less than 1M'; $formValid = false; break;
					case 2 : $errorArray['imagefile'] = 'File size exceeds the maximum file size'; $formValid = false; break;
					case 3 : $errorArray['imagefile'] = 'File was only partically uploaded, please try again'; $formValid = false; break;
					//case 4 : $errorArray['imagefile'] = 'No file was uploaded'; $formValid = false; break;
					case 6 : $errorArray['imagefile'] = 'Missing a temporary folder'; $formValid = false; break;
					case 7 : $errorArray['imagefile'] = 'Faild to write file to disk'; $formValid = false; break;
				}
			}
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();				
		$data['participant_name']				= trim($_POST['participant_name']);		
		$data['participant_surname']			= trim($_POST['participant_surname']);		
		$data['areapost_code']					= trim($_POST['areapost_code']);	
		$data['participantcategory_code']	= trim($_POST['participantcategory_code']);	
		$data['participant_email']				= $participantObject->validateEmail(trim($_POST['participant_email']));		
		$data['participant_cellphone']			= $participantObject->validateCell(trim($_POST['participant_cellphone']));		
		
		if(isset($participantData)) {
			/*Update. */
			$data['participant_code']	= $participantData['participant_code'];		
			$success	= $participantObject->updateParticipant($data, 'EMAIL');
			$success 	= $participantData['participant_code'];
		} else {
			$success = $participantObject->insertParticipant($data, 'EMAIL');		
		}
		
		if(isset($_FILES['imagefile']['size'])) {
			if((int)$_FILES['imagefile']['size'] != 0 && trim($_FILES['imagefile']['name']) != '') {

				$data = array();
				$data['participant_image_name']	= time();	
				
				$ext							= strtolower($fileObject->file_extention($_FILES['imagefile']['name']));						
				$filename					= $data['participant_image_name'].'.'.$ext;
				$directory					= realpath($_SERVER['DOCUMENT_ROOT'].'/../').$zfsession->domainData['campaign_directory'].'/media/people/view/'.$success.'/'.$data['participant_image_name'];

				$file							= $directory.'/'.$filename;	

				if(!is_dir($directory)) mkdir($directory, 0777, true);

				/* Create files for this product type. */
				foreach($fileObject->image as $image) {
				
					$newfilename = str_replace($filename, $image['code'].$filename, $file);

					/* Create new file and rename it. */
					$uploadObject	= PhpThumbFactory::create($_FILES['imagefile']['tmp_name']);
					$uploadObject->adaptiveResize($image['width'], $image['height']);
					$uploadObject->save($newfilename);

				}
				
				$data['participant_image_path']			= 'media/people/view/'.$success.'/'.$data['participant_image_name'];
				$data['participant_image_extension']	= '.'.$ext ;
				$data['participant_code']					= $success;		

				$success	= $participantObject->updateParticipant($data, 'EMAIL');			
				
			}
		}		
		
		if(count($errorArray) == 0) {							
			header('Location: /website/people/view/');	
			exit;		
		}
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('website/people/view/details.tpl');

?>