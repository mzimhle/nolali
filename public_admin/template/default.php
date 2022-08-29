<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/** Check for login */
require_once 'includes/auth.php';

require_once 'class/template.php';

$templateObject	= new class_template(); 

if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$code					= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
	
		$data								= array();
		$data['template_deleted']	= 1;
		
		$where		= $templateObject->getAdapter()->quoteInto('template_id = ?', $code);
		$success	= $templateObject->update($data, $where);	

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
	$length	= isset($_REQUEST['iDisplayLength']) ? $_REQUEST['iDisplayLength'] : 100;

	if(isset($_REQUEST['filter_search']) && trim($_REQUEST['filter_search']) != '') $filter[] = array('filter_search' => trim($_REQUEST['filter_search']));
	
	$templateData = $templateObject->paginate($start, $length, $filter);

	$templates = array();

	if($templateData) {
		for($i = 0; $i < count($templateData['records']); $i++) {
			$item = $templateData['records'][$i];
			$view = '';
			if($item['template_category'] == 'EMAIL') {
				$view = '<a href="/template/view.php?id='.$item['template_id'].'" target="_blank">'.$item['template_subject'].'</a>';
			} else if($item['template_category'] == 'SMS') {
				$view = $item['template_message'];
			}
			$templates[$i] = array(
				'<a href="/template/details.php?id='.trim($item['template_id']).'">'.trim($item['template_code']).'</a>',
				trim($item['template_category']),
				$view,
				"<button class='btn' onclick=\"deleteModal('".$item['template_id']."', '', 'default'); return false;\">Delete</button>"
			);
		}
	}

	if($templateData) {
		$response['sEcho']							= $_REQUEST['sEcho'];
		$response['iTotalRecords']				= $templateData['displayrecords'];		
		$response['iTotalDisplayRecords']	= $templateData['count'];
		$response['aaData']						= $templates;
	} else {
		$response['result']		= false;
		$response['message']	= 'There are no items to show.';			
	}
	echo json_encode($response);
	die();
}


$smarty->display('template/default.tpl');
?>