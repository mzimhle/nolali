<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';
require_once 'includes/auth.php';
require_once 'Zend/Session.php';

$zfsession = new Zend_Session_Namespace('client');

if (!empty($_POST) && !is_null($_POST)) {

	if(isset($_POST['username']) && isset($_POST['password'])) {
	
		$username = (isset($_POST['username'])) ? $_POST['username'] : "";
		$password = (isset($_POST['password'])) ? $_POST['password'] : "";
	
		require_once 'class/administrator.php';
		
		$administratorObject	= new class_administrator();
		
		$loginData 			= $administratorObject->campaignLogin($username, $password);
		$message				= '';

		if($loginData) {

			// Identity exists; store in session
			$zfsession->userData	= $loginData;
			
			//record last login for user
			$data = array('administrator_last_login' => date('Y-m-d H:i:s'));
			$where = $administratorObject->getAdapter()->quoteInto('administrator_code = ?', $zfsession->userData['administrator_code']);
			$administratorObject->update($data, $where);


			header("Location: /admin/");
			exit;
		} else {
			$message = 'You are not a valid system user';
		}//end check for user
				
	} else {
		$message = 'Please put in username and password';
	}
	
	$smarty->assign('message', $message);
}

 /* Display the template
 */	
$smarty->display('adminclient/MU3H/login.tpl');
?>