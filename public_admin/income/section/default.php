<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/** Check for login */
require_once 'includes/auth.php';

require_once 'class/section.php';

$sectionObject		= new class_section();

if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$code					= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
	
		$data					= array();
		$data['section_deleted']	= 1;
		
		$where		= $sectionObject->getAdapter()->quoteInto('section_id = ?', $code);
		$success	= $sectionObject->update($data, $where);	

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

	$sectionData = $sectionObject->paginate($start, $length, $filter);

	$section = array();

	if($sectionData) {
		for($i = 0; $i < count($sectionData['records']); $i++) {
			$item = $sectionData['records'][$i];
			$section[$i] = array(
				'<a href="/income/section/details.php?id='.trim($item['section_id']).'">'.trim($item['section_name']).'</a>',
                trim($item['category_name']),
				trim($item['section_code']),
				(int)$item['section_calculated'] == 0 ? 'No' : 'Yes',
				(int)$item['section_direction'] == 0 ? 'Expense' : 'Income',
				"<button onclick=\"deleteModal('".$item['section_id']."', '', 'default'); return false;\">Delete</button>"
			);
		}
	}

	if($sectionData) {
		$response['sEcho']					= $_REQUEST['sEcho'];
		$response['iTotalRecords']			= $sectionData['displayrecords'];		
		$response['iTotalDisplayRecords']	= $sectionData['count'];
		$response['aaData']					= $section;
	} else {
		$response['result']		= false;
		$response['message']	= 'There are no items to show.';			
	}
	echo json_encode($response);
	die();
}

$smarty->display('income/section/default.tpl');
?>