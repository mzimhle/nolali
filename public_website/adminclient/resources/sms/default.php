<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/* Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';
require_once 'adminclient/MU3H/includes/auth.php';

//error_reporting(!E_ALL);

require_once 'class/_comms.php';

$commsObject = new class_comms();

/* Setup Pagination. */
$commsData = $commsObject->getByCampaign($zfsession->domainData['campaign_code'], 'sms');

if($commsData) $smarty->assign_by_ref('commsData', $commsData);

$commsDetails = $commsObject->getCampaignSMSDetails($zfsession->domainData['campaign_code']);

if($commsDetails) $smarty->assign('commsDetails', $commsDetails);

/* End Pagination Setup. */


 /* Display the template */
$smarty->display('adminclient/MU3H/resources/sms/default.tpl');

?>