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
require_once 'class/product.php';
require_once 'class/productimage.php';
require_once 'class/File.php';

$productObject			= new class_product();
$productimageObject 	= new class_productimage();
$fileObject 								= new File(array('gif', 'png', 'jpg', 'jpeg'));

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$productData = $productObject->getByCode($code);

	if(!$productData) {
		header('Location: /admin/products/');
		exit;
	}
	
	$smarty->assign('productData', $productData);
} else {
	header('Location: /admin/products/');
	exit;	
}

/* Check posted data. */
if(isset($_GET['productimage_code_delete'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$itemcode					= trim($_GET['productimage_code_delete']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {	
		$data	= array();
		$data['productimage_deleted'] = 1;
		
		$where		= array();
		$where[]	= $productimageObject->getAdapter()->quoteInto('productimage_code = ?', $itemcode);
		$where[]	= $productimageObject->getAdapter()->quoteInto('product_code = ?', $productData['product_code']);
		
		$success	= $productimageObject->update($data, $where);	
		
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
if(isset($_GET['productimage_code_update'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;
	$data 					= array();
	$formValid				= true;
	$success				= NULL;
	$itemcode				= trim($_GET['productimage_code_update']);	
	
	if(isset($_GET['productimage_description']) && trim($_GET['productimage_description']) == '') {
		$errorArray['error'] = 'description required.';	
	}

	if($errorArray['error']  == '') {

		if(isset($_GET['productimage_primary']) && trim($_GET['productimage_primary']) == $itemcode) {			
			$productimageObject->updatePrimaryByProduct(trim($_GET['productimage_primary']), $productData['product_code']);			
		}
		
		$data 	= array();
		$data['productimage_description'] 			= trim($_GET['productimage_description']);			
		
		$where		= array();
		$where[]	= $productimageObject->getAdapter()->quoteInto('productimage_code = ?', $itemcode);
		$where[]	= $productimageObject->getAdapter()->quoteInto('product_code = ?', $productData['product_code']);
		$success	= $productimageObject->update($data, $where);	

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
	
	if(isset($_POST['productimage_description']) && trim($_POST['productimage_description']) == '') {
		$errorArray['productimage_description'] = 'required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data = array();
		$data['product_code'] 			= $productData['product_code'];
		$data['productimage_filename']	= trim($_FILES['imagefile']['name']);
		$data['productimage_code']		= $productimageObject->createReference();		

		$ext 		= $fileObject->file_extention($_FILES['imagefile']['name']);					
		$filename	= $data['productimage_code'].'.'.$ext;
		$directory	= $productData['campaign_directory'].'/media/products/'.$productData['product_code'].'/'.$data['productimage_code'];
		$file		= $_SERVER['DOCUMENT_ROOT'].$directory.'/'.$filename;	
		
		if(!is_dir($directory)) mkdir($_SERVER['DOCUMENT_ROOT'].$directory, 0777, true);
											
		/* Create files for this product type. */
		foreach($fileObject->image as $image) {
		
			$newfilename = str_replace($filename, $image['code'].$filename, $file);
			/* Create new file and rename it. */
			$uploadObject	= PhpThumbFactory::create($_FILES['imagefile']['tmp_name']);
			$uploadObject->resize($image['width'], $image['height']);
			$uploadObject->save($newfilename);
		}
		
		$data['productimage_path']			= $zfsession->link.'media/products/'.$productData['product_code'].'/'.$data['productimage_code'];
		$data['productimage_extension']		= '.'.$ext ;
		$data['productimage_description']	= trim($_POST['productimage_description']);
		
		$success	= $productimageObject->insert($data);	
		
		$productimageObject->updatePrimaryByProduct($data['productimage_code'], $productData['product_code']);	
		
		if(is_numeric($success)) {
			header('Location: /admin/products/images.php?code='.$productData['product_code']);
			exit;
		}
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
}

		
$productimageData = $productimageObject->getByProductCampaign($productData['product_code']);

if($productimageData) {
	$smarty->assign('productimageData', $productimageData);
}


 /* Display the template
 */	
$smarty->display('adminclient/MU3H/products/images.tpl');

?>