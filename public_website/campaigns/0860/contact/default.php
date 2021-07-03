<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';

require_once 'class/enquiry.php';

$enquiryObject = new class_enquiry();

require_once('captcha/recaptchalib.php');

$publickey = "6LeHxP0SAAAAAJRI4czgJWLG5rPzFmQNV2ZYoXD_ ";
$privatekey = "6LeHxP0SAAAAAHvkfLAM51xfxd9K_cZEsqW7RM8j";

# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray		= array();
	$formValid		= true;
	
  $resp = recaptcha_check_answer ($privatekey,  $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

	if ($resp->is_valid) {
		/* Do nothing. */
	} else {
		$errorArray['enquiry_captcha'] = $resp->error;
		$formValid = false;	
	}
	
	if(isset($_POST['areapost_code']) && trim($_POST['areapost_code']) == '') {
		$errorArray['areapost_code'] = 'Area required';
		$formValid = false;		
	}	
	
	if(isset($_POST['enquiry_name']) && trim($_POST['enquiry_name']) == '') {
		$errorArray['enquiry_name'] = 'Fullname required';
		$formValid = false;		
	}	
	
	if(isset($_POST['enquiry_comments']) && trim($_POST['enquiry_comments']) == '') {
		$errorArray['enquiry_comments'] = 'Comments required';
		$formValid = false;		
	}
	
	if(isset($_POST['enquiry_subject']) && trim($_POST['enquiry_subject']) == '') {
		$errorArray['enquiry_subject'] = 'Subject required';
		$formValid = false;		
	}

	if(isset($_POST['enquiry_email']) && trim($_POST['enquiry_email']) != '') {
		if($enquiryObject->validateEmail(trim($_POST['enquiry_email'])) == '') {
			$errorArray['enquiry_email'] = 'Email not valid';
			$formValid = false;	
		}
	} else {
		$errorArray['enquiry_email'] = 'Email required';
		$formValid = false;					
	}
	
	if(isset($_POST['enquiry_number']) && trim($_POST['enquiry_number']) != '') {
		if($enquiryObject->validateCell(trim($_POST['enquiry_number'])) == '') {
			$errorArray['enquiry_number'] = 'Cell not valid';
			$formValid = false;	
		}
	}
	

	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();				
		$data['enquiry_name']		= trim($_POST['enquiry_name']);		
		$data['areapost_code']		= trim($_POST['areapost_code']);	
		$data['enquiry_subject']		= trim($_POST['enquiry_subject']);	
		$data['enquiry_number']		= trim($_POST['enquiry_number']);	
		$data['enquiry_comments']	= trim($_POST['enquiry_comments']);	
		$data['enquiry_email']		= $enquiryObject->validateEmail(trim($_POST['enquiry_email']));		
		$data['enquiry_number']	= $enquiryObject->validateCell(trim($_POST['enquiry_number']));		

		$success = $enquiryObject->insert($data);

		if(count($errorArray) == 0) {							
			header('Location: /campaign/contact/success.php?code='.$success);	
			exit;		
		}
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->assign('captchahtml', recaptcha_get_html($publickey, $error));

/* End Pagination Setup. */
$smarty->display($zfsession->domainData['smartypath'].'/contact/default.tpl');

?>