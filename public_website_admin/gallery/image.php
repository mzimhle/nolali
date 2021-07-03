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
require_once 'class/galleryimage.php';
require_once 'class/File.php';

$galleryObject 		= new class_gallery();
$galleryimageObject	= new class_galleryimage();
$fileObject			= new File(array('jpeg', 'jpg', 'png', 'gif'));

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$galleryData = $galleryObject->getByCode($code);

	if($galleryData) {
		
		$smarty->assign('galleryData', $galleryData);
		
		$galleryimageData = $galleryimageObject->getByGallery($code);
		
		if($galleryimageData) {
			$smarty->assign('galleryimageData', $galleryimageData);
		}

	} else {
		header('Location: /gallery/');
		exit;
	}
} else {
	header('Location: /gallery/');
	exit;
}

 if(isset($_GET['primarycode'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$primarycode			= trim($_GET['primarycode']);
	$success = $galleryimageObject->updatePrimaryByGallery($primarycode, $galleryData['gallery_code']);		
	
	if(is_numeric($success) && $success > 0) {
		$errorArray['error']	= '';
		$errorArray['result']	= 1;			
	} else {
		$errorArray['error']	= 'Could not change, please try again.';
		$errorArray['result']	= 0;				
	}
	
	echo json_encode($errorArray);
	exit;
}

 if(isset($_GET['status_code']) && isset($_GET['status'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 1;	
	$formValid				= true;
	$success				= NULL;
	$primarycode			= trim($_GET['status_code']);
	
	if($errorArray['error']  == '' && $errorArray['result']  == 1) {
		
		$success = $galleryimageObject->updatePrimaryByGallery($primarycode, $galleryData['gallery_code']);		
		
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

if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$deletecode			= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['galleryimage_deleted'] = 1;
		
		$where = $galleryimageObject->getAdapter()->quoteInto('galleryimage_code = ?', $deletecode);
		$success	= $galleryimageObject->update($data, $where);	
		
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

/* Check posted data. */
if(count($_FILES) > 0) {
	$errorArray	= array();
	$data 			= array();
	$formValid	= true;
	$success		= NULL;

	if(isset($_FILES['imagefiles']['name']) && count($_FILES['imagefiles']['name']) > 0) {
		for($i = 0; $i < count($_FILES['imagefiles']['name'][$i]); $i++) {
			/* Check validity of the CV. */
			if((int)$_FILES['imagefiles']['size'][$i] != 0 && trim($_FILES['imagefiles']['name'][$i]) != '') {
				/* Check if its the right file. */
				$ext = $fileObject->file_extention($_FILES['imagefiles']['name'][$i]); 

				if($ext != '') {
					$checkExt = $fileObject->getValidateExtention('imagefiles', $ext, $i);

					if(!$checkExt) {
						$errorArray['imagefiles'] = 'Invalid file type something funny with the file format';
						$formValid = false;						
					} else {
						/* Check width and height */
						$imagefiles = $fileObject->getValidateSize($_FILES['imagefiles']['size'][$i]);
						
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
					case 4 : $errorArray['imagefiles'] = 'No file was uploaded'; $formValid = false; break;
					case 6 : $errorArray['imagefiles'] = 'Missing a temporary folder'; $formValid = false; break;
					case 7 : $errorArray['imagefiles'] = 'Faild to write file to disk'; $formValid = false; break;
				}
			}
		}
	}

	if(count($errorArray) == 0 && $formValid == true) {
		
		for($i = 0; $i < count($_FILES['imagefiles']['name']); $i++) {
			if(isset($_FILES['imagefiles']['size'][$i])) {
				if((int)$_FILES['imagefiles']['size'][$i] != 0 && trim($_FILES['imagefiles']['name'][$i]) != '') {

					$data = array();
					$data['gallery_code'] 			= $galleryData['gallery_code'];
					$data['galleryimage_filename']	= trim($_FILES['imagefiles']['name'][$i]);
					$data['galleryimage_code']		= $galleryimageObject->createCode();		

					$ext							= strtolower($fileObject->file_extention($_FILES['imagefiles']['name'][$i]));						
					$filename					= $data['galleryimage_code'].'.'.$ext;
					$directory					= realpath(__DIR__.'/../../').$zfsession->domainData['campaign_directory'].'/media/gallery/'.$galleryData['gallery_code'].'/'.$data['galleryimage_code'];
					$file							= $directory.'/'.$filename;	

					if(!is_dir($directory)) mkdir($directory, 0777, true);

					/* Create files for this gallery type. */
					foreach($fileObject->image as $image) {
					
						$newfilename = str_replace($filename, $image['code'].$filename, $file);

						/* Create new file and rename it. */
						$uploadObject	= PhpThumbFactory::create($_FILES['imagefiles']['tmp_name'][$i]);
						$uploadObject->adaptiveResize($image['width'], $image['height']);
						$uploadObject->save($newfilename);

					}

					$data['galleryimage_path']		= 'media/gallery/'.$galleryData['gallery_code'].'/'.$data['galleryimage_code'];
					$data['galleryimage_extension']	= '.'.$ext ;
					
					$success	= $galleryimageObject->insert($data);	
					
					$galleryimageObject->updatePrimaryByGallery($data['galleryimage_code'], $galleryData['gallery_code']);
					
				}
			}
		}
		
		if(is_numeric($success)) {
			header('Location: /gallery/image.php?code='.$galleryData['gallery_code']);
			exit;
		}
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
	
}

$smarty->display('gallery/image.tpl');

?>