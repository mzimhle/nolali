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
require_once 'class/enquiry.php';

$enquiryObject 					= new class_enquiry();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$enquiryData = $enquiryObject->getByCode($code);

	if(!$enquiryData) {
		header('Location: /admin/enquiries/');
		exit;
	}
	
	$smarty->assign('enquiryData', $enquiryData);
	
}

 /* Display the template  */	
$smarty->display('adminclient/MU3H/enquiries/details.tpl');
?>