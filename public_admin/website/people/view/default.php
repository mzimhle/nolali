<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

/**
 * Check for login
 */
require_once 'includes/auth.php';

require_once 'class/participant.php';

$participantObject = new class_participant();
 
if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$code						= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['participant_deleted'] = 1;
		
		$where 	= array();
		$where[] 	= $participantObject->getAdapter()->quoteInto('participant_code = ?', $code);
		$where[] 	= $participantObject->getAdapter()->quoteInto('campaign_code = ?', $zfsession->domainData['campaign_code']);
		$success	= $participantObject->update($data, $where);	
		
		if(is_numeric($success) && $success > 0) {
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

if(isset($_GET['action']) && trim($_GET['action']) == 'tablesearch') {

	$search = isset($_REQUEST['search']) && trim($_REQUEST['search']) != '' ? trim($_REQUEST['search']) : null;
	$start 	= isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'] : 0;
	$length = isset($_REQUEST['iDisplayLength']) ? $_REQUEST['iDisplayLength'] : 20;
	
	$participantData = $participantObject->getSearch($search, $start, $length);
	$all = array();

	if($participantData) {
		for($i = 0; $i < count($participantData['records']); $i++) {
			$item = $participantData['records'][$i];
			$all[$i] = array(
								($item['participant_image_name'] == '' ? '<img src="/images/no-image.jpg" width="80" />' : '<img src="http://'.$item['campaign_domain'].'/'.$item['participant_image_path'].'/tny_'.$item['participant_image_name'].$item['participant_image_extension'].'" width="80" />'),
								$item['participant_added'], 
								$item['campaign_name'], 
								'<a class="'.($item['participant_active'] == 0 ? 'error' : 'success').'" href="/website/people/view/details.php?code='.$item['participant_code'].'">'.$item['participant_name'].' '.$item['participant_surname'].'</a>', 
								$item['participant_email'], 
								$item['participant_cellphone'],
								($item['participant_active'] == 0 ? '<span class="error">Nonactive</span>' : '<span class="success">Active</span>'), 
								"<button onclick=\"deleteitem('".$item['participant_code']."'); return false;\">Delete</button>");
		}
	}
	

	$response['sEcho'] = $_REQUEST['sEcho'];
	$response['iTotalRecords'] = $participantData['displayrecords'];		
	$response['iTotalDisplayRecords'] = $participantData['count'];
	$response['aaData']	= $all;

	
    echo json_encode($response);
    die();	
}

/* End Pagination Setup. */


$smarty->display('website/people/view/default.tpl');

?>