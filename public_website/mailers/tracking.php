<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/** Standard includes */
require_once 'config/database.php';
	
/* Other resources. */
require_once 'includes/auth.php';

if (isset($_GET['tracking']) && trim($_GET['tracking']) != '') {

	/* objects. */
	require_once 'class/_comm.php';

	$commObject 	= new class_comm();
	
	$tracking = trim($_GET['tracking']);
	
	$commData = $commObject->getByCode($tracking);

	if($commData) {
		
		require_once 'class/_tracker.php';
		
		$trackerObject = new class_tracker();
			
		/* Insert data. */
		$data = array();
		$data['_comm_code'] 				= $commData['_comm_code'];
		
		$trackerObject->insert($data);
		
	}
}

