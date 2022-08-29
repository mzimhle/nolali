<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/** Check for login */
require_once 'includes/auth.php';

require_once 'class/category.php';

$categoryObject		= new class_category();

if(isset($_GET['delete_id'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$code					= trim($_GET['delete_id']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
	
		$data					            = array();
		$data['category_deleted']	= 1;
		
		$where		= $categoryObject->getAdapter()->quoteInto('category_id = ?', $code);
		$success	= $categoryObject->update($data, $where);	

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
	
	$categoryData = $categoryObject->paginate($start, $length, $filter);

	$category = array();

	if($categoryData) {
		for($i = 0; $i < count($categoryData['records']); $i++) {
			$item = $categoryData['records'][$i];
			$category[$i] = array(
				trim($item['category_code']),
				'<a href="/income/category/details.php?id='.trim($item['category_id']).'">'.trim($item['category_name']).'</a>',
				"<button onclick=\"deleteModal('".$item['category_id']."', '', 'default'); return false;\">Delete</button>"
			);
		}
	}

	if($categoryData) {
		$response['sEcho']					= $_REQUEST['sEcho'];
		$response['iTotalRecords']			= $categoryData['displayrecords'];		
		$response['iTotalDisplayRecords']	= $categoryData['count'];
		$response['aaData']					= $category;
	} else {
		$response['result']		= false;
		$response['message']	= 'There are no items to show.';			
	}
	echo json_encode($response);
	die();
}


$smarty->display('income/category/default.tpl');
?>