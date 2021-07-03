<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/* standard config include. */
require_once 'config/database.php';
require_once 'config/smarty.php';

//include the Zend class for Authentification
require_once 'Zend/Session.php';

// Set up the namespace
$zfsession	= new Zend_Session_Namespace('ADMIN_WEBSITE_CLIENT');
	
/* Check if there is already one setup first. */
if (!isset($zfsession->domainData) || is_null($zfsession->domainData) || count($zfsession->domainData) == 0) { 

	require_once 'class/campaign.php';

	/* Get domain details. */
	$campaignObject = new class_campaign();		

	/* Check if domain exists on our side. */
	if(is_null($zfsession->domainData) || count($zfsession->domainData) == 0) {
	
		header('Location: http://www.nolali.co.za/');
		exit();				
	}
}

$smarty->assign('campaign', $zfsession->domainData);

global $zfsession;
?>