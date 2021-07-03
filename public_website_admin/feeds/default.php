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
require_once 'class/campaign.php';

$campaignObject		= new class_campaign();

if(isset($_REQUEST['campaigncode'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$campaigncode		= trim($_GET['campaigncode']);
	
	$campaignData = $campaignObject->getByCode($campaigncode);

	if($campaignData) {
		$errorArray['error']	= '';
		$errorArray['result']	= 1;	
		
		$zfsession->domainData = $campaignData;
	} else {
		$errorArray['error']	= 'Campaign could not be found.';
		$errorArray['result']	= 0;			
	}
	
	echo json_encode($errorArray);
	exit;
	
}


$campaignPairs	= $campaignObject->pairs();
if($campaignPairs) $smarty->assign('campaignPairs', $campaignPairs);

if(isset($zfsession->domainData['_component'])) {


	$campaignpageschunks = array_chunk($zfsession->domainData['_component'], 3);

	if(isset($campaignpageschunks[0])) {
		$smarty->assign('level1', $campaignpageschunks[0]);
	}

	if(isset($campaignpageschunks[1])) {
		$smarty->assign('level2', $campaignpageschunks[1]);
	}

	if(isset($campaignpageschunks[2])) {
		$smarty->assign('level3', $campaignpageschunks[2]);
	}

	if(isset($campaignpageschunks[3])) {
		$smarty->assign('level4', $campaignpageschunks[3]);
	}
}
 /* Display the template
 */	
$smarty->display('website/default.tpl');

?>