<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/*** Check for login */
require_once 'includes/auth.php';
/* Other resources. */

/* objects. */
require_once 'class/campaign.php';
require_once 'class/_campaignpackage.php';
require_once 'class/_package.php';

$campaignObject		= new class_campaign();
$campaignpackageObject	= new class_campaignpackage();
$packageObject		= new class_package();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$campaignData = $campaignObject->getByCode($code);
	
	if(!$campaignData) {
		header('Location: /campaign/');
		exit;
	}
	
	$smarty->assign('campaignData', $campaignData);
	
	$campaignpackageData = $campaignpackageObject->getByCampaign($code);

	if($campaignpackageData) {
		$smarty->assign('campaignpackageData', $campaignpackageData);
	}
} else {
	header('Location: /campaign/');
	exit;
}

$packagePairs = $packageObject->pairs();
if($packagePairs) $smarty->assign('packagePairs', $packagePairs);

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray	= array();
	$data 			= array();
	$formValid	= true;
	$success		= NULL;

	if(isset($_POST['_package_code']) && trim($_POST['_package_code']) == '') {
		$errorArray['_package_code'] = 'Please select package / service to link to campaign';
		$formValid = false;		
	} else {
		/* Check if already exists. */
		$check = $campaignpackageObject->getByCampaignPackage($campaignData['campaign_code'], trim($_POST['_package_code']));
		
		if($check) {
			$errorArray['_package_code'] = 'Product already linked to campaign.';
			$formValid = false;				
		}
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data = array();
		$data['_package_code'] 	= trim($_POST['_package_code']);
		$data['campaign_code']	= $campaignData['campaign_code'];

		$success	= $campaignpackageObject->insert($data);			
		
		if($success) {
			header('Location: /campaign/package.php?code='.$campaignData['campaign_code']);
			exit;
		}

	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
	
}

$smarty->display('campaign/package.tpl');


?>