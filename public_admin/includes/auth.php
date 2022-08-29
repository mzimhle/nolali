<?php
date_default_timezone_set('Africa/Johannesburg');
ini_set('date.timezone', 'Africa/Johannesburg');
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/* standard config include. */
require_once 'config/database.php';
require_once 'config/smarty.php';
//include the Zend class for Authentification
require_once 'Zend/Session.php';
// Set up the namespace
$zfsession	= new Zend_Session_Namespace('ADMIN_SITE');
// Check if logged in, otherwise redirect
if (!isset($zfsession->identity) || is_null($zfsession->identity) || $zfsession->identity == '') {
	header('Location: /login.php');
	exit();
} else {
	// instantiate the account class
	require_once 'class/account.php';
	require_once 'class/entity.php';	
	// objects
	$accountObject	= new class_account();
	$entityObject	= new class_entity();	
	//get user details by username
	$activeAccount = $accountObject->getById($zfsession->identity);

	$smarty->assign('activeAccount', $activeAccount);
	/* accountistrator selected page. */
	$zfsession->activeAccount = $activeAccount;
	/* accountistrator selected page. */
	$zfsession->account	= $activeAccount['account_id'];    
    //$smarty->assign('account', $zfsession->account);
	/* Get configuration settings. */
	$zfsession->config = $config;

	if(isset($zfsession->entity) && $zfsession->entity != null) {
		$activeEntity = $entityObject->getById($zfsession->entity);
		if($activeEntity) {
			$zfsession->activeEntity = $activeEntity;
			$smarty->assign('entity', $zfsession->entity);
			$smarty->assign('activeEntity', $activeEntity);	
            $smarty->assign('account', $activeEntity['account_id']);
		}
	} else {
		$zfsession->activeEntity = null; $zfsession->entity = null;
		unset($zfsession->activeEntity); unset($zfsession->entity);
	}
	
	unset($activeEntity, $entityObject, $accountObject);
}

/* Check paegs. */
global $zfsession;
$smarty->assign('config', $zfsession->config);
?>