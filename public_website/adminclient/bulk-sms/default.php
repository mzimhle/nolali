<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/* Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';
require_once 'adminclient/MU3H/includes/auth.php';

require_once 'class/_comm.php';

$commObject = new class_comm();

/* Setup Pagination. */
$commData = $commObject->getAll('_comm._comm_type = \'SMS\'');

if($commData) $smarty->assign_by_ref('commData', $commData);

$commDetails = $commObject->getCampaignSMSDetails();

if($commDetails) $smarty->assign('commDetails', $commDetails);

/* End Pagination Setup. */


 /* Display the template */
$smarty->display('adminclient/MU3H/bulk-sms/default.tpl');

?>