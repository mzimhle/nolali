<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';
/* Class files */
require_once 'class/category.php';
/* Class objects */
$categoryObject		= new class_category(); 

if(isset($_GET['id']) && trim($_GET['id']) != '') {

	$id		                = trim($_GET['id']);
	$categoryData   = $categoryObject->getById($id);

	if($categoryData) {
		$smarty->assign('categoryData', $categoryData);
	} else {
		header('Location: /income/category/');
		exit;		
	}
}
/* Check posted data. */
if(count($_POST) > 0) {

	$errors	= array();
	
	if(!isset($_POST['category_name'])) {
		$errors[] = 'Please add name of the section';	
	} else if(trim($_POST['category_name']) == '') {
		$errors[] = 'Please add name of the section';	
	}
	
	if(!isset($_POST['category_code'])) {
		$errors[] = 'Please add code of the section';	
	} else if(trim($_POST['category_code']) == '') {
		$errors[] = 'Please add code of the section';	
	}
	
	if(count($errors) == 0) {
		/* Add the details. */
		$data							= array();				
		$data['category_name']	= trim($_POST['category_name']);
		$data['category_code']	= trim($_POST['category_code']);		
		/* Insert or update. */
		if(!isset($categoryData)) {
			/* Insert */
			$success = $categoryObject->insert($data);
			/* Check if all is well. */
			if(!$success) {
				$errors[] = 'We could not add the income category, please try again.';
			}
		} else {
			$where		= $categoryObject->getAdapter()->quoteInto('category_id = ?', $categoryData['category_id']);
			$categoryObject->update($data, $where);		
			$success	= $categoryData['category_id'];			
		}
	}
	/* Check errors and redirect if there are non. */
	if(count($errors) != 0) {
		/* if we are here there are errors. */
		$smarty->assign('errors', implode('<br />', $errors));
	} else {
		header('Location: /income/category/');
		exit;
	}
}

$smarty->display('income/category/details.tpl');
?>