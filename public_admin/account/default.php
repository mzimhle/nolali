<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/** Check for login */
require_once 'includes/auth.php';

require_once 'class/account.php';

$accountObject	= new class_account(); 

if(isset($_GET['status_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$code					= trim($_GET['status_code']);
	$status					= trim($_GET['status']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
	
		$data					= array();
		$data['account_active']	= $status;
		
		$where		= $accountObject->getAdapter()->quoteInto('account_id = ?', $code);
		$success	= $accountObject->update($data, $where);	

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
		$data['account_deleted']	= $status;
		
		$where		= $accountObject->getAdapter()->quoteInto('account_id = ?', $code);
		$success	= $accountObject->update($data, $where);	

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

	$accountData = $accountObject->paginate($start, $length, $filter);

	$accounts = array();

	if($accountData) {
		for($i = 0; $i < count($accountData['records']); $i++) {
			$item = $accountData['records'][$i];
			$accounts[$i] = array(
                "<button class='btn' onclick=\"statusModal('".$item['account_id']."', '".((int)$item['account_active'] == 1 ? 0 : 1)."', 'default'); return false;\">".((int)$item['account_active'] == 1 ? 'Deactivate' : 'Activate')."</button>",
				'<a href="/account/details.php?id='.trim($item['account_id']).'" class="'.($item['account_active'] == 0 ? 'error' : 'success').'">'.trim($item['account_name']).'</a>',				
				trim($item['account_cellphone']),
				trim($item['account_password']),
				trim($item['account_email']),
				trim($item['account_type'])				
			);
		}
	}

	if($accountData) {
		$response['sEcho']					= $_REQUEST['sEcho'];
		$response['iTotalRecords']			= $accountData['displayrecords'];		
		$response['iTotalDisplayRecords']	= $accountData['count'];
		$response['aaData']					= $accounts;
	} else {
		$response['result']		= false;
		$response['message']	= 'There are no items to show.';			
	}
	echo json_encode($response);
	die();
}

$smarty->display('account/default.tpl');
?>