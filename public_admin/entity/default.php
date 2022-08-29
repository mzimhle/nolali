<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/** Check for login */
require_once 'includes/auth.php';

require_once 'class/entity.php';

$entityObject	= new class_entity(); 

if(isset($_GET['status_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$code					= trim($_GET['status_code']);
	$status					= trim($_GET['status']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
	
		$data					= array();
		$data['entity_active']	= $status;
		
		$where		= $entityObject->getAdapter()->quoteInto('entity_id = ?', $code);
		$success	= $entityObject->update($data, $where);	

		if($success) {
			$errorArray['error']	= '';
			$errorArray['result']	= 1;			
		} else {
			$errorArray['error']	= 'Could not update, please try again.';
			$errorArray['result']	= 0;				
		}
	}

	echo json_encode($errorArray);
	exit;
}

if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$code					= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
	
		$data					= array();
		$data['entity_deleted']	= $status;
		
		$where		= $entityObject->getAdapter()->quoteInto('entity_id = ?', $code);
		$success	= $entityObject->update($data, $where);	

		if($success) {
			$errorArray['error']	= '';
			$errorArray['result']	= 1;			
		} else {
			$errorArray['error']	= 'Could not update, please try again.';
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
	$length	= isset($_REQUEST['iDisplayLength']) ? $_REQUEST['iDisplayLength'] : 100;

	if(isset($_REQUEST['filter_search']) && trim($_REQUEST['filter_search']) != '') $filter[] = array('filter_search' => trim($_REQUEST['filter_search']));

	$entityData = $entityObject->paginate($start, $length, $filter);

	$entities = array();

	if($entityData) {
		for($i = 0; $i < count($entityData['records']); $i++) {
			$item = $entityData['records'][$i];
			$entities[$i] = array(
				trim($item['entity_code']),
				'<a href="/entity/details.php?id='.trim($item['entity_id']).'" class="'.($item['entity_active'] == 0 ? 'error' : 'success').'">'.trim($item['entity_name']).'</a>',
				trim($item['entity_address_physical']),
                "<button class='btn' onclick=\"statusModal('".$item['entity_id']."', '".((int)$item['entity_active'] == 1 ? 0 : 1)."', 'default'); return false;\">".((int)$item['entity_active'] == 1 ? 'Deactivate' : 'Activate')."</button>"
			);
		}
	}

	if($entityData) {
		$response['sEcho']					= $_REQUEST['sEcho'];
		$response['iTotalRecords']			= $entityData['displayrecords'];		
		$response['iTotalDisplayRecords']	= $entityData['count'];
		$response['aaData']					= $entities;
	} else {
		$response['result']		= false;
		$response['message']	= 'There are no items to show.';			
	}
	echo json_encode($response);
	die();
}

$smarty->display('entity/default.tpl');
?>