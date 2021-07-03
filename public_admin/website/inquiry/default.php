<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

/**
 * Check for login
 */
require_once 'includes/auth.php';

require_once 'class/inquiry.php';

$inquiryObject = new class_inquiry();
 
/* Setup Pagination. */
$inquiryData = $inquiryObject->getAll();

if($inquiryData) $smarty->assign_by_ref('inquiryData', $inquiryData);

/* End Pagination Setup. */


$smarty->display('website/inquiry/default.tpl');

?>