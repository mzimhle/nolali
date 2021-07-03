<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';

require_once 'class/inquiry.php';

$inquiryObject = new class_inquiry();

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
	/* Do nothing. 
  $resp = recaptcha_check_answer ($privatekey,  $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

	if ($resp->is_valid) {
		
	} else {
		$errorArray['inquiry_captcha'] = $resp->error;
		$formValid = false;	
	}
	
	if(isset($_POST['areapost_code']) && trim($_POST['areapost_code']) == '') {
		$errorArray['areapost_code'] = 'Area required';
		$formValid = false;		
	}	
	*/
	if(isset($_POST['inquiry_name']) && trim($_POST['inquiry_name']) == '') {
		$errorArray['inquiry_name'] = 'Fullname required';
		$formValid = false;		
	}	
	
	if(isset($_POST['inquiry_comments']) && trim($_POST['inquiry_comments']) == '') {
		$errorArray['inquiry_comments'] = 'Comments required';
		$formValid = false;		
	}
	
	if(isset($_POST['inquiry_subject']) && trim($_POST['inquiry_subject']) == '') {
		$errorArray['inquiry_subject'] = 'Subject required';
		$formValid = false;		
	}

	if(isset($_POST['inquiry_email']) && trim($_POST['inquiry_email']) != '') {
		if($inquiryObject->validateEmail(trim($_POST['inquiry_email'])) == '') {
			$errorArray['inquiry_email'] = 'Email not valid';
			$formValid = false;	
		}
	} else {
		$errorArray['inquiry_email'] = 'Email required';
		$formValid = false;					
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();				
		$data['inquiry_name']		= trim($_POST['inquiry_name']);		
		$data['areapost_code']		= trim($_POST['areapost_code']);	
		$data['inquiry_subject']	= trim($_POST['inquiry_subject']);	
		$data['inquiry_number']		= trim($_POST['inquiry_number']);	
		$data['inquiry_comments']	= trim($_POST['inquiry_comments']);	
		$data['inquiry_email']		= $inquiryObject->validateEmail(trim($_POST['inquiry_email']));		
		$data['inquiry_number']		= trim($_POST['inquiry_number']);		

		$success = $inquiryObject->insert($data);

		if(count($errorArray) == 0) {							
			header('Location: /contact/success.php?code='.$success);	
			exit;		
		}
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

// $smarty->assign('captchahtml', recaptcha_get_html($publickey, $error));

/* End Pagination Setup. */
$smarty->display('contact/default.tpl');

?>