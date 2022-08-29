<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';

require_once 'class/invoicemonthly.php';
	
$invoicemonthlyObject	= new class_invoicemonthly();

if(isset($_GET['delete_id'])) {

	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success				= NULL;
	$code					= trim($_GET['delete_id']);

	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data						= array();
		$data['invoicemonthly_deleted']	= 1;
		
		$where 		= $invoicemonthlyObject->getAdapter()->quoteInto('invoicemonthly_id = ?', $code);
		$success	= $invoicemonthlyObject->update($data, $where);	
		
		if($success) {
			$errorArray['error']	= '';
			$errorArray['result']	= 1;			
		} else {
			$errorArray['error']	= 'Could not delete, please try again.';
			$errorArray['result']	= 0;				
		}
	}

	echo json_encode($errorArray);
	exit;
}

/* Setup Pagination. */
if(isset($_GET['action']) && trim($_GET['action']) == 'search') {

	$filter	= array();
	$csv	= 0;
	$start 	= isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'] : 0;
	$length	= isset($_REQUEST['iDisplayLength']) ? $_REQUEST['iDisplayLength'] : 20;

	if(isset($_REQUEST['filter_search']) && trim($_REQUEST['filter_search']) != '') $filter[] = array('filter_search' => trim($_REQUEST['filter_search']));
	
	$invoicemonthlyData = $invoicemonthlyObject->paginate($start, $length, $filter);

	$invoicemonthlys = array();

	if($invoicemonthlyData) {
		for($i = 0; $i < count($invoicemonthlyData['records']); $i++) {

			$item = $invoicemonthlyData['records'][$i];
			$invoicemonthlys[$i] = array(
				$item['invoicemonthly_date'],			
				'<a href="/invoice/monthly/details.php?id='.$item['invoicemonthly_id'].'" '.((int)$item['invoicemonthly_active'] == 1 ? 'class="success"' : 'class="error"').'>'.$item['participant_name'].' '.$item['participant_surname'].'</a>',
				$item['bankentity_name'],				
				$item['participant_cellphone'],
				'<button type="button" class="btn" onclick="javascript:deleteModal(\''.$item['invoicemonthly_id'].'\', \'\', \'default\');">Delete</button>'
			);
		}

		$response['sEcho']					= $_REQUEST['sEcho'];
		$response['iTotalRecords']			= $invoicemonthlyData['displayrecords'];		
		$response['iTotalDisplayRecords']	= $invoicemonthlyData['count'];
		$response['aaData']					= $invoicemonthlys;
	} else {
		$response['result']		= false;
		$response['message']	= 'There are no items to show.';			
	}

	echo json_encode($response);
	die();
}
/* Display the template */	
$smarty->display('invoice/monthly/default.tpl');

?>