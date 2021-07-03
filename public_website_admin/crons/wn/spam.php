<?php
//ini_set('max_execution_time', 300); //300 seconds = 5 minutes
ini_set('max_execution_time', 120); //300 seconds = 1 minute

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

//error_reporting(!E_NOTICE);

/* Check for login */

require_once 'class/ADMIN/_comms.php';
require_once 'class/ADMIN/spam.php';

$commsObject	= new class_wn_comms();
$spamObject 	= new class_spam();

$spamData = $spamObject->getToSpam(5);

if($spamData) {
	
	$error = '';
	$error .= '<b><h3>'.date('Y-m-d h:i:s').'</h3></b>';
	
	foreach($spamData as $item) {
		
		$error .= '===================<br />';
		$error .= '<b>'.$item['spam_name'].'</b><br />';
		$error .= $item['spam_email'].'<br />';		
		$error .= $item['spam_address'].'<br />';
		$error .= $item['spam_area'].'<br />';
		
		$data = array();
		$data['email'] 				= $item['spam_email'];
		$data['type'] 				= 'email';
		$data['title']					= 'Spam Email';
		$data['message'] 		= '';
		$data['name'] 				= $item['spam_name'];
		$data['reference'] 		= $item['pk_spam_id'];
		$data['domain'] 			= $_SERVER['HTTP_HOST'];
		$data['client_code'] 	= 'WNT-V8IK-R3';
		$data['category'] 		= 'spam';
		$data['fullname']			= $item['spam_name'];
		$data['cost']				= 0;

		$result = $commsObject->sendEmailComm('templates/comms/WNT-V8IK-R3/spam.html', $data, 'Willow-Nettica - Web Solutions', array('email' => 'info@willow-nettica.co.za', 'name' => 'Willow-Nettica'));
		
		if(!$result) {
			$error .= '<b>Error: Sending email.</b><br />';
		} else {
			$error .= 'EMAIL SENT<br />';
			
			/* Update sent date. */
			$data 						= array();
			$data['spam_sent']	= date('Y-m-d h:i:s');
			
			$where = $spamObject->getAdapter()->quoteInto('pk_spam_id = ?', $item['pk_spam_id']);
			$success = $spamObject->update($data, $where);
			
			if(is_numeric($success)) {
				$error .= 'Updated spam ID: '.$data['spam_sent'].'<br />';
			} else {
				$error .= '<b>Could not update ID: '.$data['spam_sent'].'</b><br />';
			}
			
			$data = null; $where = null;
			unset($data, $where);
		}
		
		$error .= '===================<br />';
	}
	
	$data = array();
	$data['email'] 				= 'admin@willow-nettica.co.za';
	$data['frommail'] 		= 'info@willow-nettica.co.za';
	$data['type'] 				= 'email';
	$data['title']					= 'Spam Email';
	$data['category']			= 'admin';
	$data['reference'] 		= null;
	$data['message'] 		= $error;
	$data['domain'] 			= $_SERVER['HTTP_HOST'];
	$data['client_code'] 	= 'WNT-V8IK-R3';
	$data['fullname']			= 'Mzimhle Mosiwe';
	$data['cost']				= 0;

	$commsObject->sendEmailComm('templates/comms/WNT-V8IK-R3/standard.html', $data, 'Willow-Nettica Spam Mail '.date('Y-m-d h:i:s'), array('email' => 'admin@willow-nettica.co.za', 'name' => 'Admin Willow-Nettica'));	

	echo $error;
}

?>