<?php
ini_set('safe_mode', false);
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';
require_once 'includes/auth.php';
/* objects. */
require_once 'class/invoicemonthly.php';
require_once 'class/bankentity.php';

$invoicemonthlyObject	= new class_invoicemonthly();
$bankentityObject		= new class_bankentity(); 

if (isset($_GET['id']) && trim($_GET['id']) != '') {
	
	$id             = trim($_GET['id']);
	$invoicemonthlyData    = $invoicemonthlyObject->getById($id);

	if(!$invoicemonthlyData) {
		header('Location: /invoice/monthly/');
		exit;
	}

	$smarty->assign('invoicemonthlyData', $invoicemonthlyData);
}

/* Check posted data. */
if(count($_POST) > 0 && !isset($_POST['generate_invoicemonthly'])) {

	$errors		= array();

	if(!isset($_POST['participant_id'])) {
		$errors[] = 'Please add owner of this invoicemonthly';
	} else if(trim($_POST['participant_id']) == '') {
		$errors[] = 'Please add owner of this invoicemonthly';
	}

	if(!isset($_POST['invoicemonthly_date'])) {
		$errors[] = 'Please add date for payment';
	} else if(trim($_POST['invoicemonthly_date']) == '') {
        $errors[] = 'Please add date for payment';
    } else if($invoicemonthlyObject->validateDate(trim($_POST['invoicemonthly_date'])) == '') {
        $errors[] = 'Please add a valid date';
    }

	if(!isset($_POST['bankentity_id'])) {
		$errors[] = 'Please add bank account of the statement';	
	} else if(trim($_POST['bankentity_id']) == '') {
		$errors[] = 'Please add bank account of the statement';	
	}

	if(count($errors) == 0) {

		$data								= array();								
		$data['invoicemonthly_date']	= trim($_POST['invoicemonthly_date']);
        $data['participant_id']         	= trim($_POST['participant_id']);   
        $data['bankentity_id']         	= trim($_POST['bankentity_id']);   

		if(isset($invoicemonthlyData)) {
			$where 	    = array();
			$where[]	= $invoicemonthlyObject->getAdapter()->quoteInto('invoicemonthly_id = ?', $invoicemonthlyData['invoicemonthly_id']);
			$success	= $invoicemonthlyObject->update($data, $where);		
			$success 	= $invoicemonthlyData['invoicemonthly_id'];		
		} else {
			$success    = $invoicemonthlyObject->insert($data);
		}	

		header('Location: /invoice/monthly/item.php?id='.$success);
		exit;
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errors', implode('<br />', $errors));	
}

$bankentityPairs = $bankentityObject->pairs();
if($bankentityPairs) $smarty->assign('bankentityPairs', $bankentityPairs);

/* Display the template  */	
$smarty->display('invoice/monthly/details.tpl');
?>