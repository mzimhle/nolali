<?php

//error_reporting(!E_DEPRECATED);

//standard config include.
require_once 'config/database.php';
require_once 'config/smarty.php';

//include the Zend class for Authentification
require_once 'Zend/Session.php';

// Set up the namespace
$zfsession = new Zend_Session_Namespace('BackendLogin');

// Check if logged in, otherwise redirect
if (!isset($zfsession->identity) || is_null($zfsession->identity) || $zfsession->identity == '') {
	header('Location: /login.php');
	exit();
} else {
	//instantiate the users class
	require_once 'class/administrator.php';
	$users = new class_administrator();
	
	//get user details by username
	$usersData = $users->getByCode($zfsession->identity);
	
	$smarty->assign('admin', $usersData);
}

if(isset($zfsession->domainData) && !empty($zfsession->domainData)) {
	$zfsession->domainData = $zfsession->domainData;
	$smarty->assign('domainData', $zfsession->domainData);
} else {
	$zfsession->domainData = array();
}

?>