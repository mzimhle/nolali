<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/** Check for login */
require_once 'includes/auth.php';

require_once 'class/product.php';

$productObject	= new class_product();

if(isset($_GET['delete_id'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$code					= trim($_GET['delete_id']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
	
		$data					= array();
		$data['product_deleted']	= 1;
		
		$where		= $productObject->getAdapter()->quoteInto('product_id = ?', $code);
		$success	= $productObject->update($data, $where);	

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
	$filter[] = array('filter_type' => isset($_REQUEST['filter_type']) && in_array(trim($_REQUEST['filter_type']), array('PRODUCT', 'SERVICE')) ? trim($_REQUEST['filter_type']) :  'PRODUCT,SERVICE,BOOK,CATALOG');	
    // For whom ever is logged in.
	$filter[] = array('filter_entity' => (isset($zfsession->activeEntity) ? $zfsession->activeEntity['entity_id'] : 0));
    $filter[] = array('filter_account' => (isset($zfsession->activeEntity) ? $zfsession->activeEntity['account_id'] : $zfsession->id));	
    
	$productData = $productObject->paginate($start, $length, $filter);

	$products = array();

	if($productData) {
		for($i = 0; $i < count($productData['records']); $i++) {
			$item = $productData['records'][$i];
			$products[$i] = array(
                'R'.number_format($item['price_amount'], 2, '.', ','),
				'<a href="/product/details.php?id='.trim($item['product_id']).'">'.trim($item['product_name']).'</a>',
                trim($item['product_text']),
				"<button onclick=\"deleteModal('".$item['product_id']."', '', 'default'); return false;\" class='btn'>Delete</button>"
			);
		}
	}

	if($productData) {
		$response['sEcho']					= $_REQUEST['sEcho'];
		$response['iTotalRecords']			= $productData['displayrecords'];		
		$response['iTotalDisplayRecords']	= $productData['count'];
		$response['aaData']					= $products;
	} else {
		$response['result']		= false;
		$response['message']	= 'There are no items to show.';			
	}
	echo json_encode($response);
	die();
}


$smarty->display('product/default.tpl');
?>