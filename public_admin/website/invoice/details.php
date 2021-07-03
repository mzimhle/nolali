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

/* objects. */
require_once 'class/campaign.php';
require_once 'class/invoice.php';

$campaignObject 	= new class_campaign();
$invoiceObject		= new class_invoice();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$invoiceData = $invoiceObject->getByCode($code);

	if($invoiceData) {
		
		$smarty->assign('invoiceData', $invoiceData);

	} else {
		header('Location: /website/invoice/');
		exit;
	}
}

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray		= array();
	$data 				= array();
	$formValid		= true;
	$success			= NULL;
	
	if(isset($_POST['invoice_person_name']) && trim($_POST['invoice_person_name']) == '') {
		$errorArray['invoice_person_name'] = 'Full name is required';
		$formValid = false;		
	}

	if(isset($_POST['invoice_person_email']) && trim($_POST['invoice_person_email']) != '') {
		if($invoiceObject->validateEmail(trim($_POST['invoice_person_email'])) == '') {
			$errorArray['invoice_person_email'] = 'Valid email is required';
			$formValid = false;	
		}
	} else {
		$errorArray['invoice_person_email'] = 'Email is required';
		$formValid = false;	
	}	
	
	if(isset($_POST['invoice_make']) && trim($_POST['invoice_make']) == '') {
		$errorArray['invoice_make'] = 'Invoice type required';
		$formValid = false;		
	}

	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();
		$data['invoice_person_name'] 		= trim($_POST['invoice_person_name']);	
		$data['invoice_person_email']			= trim($_POST['invoice_person_email']);		
		$data['invoice_person_number']		= trim($_POST['invoice_person_number']);		
		$data['invoice_make']					= trim($_POST['invoice_make']);
		$data['invoice_notes']					= trim($_POST['invoice_notes']);
		
		if(isset($invoiceData)) {		
			/*Update. */
			$where		= array();
			$where[]	= $invoiceObject->getAdapter()->quoteInto('campaign_code = ?', $zfsession->domainData['campaign_code']);
			$where[]	= $invoiceObject->getAdapter()->quoteInto('invoice_code = ?', $invoiceData['invoice_code']);
			$success	= $invoiceObject->update($data, $where);	
			$success	= $invoiceData['invoice_code'];
		} else {
			$success = $invoiceObject->insert($data);		
		}

		if(count($errorArray) == 0) {							
			header('Location: /website/invoice/item.php?code='.$success);		
			exit;		
		}				
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('website/invoice/details.tpl');

?>