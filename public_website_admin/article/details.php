<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/* Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/* Check for login */
require_once 'includes/auth.php';

/* objects. */
require_once 'class/article.php';

$articleObject = new class_article();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$articleData = $articleObject->getByCode($code);

	if($articleData) {
		$smarty->assign('articleData', $articleData);
	} else {
		header('Location: /article/');
		exit;
	}
}

/* Check posted data. */
if(count($_POST) > 0) {
	$errorArray	= array();
	$data 		= array();
	$formValid	= true;
	$success	= NULL;
	
	if(isset($_POST['article_name']) && trim($_POST['article_name']) == '') {
		$errorArray['article_name'] = 'Name is required';
		$formValid = false;		
	}
	
	if(isset($_POST['article_description']) && trim($_POST['article_description']) == '') {
		$errorArray['article_description'] = 'Description is required';
		$formValid = false;		
	}
	
	if(isset($_POST['article_page']) && trim($_POST['article_page']) == '') {
		$errorArray['article_page'] = 'Page content is required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
	
		$data 	= array();				
		$data['article_name']			= trim($_POST['article_name']);		
		$data['article_description']	= trim($_POST['article_description']);	
		$data['article_page']			= htmlspecialchars_decode(stripslashes(trim($_POST['article_page'])));			
		
		if(isset($articleData)) {
			$where		= $articleObject->getAdapter()->quoteInto('article_code = ?', $articleData['article_code']);
			$success	= $articleObject->update($data, $where);			
		} else {
			$success = $articleObject->insert($data);
		}

		header('Location: /article/');	
		exit;		
		
		
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('article/details.tpl');

?>