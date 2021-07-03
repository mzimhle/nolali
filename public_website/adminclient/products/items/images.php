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

require_once 'class/MU3H/campaignproductitem.php';
require_once 'class/MU3H/campaignproduct.php';
require_once 'class/MU3H/campaignproductitemimage.php';
require_once 'class/MU3H/File.php';

$campaignproductitemObject			= new class_campaignproductitem();
$campaignproductObject				= new class_campaignproduct();
$campaignproductitemimageObject 	= new class_campaignproductitemimage();
$fileObject 						= new File(array('gif', 'png', 'jpg', 'jpeg'));

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$campaignproductData = $campaignproductObject->getByCode($code);

	if(!$campaignproductData) {
		header('Location: /admin/products/');
		exit;
	}
	
	$smarty->assign('campaignproductData', $campaignproductData);
} else {
	header('Location: /admin/products/');
	exit;
}

if (isset($_GET['item']) && trim($_GET['item']) != '') {
	
	$item = trim($_GET['item']);
	
	$campaignproductitemData = $campaignproductitemObject->getByCode($item);

	if(!$campaignproductitemData) {
		header('Location: /admin/products/');
		exit;
	}
	
	$smarty->assign('campaignproductitemData', $campaignproductitemData);
	
} else {
	header('Location: /admin/products/');
	exit;
}

/* Check posted data. */
if(isset($_GET['campaignproductitemimage_code_delete'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$itemcode					= trim($_GET['campaignproductitemimage_code_delete']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {	
		$data	= array();
		$data['campaignproductitemimage_deleted'] = 1;
		
		$where		= array();
		$where[]	= $campaignproductitemimageObject->getAdapter()->quoteInto('campaignproductitemimage_code = ?', $itemcode);
		$where[]	= $campaignproductitemimageObject->getAdapter()->quoteInto('campaignproductitem_code = ?', $campaignproductitemData['campaignproductitem_code']);
		
		$success	= $campaignproductitemimageObject->update($data, $where);	
		
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
if(isset($_GET['campaignproductitemimage_code_update'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;
	$data 						= array();
	$formValid				= true;
	$success					= NULL;
	$itemcode					= trim($_GET['campaignproductitemimage_code_update']);
	
	if(isset($_GET['campaignproductitemimage_name']) && trim($_GET['campaignproductitemimage_name']) == '') {
		$errorArray['error'] = 'name required.';	
	}	
	
	if(isset($_GET['campaignproductitemimage_description']) && trim($_GET['campaignproductitemimage_description']) == '') {
		$errorArray['error'] = 'description required.';	
	}

	if($errorArray['error']  == '') {

		if(isset($_GET['campaignproductitemimage_primary']) && trim($_GET['campaignproductitemimage_primary']) == $itemcode) {			
			$campaignproductitemimageObject->updatePrimary($itemcode, $campaignproductitemData['campaignproductitem_code']	);			
		}
		
		$data 	= array();		
		$data['campaignproductitemimage_name'] 					= trim($_GET['campaignproductitemimage_name']);		
		$data['campaignproductitemimage_description'] 			= trim($_GET['campaignproductitemimage_description']);			
		$data['campaignproductitemimage_active'] 					= isset($_GET['campaignproductitemimage_active']) && (int)trim($_GET['campaignproductitemimage_active']) == 1 ? 1 : 0;	
		
		$where		= array();
		$where[]	= $campaignproductitemimageObject->getAdapter()->quoteInto('campaignproductitemimage_code = ?', $itemcode);
		$where[]	= $campaignproductitemimageObject->getAdapter()->quoteInto('campaignproductitem_code = ?', $campaignproductitemData['campaignproductitem_code']);
		$success	= $campaignproductitemimageObject->update($data, $where);	

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
		if((int)$_FILES['imagefile']['size'] == 0) {
			/* Check if its the right file. */
			$errorArray['imagefile'] = 'Please try to upload again, its size is empty or 0.';
			$formValid = false;	
		} else {
			$ext = array_search($_FILES['imagefile']['type'], $fileObject->mime_types); 
			
			if($ext != '') {
				if(!$fileObject->valideExt($ext)) { 
					$errorArray['imagefile'] = 'Invalid file type';
					$formValid = false;						
				}
			} else {
				$errorArray['imagefile'] = 'Invalid file type';
				$formValid = false;									
			}
		}
	}
	
	if(isset($_POST['campaignproductitemimage_name']) && trim($_POST['campaignproductitemimage_name']) == '') {
		$errorArray['campaignproductitemimage_name'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['campaignproductitemimage_description']) && trim($_POST['campaignproductitemimage_description']) == '') {
		$errorArray['campaignproductitemimage_description'] = 'required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data = array();
		$data['campaignproductitemimage_name'] 			= trim($_POST['campaignproductitemimage_name']);
		$data['campaignproductitemimage_description']		= trim($_POST['campaignproductitemimage_description']);
		$data['campaignproductitemimage_code']				= $campaignproductitemimageObject->createReference();		
		$data['campaignproductitem_code']						= $campaignproductitemData['campaignproductitem_code'];
			
		$ext 						= strtolower($fileObject->file_extention($_FILES['imagefile']['name']));					
		$filename				= $data['campaignproductitemimage_code'].'.'.$ext;
		$directoryproduct	= $campaignproductitemData['campaign_directory'].'/media/products/'.$campaignproductitemData['campaignproductitem_code'];
		$directory				= $directoryproduct.'/'.$data['campaignproductitemimage_code'];
		$file						= $_SERVER['DOCUMENT_ROOT'].$directory.'/'.$filename;	
		
		if(!is_dir($directory)) mkdir($_SERVER['DOCUMENT_ROOT'].$directory, 0777, true);

		/* Create files for this product type. */
		foreach($zfsession->campaign['images'] as $image) {
		
			$newfilename = str_replace($filename, $image['code'].$filename, $file);

			/* Create new file and rename it. */
			$uploadObject	= PhpThumbFactory::create($_FILES['imagefile']['tmp_name']);
			$uploadObject->resize($image['width'], $image['height']);
			$uploadObject->save($newfilename);
		}

		$data['campaignproductitemimage_path']		= $zfsession->link.'media/products/'.$campaignproductitemData['campaignproductitem_code'].'/'.$data['campaignproductitemimage_code'];
		$data['campaignproductitemimage_filename']	= trim($_FILES['imagefile']['name']);
		$data['campaignproductitemimage_extension']	= '.'.$ext ;
		
		$success	= $campaignproductitemimageObject->insert($data);	
		
		/* Make newly inserted to be primary. */
		$campaignproductitemimageObject->updatePrimary(trim($data['campaignproductitemimage_code']), $data['campaignproductitem_code']	);
		
		if(is_numeric($success)) {
			header('Location: /admin/products/items/images.php?code='.$campaignproductData['campaignproduct_code'].'&item='.$campaignproductitemData['campaignproductitem_code']);
			exit;
		}
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
}
		
$campaignproductitemimageData = $campaignproductitemimageObject->getByItemCode($campaignproductitemData['campaignproductitem_code']);

if($campaignproductitemimageData) {
	$smarty->assign('campaignproductitemimageData', $campaignproductitemimageData);
}


 /* Display the template
 */	
$smarty->display('adminclient/MU3H/products/items/images.tpl');

?>