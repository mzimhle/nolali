<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';
require_once 'adminclient/MU3H/includes/auth.php';

/* objects. */
require_once 'class/gallery.php';
require_once 'class/galleryimage.php';
require_once 'class/File.php';

$galleryObject			= new class_gallery();
$galleryimageObject 	= new class_galleryimage();
$fileObject 				= new File(array('gif', 'png', 'jpg', 'jpeg', 'gif'));

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$galleryData = $galleryObject->getByCode($code);

	if(!$galleryData) {
		header('Location: /admin/galleries/');
		exit;
	}
	
	$smarty->assign('galleryData', $galleryData);
} else {
	header('Location: /admin/galleries/');
	exit;	
}

/* Check posted data. */
if(isset($_GET['galleryimage_code_delete'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$itemcode					= trim($_GET['galleryimage_code_delete']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {	
		$data	= array();
		$data['galleryimage_deleted'] = 1;
		
		$where		= array();
		$where[]	= $galleryimageObject->getAdapter()->quoteInto('galleryimage_code = ?', $itemcode);
		$where[]	= $galleryimageObject->getAdapter()->quoteInto('gallery_code = ?', $galleryData['gallery_code']);
		
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
if(isset($_GET['galleryimage_code_update'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;
	$data 						= array();
	$formValid				= true;
	$success					= NULL;
	$itemcode					= trim($_GET['galleryimage_code_update']);
	
	if(isset($_GET['galleryimage_description']) && trim($_GET['galleryimage_description']) == '') {
		$errorArray['error'] = 'description required.';	
	}

	if($errorArray['error']  == '') {

		if(isset($_GET['galleryimage_primary']) && trim($_GET['galleryimage_primary']) == $itemcode) {			
			$galleryimageObject->updatePrimaryByGallery(trim($_GET['galleryimage_primary']), $galleryData['gallery_code']);			
		}
		
		$data 	= array();		
		$data['galleryimage_description'] 			= trim($_GET['galleryimage_description']);			
		$data['galleryimage_active'] 				= isset($_GET['galleryimage_active']) && (int)trim($_GET['galleryimage_active']) == 1 ? 1 : 0;	
		
		$where		= array();
		$where[]	= $galleryimageObject->getAdapter()->quoteInto('galleryimage_code = ?', $itemcode);
		$where[]	= $galleryimageObject->getAdapter()->quoteInto('gallery_code = ?', $galleryData['gallery_code']);
		$success	= $galleryimageObject->update($data, $where);	

		if(is_numeric($success)) {		
			$errorArray['error']	= '';
			$errorArray['result']	= 1;			
		} else {
			$errorArray['error']	= 'Could not update, please try again.';
			$errorArray['result']	= 0;				
		}
	}
	
	echo json_encode($errorArray);
	exit;
}

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray	= array();
	$data 			= array();
	$formValid	= true;
	$success		= NULL;
	
	if(isset($_FILES['imagefile'])) {
		/* Check validity of the CV. */
		if((int)$_FILES['imagefile']['size'] != 0 && trim($_FILES['imagefile']['name']) != '') {
			/* Check if its the right file. */
			$ext = $fileObject->file_extention($_FILES['imagefile']['name']); 

			if($ext != '') {				
				$checkExt = $fileObject->getValidateExtention('imagefile', $ext);				
				if(!$checkExt) {
					$errorArray['imagefile'] = 'Invalid file type something funny with the file format';
					$formValid = false;						
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
				case 4 : $errorArray['imagefile'] = 'No file was uploaded'; $formValid = false; break;
				case 6 : $errorArray['imagefile'] = 'Missing a temporary folder'; $formValid = false; break;
				case 7 : $errorArray['imagefile'] = 'Faild to write file to disk'; $formValid = false; break;
			}
		}
	}
	
	if(isset($_POST['galleryimage_description']) && trim($_POST['galleryimage_description']) == '') {
		$errorArray['galleryimage_description'] = 'required';
		$formValid = false;		
	}

	if(count($errorArray) == 0 && $formValid == true) {
		
		$data = array();
		$data['gallery_code'] 					= $galleryData['gallery_code'];
		$data['galleryimage_filename']	= trim($_FILES['imagefile']['name']);
		$data['galleryimage_code']			= $galleryimageObject->createReference();		

		$ext 							= $fileObject->file_extention($_FILES['imagefile']['name']);					
		$filename					= $data['galleryimage_code'].'.'.$ext;
		$directory					= $galleryData['campaign_directory'].'/media/galleries/'.$galleryData['gallery_code'].'/'.$data['galleryimage_code'];
		$file							= $_SERVER['DOCUMENT_ROOT'].$directory.'/'.$filename;	
		
		if(!is_dir($directory)) mkdir($_SERVER['DOCUMENT_ROOT'].$directory, 0777, true);
											
		/* Create files for this product type. */
		foreach($fileObject->image as $image) {
		
			$newfilename = str_replace($filename, $image['code'].$filename, $file);
			/* Create new file and rename it. */
			$uploadObject	= PhpThumbFactory::create($_FILES['imagefile']['tmp_name']);
			$uploadObject->resize($image['width'], $image['height']);
			$uploadObject->save($newfilename);
		}
		
		$data['galleryimage_path']				= $zfsession->link.'media/galleries/'.$galleryData['gallery_code'].'/'.$data['galleryimage_code'];
		$data['galleryimage_extension']		= '.'.$ext ;
		$data['galleryimage_description']	= trim($_POST['galleryimage_description']);
		
		$success	= $galleryimageObject->insert($data);	
		
		$galleryimageObject->updatePrimaryByGallery($data['galleryimage_code'], $galleryData['gallery_code']);	
		
		if(is_numeric($success)) {
			header('Location: /admin/galleries/images.php?code='.$galleryData['gallery_code']);
			exit;
		}

	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
}

		
$galleryimageData = $galleryimageObject->getByGallery($galleryData['gallery_code']);

if($galleryimageData) {
	$smarty->assign('galleryimageData', $galleryimageData);
}


 /* Display the template
 */	
$smarty->display('adminclient/MU3H/galleries/images.tpl');

?>