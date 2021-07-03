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

require_once 'class/enquiry.php';

$enquiryObject = new class_enquiry();

/* Setup Pagination. */
$enquiryData = $enquiryObject->getAll();

if($enquiryData) $smarty->assign_by_ref('enquiryData', $enquiryData);

/* End Pagination Setup. */


 /* Display the template
 */	
$smarty->display('adminclient/MU3H/enquiries/default.tpl');

?>