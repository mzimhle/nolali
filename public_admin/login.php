<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';
require_once 'Zend/Session.php';

$zfsession = new Zend_Session_Namespace('ADMIN_SITE');

$zfsession->config	= $config;
// Tables
require_once 'class/account.php';
// Objects.
$accountObject = new class_account();
// Form submission
if ( !empty($_POST) && !is_null($_POST)) {

	$username	= (isset($_POST['account_user'])) ? $_POST['account_user'] : "-";
	$password   = (isset($_POST['account_password'])) ? $_POST['account_password'] : "-";

	$accountData = $accountObject->checkLogin($username, $password);	

	if ($accountData) {
        // Identity exists; store in session
        $zfsession->identity	= $accountData['account_id'];
        header("Location: /");
        exit;
	}else{
		$message = 'You are not a valid system user.';
		$smarty->assign( 'message', $message);
	}
}

$smarty->display('login.tpl');

?>