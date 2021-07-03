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

$campaigndocumentObject		= new class_campaigndocument();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$campaigndocumentData = $campaigndocumentObject->getByCode($code);

	if(!$campaigndocumentData) {
		header('Location: /admin/galleries/');
		exit;
	}
	
	$smarty->assign('campaigndocumentData', $campaigndocumentData);
}

/* Check posted data. */
if(count($_POST) > 0) {
	
	$errorArray		= array();
	$data 				= array();
	$formValid		= true;
	$success			= NULL;
	
	if(isset($_POST['campaigndocument_name']) && trim($_POST['campaigndocument_name']) == '') {
		$errorArray['campaigndocument_name'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['campaigndocument_description']) && trim($_POST['campaigndocument_description']) == '') {
		$errorArray['campaigndocument_description'] = 'required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();						
		$data['campaigndocument_name']			= trim($_POST['campaigndocument_name']);					
		$data['campaigndocument_description']	= htmlspecialchars_decode(stripslashes(trim($_POST['campaigndocument_description'])));	
		
		if(isset($campaigndocumentData)) {
		
			/*Update. */
			$where		= $campaigndocumentObject->getAdapter()->quoteInto('campaigndocument_code = ?', $campaigndocumentData['campaigndocument_code']);
			$success	= $campaigndocumentObject->update($data, $where);
			
			header('Location: /admin/resources/documents/item.php?code='.$campaigndocumentData['campaigndocument_code']);
			exit;					
			
		} else {
			
			$data['campaign_code'] 					= $zfsession->domainData['campaign_code'];			
			$data['campaigndocument_code']	= $campaigndocumentObject->createReference();
			
			$success = $campaigndocumentObject->insert($data);
							
			header('Location: /admin/resources/documents/item.php?code='.$data['campaigndocument_code']);
			exit;
		}					
	}

	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}
 /* Display the template  */	
$smarty->display('adminclient/MU3H/resources/documents/details.tpl');
?>