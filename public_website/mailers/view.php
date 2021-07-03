<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
	
/** Standard includes */
require_once 'config/database.php';
	
/* Other resources. */
require_once 'includes/auth.php';

if (isset($_GET['code']) && trim($_GET['code']) != '') {

	/* objects. */
	require_once 'class/_comm.php';

	$commObject 	= new class_comm();
	
	$code = trim($_GET['code']);
	
	$commData = $commObject->getByCode($code);
	
	if($commData) {
		echo $commData['_comm_html']; exit;
	} else {
		header('Location: http://'.$zfsession->domainData['campaign_domain']);
		exit;
	}
	
} else {
	header('Location: http://'.$zfsession->domainData['campaign_domain']);
	exit;
}

