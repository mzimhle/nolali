<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/* standard config include. */
require_once 'config/database.php';
require_once 'config/smarty.php';

//include the Zend class for Authentification
require_once 'Zend/Session.php';

// Set up the namespace
$zfsession	= new Zend_Session_Namespace('client');

/* Check if there is already one setup first. */
if (!isset($zfsession->domainData) || is_null($zfsession->domainData) || count($zfsession->domainData) == 0) { 

	require_once 'class/campaign.php';
	
	/* Get domain details. */
	$campaignObject			= new class_campaign();		

	/* Check if domain exists on our side. */
	if($campaignObject->_domainData) {
		
		/* Success, save in session. At least this will run once all the time. */
		$zfsession->domainData =  $campaignObject->_domainData;

		$zfsession->link = '/campaign/';
		
		$zfsession->domainData['smartypath']	= ltrim($zfsession->domainData['campaign_directory'], '/');		
		$smarty->assign('smartypath', $zfsession->domainData['smartypath']);
	
	} else {
		/* Does not exist. */
		header('Location: /404/2');
		exit();			
	}
}

$smarty->assign('domainData', $zfsession->domainData);

/*************************************************************************************************** SETUP ALLOWED CAMPAIGN PAGES. */
$campaignpageschunks = array_chunk($zfsession->domainData['pages'], 3);

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
/*************************************************************************************************** END SETUP ALLOWED CAMPAIGN PAGES. */

/* Reset the paths. But check if its root or admin. */
/* Check if its admin */
$pos = strpos($_SERVER['REQUEST_URI'], '/admin');

if($pos === false) {
	set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$zfsession->domainData['campaign_directory'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
} else { 	
	set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/adminclient/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
}

//used for selected menu items
$temppage = explode('/',$_SERVER['REQUEST_URI']);

$sitePage = isset($temppage[2]) && trim($temppage[2]) != '' ? trim($temppage[2]) : '';

$smarty->assign('link', $zfsession->link);
																				
$smarty->assign('images', $zfsession->campaign['images']);

$smarty->assign('smartypath',  ltrim($zfsession->domainData['campaign_directory'], '/'));

global $zfsession;
?>