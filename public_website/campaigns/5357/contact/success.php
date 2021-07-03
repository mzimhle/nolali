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

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$inquiryData = $inquiryObject->getByCode($code);

	if(!$inquiryData) {
		header('Location: /contact/');
		exit;
	}
	
	$smarty->assign('inquiryData', $inquiryData);
} else {
	header('Location: /contact/');
	exit;
}

/* End Pagination Setup. */
$smarty->display('contact/success.tpl');

?>