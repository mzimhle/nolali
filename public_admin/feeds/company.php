<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';
/* Authentication */
require_once 'includes/auth.php';
/* Class files */
require_once 'class/company.php';
/* Objects */
$companyObject	= new class_company();

$results	= array();
$list		= array();	

if(isset($_REQUEST['term'])) {
		
	$q          = strtolower(trim($_REQUEST['term'])); 
	$companyData	= $companyObject->search($q, 10);
	
	if($companyData) {
		for($i = 0; $i < count($companyData); $i++) {
			$list[] = array(
				"id" 		=> $companyData[$i]["company_id"],
				"label" 	=> $companyData[$i]['company_name'].' ( '.$companyData[$i]['company_address'].' )',
				"value" 	=> $companyData[$i]['company_name'].' ( '.$companyData[$i]['company_address'].' )'
			);			
		}	
	}
}

if(count($list) > 0) {
	echo json_encode($list); 
	exit;
} else {
	echo json_encode(array('id' => '', 'label' => 'no results')); 
	exit;
}
exit;
?>