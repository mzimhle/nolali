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
require_once 'class/section.php';
/* Class objects */
$categoryObject	= new class_category(); 
$sectionObject	= new class_section(); 

if(isset($_GET['id']) && trim($_GET['id']) != '') {

	$id                     = trim($_GET['id']);
	$sectionData	= $sectionObject->getById($id);

	if($sectionData) {
		$smarty->assign('sectionData', $sectionData);
	} else {
		header('Location: /income/section/');
		exit;		
	}
}
/* Check posted data. */
if(count($_POST) > 0) {

	$errors	= array();
	$data		= array();

	if(!isset($_POST['section_name'])) {
		$errors[] = 'Please add name of the section';	
	} else if(trim($_POST['section_name']) == '') {
		$errors[] = 'Please add name of the section';	
	}

	if(!isset($_POST['section_calculated'])) {
		$errors[] = 'Please specify if calculated';
	} else if(trim($_POST['section_calculated']) == '') {
		$errors[] = 'Please specify if calculated';
	}
	
	if(!isset($_POST['section_direction'])) {
		$errors[] = 'Please add direction of section';
	} else if(trim($_POST['section_direction']) == '') {
		$errors[] = 'Please add direction of section';
	}
	
	if(!isset($_POST['category_id'])) {
		$errors[] = 'Please add category of section';
	} else if(trim($_POST['category_id']) == '') {
		$errors[] = 'Please add category of section';
	}
	
	if(count($errors) == 0) {
		/* Add the details. */
		$data               = array();				
		$data['category_id'] = trim($_POST['category_id']);
		$data['section_code'] = trim($_POST['section_code']);
		$data['section_calculated'] = trim($_POST['section_calculated']);
		$data['section_name'] = trim($_POST['section_name']);
		$data['section_direction'] = trim($_POST['section_direction']);	
		/* Insert or update. */
		if(!isset($sectionData)) {
			/* Insert */
			$success = $sectionObject->insert($data);
			/* Check if all is well. */
			if(!$success) {
				$errors[] = 'We could not add the Income Section, please try again.';
			}
		} else {
			$where		= $sectionObject->getAdapter()->quoteInto('section_id = ?', $sectionData['section_id']);
			$sectionObject->update($data, $where);		
			$success	= $sectionData['section_id'];			
		}
	}
	/* Check errors and redirect if there are non. */
	if(count($errors) != 0) {
		/* if we are here there are errors. */
		$smarty->assign('errors', implode('<br />', $errors));
	} else {
		header('Location: /income/section/');
		exit;
	}
}

$categoryPairs = $categoryObject->pairs();
if($categoryPairs) $smarty->assign('categoryPairs', $categoryPairs);

$smarty->display('income/section/details.tpl');
?>