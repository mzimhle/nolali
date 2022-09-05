<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/** Check for login */
require_once 'includes/auth.php';

require_once 'class/content.php';

$contentObject	= new class_content();

if(isset($_GET['delete_id'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$code					= trim($_GET['delete_id']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
	
		$data					= array();
		$data['content_deleted']	= 1;
		
		$where		= $contentObject->getAdapter()->quoteInto('content_id = ?', $code);
		$success	= $contentObject->update($data, $where);	

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
	$filter[] = array('filter_type' => 'ARTICLE');	
    
	$contentData = $contentObject->paginate($start, $length, $filter);

	$contents = array();

	if($contentData) {
		for($i = 0; $i < count($contentData['records']); $i++) {
			$item = $contentData['records'][$i];
			$contents[$i] = array(
                ($item['media_code'] != '' ? '<img src="'.$zfsession->config['site'].$item['media_path'].'tny_'.$item['media_code'].$item['media_ext'].'" />' : '<img src="/images/no-image.png" />'),
				'<a href="/content/article/details.php?id='.trim($item['content_id']).'">'.trim($item['content_name']).'</a>',
				"<button onclick=\"deleteModal('".$item['content_id']."', '', 'default'); return false;\" class='btn'>Delete</button>"
			);
		}
	}

	if($contentData) {
		$response['sEcho']					= $_REQUEST['sEcho'];
		$response['iTotalRecords']			= $contentData['displayrecords'];		
		$response['iTotalDisplayRecords']	= $contentData['count'];
		$response['aaData']					= $contents;
	} else {
		$response['result']		= false;
		$response['message']	= 'There are no items to show.';			
	}
	echo json_encode($response);
	die();
}


$smarty->display('content/article/default.tpl');
?>