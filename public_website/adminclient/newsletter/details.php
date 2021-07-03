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
require_once 'class/newsletter.php';
require_once 'class/participant.php';

$newsletterObject	= new class_newsletter();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$newsletterData = $newsletterObject->getByCode($code);

	if(!$newsletterData) {
		header('Location: /admin/newsletter/');
		exit;
	}

	$smarty->assign('newsletterData', $newsletterData);
}

/* Check posted data. */
if(count($_POST) > 0) {
	$errorArray	= array();
	$data 		= array();
	$formValid	= true;
	$success	= NULL;
	
	if(isset($_POST['newsletter_name']) && trim($_POST['newsletter_name']) == '') {
		$errorArray['newsletter_name'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['newsletter_subject']) && trim($_POST['newsletter_subject']) == '') {
		$errorArray['newsletter_subject'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['newsletter_content']) && trim($_POST['newsletter_content']) == '') {
		$errorArray['newsletter_content'] = 'required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
	
		$data 	= array();				
		$data['newsletter_name']	= trim($_POST['newsletter_name']);		
		$data['newsletter_subject']	= trim($_POST['newsletter_subject']);	
		$data['newsletter_content']	= trim($_POST['newsletter_content']);			
		
		if(isset($newsletterData)) {
			$where		= $newsletterObject->getAdapter()->quoteInto('newsletter_code = ?', $newsletterData['newsletter_code']);
			$success	= $newsletterObject->update($data, $where);			
			$success 	= $newsletterData['newsletter_code'];
		} else {
			$success = $newsletterObject->insert($data);
		}
		
		if($success) {
			
			$newsletterData = $newsletterObject->getByCode($success);
			
			if($newsletterData) {
				$smarty->assign('newsletterData', $newsletterData);		
				
				$message = $smarty->fetch('templates/'.$newsletterObject->_campaign->_campaigncode.'/newsletter/newsletter.html');
				
				$data = array();
				$data['newsletter_page']	= $message;	
				
				$where		= $newsletterObject->getAdapter()->quoteInto('newsletter_code = ?', $success);
				$success	= $newsletterObject->update($data, $where);	
				$success 	= $newsletterData['newsletter_code'];				
			
			} else {
				$errorArray['newsletter_content'] = 'Could not update content';
				$formValid = false;						
			}
		}		

		header('Location: /admin/newsletter/mail.php?code='.$success);	
		exit;
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}
 /* Display the template  */	
$smarty->display('adminclient/MU3H/newsletter/details.tpl');
?>