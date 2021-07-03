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
require_once 'class/MU3H/campaigndocument.php';
require_once 'class/MU3H/campaigndocumentitem.php';
require_once 'class/MU3H/File.php';

$campaigndocumentObject				= new class_campaigndocument();
$campaigndocumentitemObject 	= new class_campaigndocumentitem();
$fileObject 								= new File(array('pdf', 'xls', 'txt', 'docx', 'doc', 'cvs', 'zip', 'rar'));

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$campaigndocumentData = $campaigndocumentObject->getByCode($code);

	if(!$campaigndocumentData) {
		header('Location: /admin/resources/documents/');
		exit;
	}
	
	$smarty->assign('campaigndocumentData', $campaigndocumentData);
} else {
	header('Location: /admin/resources/documents/');
	exit;	
}

/* Check posted data. */
if(isset($_GET['campaigndocumentitem_code_delete'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$itemcode					= trim($_GET['campaigndocumentitem_code_delete']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {	
		$data	= array();
		$data['campaigndocumentitem_deleted'] = 1;
		
		$where		= array();
		$where[]	= $campaigndocumentitemObject->getAdapter()->quoteInto('campaigndocumentitem_code = ?', $itemcode);
		$where[]	= $campaigndocumentitemObject->getAdapter()->quoteInto('campaigndocument_code = ?', $campaigndocumentData['campaigndocument_code']);
		
		$success	= $campaigndocumentitemObject->update($data, $where);	
		
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
if(isset($_GET['campaigndocumentitem_code_update'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;
	$data 						= array();
	$formValid				= true;
	$success					= NULL;
	$itemcode					= trim($_GET['campaigndocumentitem_code_update']);
	
	if(isset($_GET['campaigndocumentitem_name']) && trim($_GET['campaigndocumentitem_name']) == '') {
		$errorArray['error'] = 'name required.';	
	}	
	
	if(isset($_GET['campaigndocumentitem_description']) && trim($_GET['campaigndocumentitem_description']) == '') {
		$errorArray['error'] = 'description required.';	
	}

	if($errorArray['error']  == '') {
		
		$data 	= array();		
		$data['campaigndocumentitem_name'] 					= trim($_GET['campaigndocumentitem_name']);		
		$data['campaigndocumentitem_description'] 			= trim($_GET['campaigndocumentitem_description']);			
		$data['campaigndocumentitem_active'] 					= 1;	
		
		$where		= array();
		$where[]	= $campaigndocumentitemObject->getAdapter()->quoteInto('campaigndocumentitem_code = ?', $itemcode);
		$where[]	= $campaigndocumentitemObject->getAdapter()->quoteInto('campaigndocument_code = ?', $campaigndocumentData['campaigndocument_code']);
		$success	= $campaigndocumentitemObject->update($data, $where);	

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
	
	if(isset($_FILES['itemfile'])) { 
		/* Check validity of the CV. */
		if((int)$_FILES['itemfile']['size'] == 0) {
			/* Check if its the right file. */
			$errorArray['itemfile'] = 'Please try to upload again, its size is empty or 0.';
			$formValid = false;	
		}
	}
	
	if(isset($_POST['campaigndocumentitem_name']) && trim($_POST['campaigndocumentitem_name']) == '') {
		$errorArray['campaigndocumentitem_name'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['campaigndocumentitem_description']) && trim($_POST['campaigndocumentitem_description']) == '') {
		$errorArray['campaigndocumentitem_description'] = 'required';
		$formValid = false;		
	}

	if(count($errorArray) == 0 && $formValid == true) {
		
		
		$data = array();
		$data['campaigndocumentitem_name'] 			= trim($_POST['campaigndocumentitem_name']);
		$data['campaigndocumentitem_description']		= trim($_POST['campaigndocumentitem_description']);
		$data['campaigndocumentitem_code']				= $campaigndocumentitemObject->createReference();		
		$data['campaigndocument_code']					= $campaigndocumentData['campaigndocument_code'];
			
		$ext 						= strtolower($fileObject->file_extention($_FILES['itemfile']['name']));					
		$filename				= $data['campaigndocumentitem_code'].'.'.$ext;
		$directorydocument	= $campaigndocumentData['campaign_directory'].'/media/document/'.$campaigndocumentData['campaigndocument_code'];
		$directory				= $_SERVER['DOCUMENT_ROOT'].$directorydocument;
		$file						= $directory.'/'.$filename;	
		
		if(!is_dir($directory)) mkdir($directory, 0777, true);

		if(file_put_contents($file, file_get_contents($_FILES['itemfile']['tmp_name']))) {

			$data['campaigndocumentitem_path']			= $zfsession->link.'media/document/'.$campaigndocumentData['campaigndocument_code'].'/'.$data['campaigndocumentitem_code'].'.'.$ext;
			$data['campaigndocumentitem_filename']	= trim($_FILES['itemfile']['name']);

			$success	= $campaigndocumentitemObject->insert($data);	
	
		} else {
			$errorArray['campaigndocumentitem_name'] = 'required';
			$formValid = false;			
		}
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
}

		
$campaigndocumentitemData = $campaigndocumentitemObject->getByDocument($campaigndocumentData['campaigndocument_code']);

if($campaigndocumentitemData) {
	$smarty->assign('campaigndocumentitemData', $campaigndocumentitemData);
}


 /* Display the template
 */	
$smarty->display('adminclient/MU3H/resources/documents/item.tpl');

?>