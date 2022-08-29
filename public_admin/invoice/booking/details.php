<?php
ini_set('safe_mode', false);
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
require_once 'includes/auth.php';
/* objects. */
require_once 'class/price.php';
require_once 'class/invoice.php';
require_once 'class/invoiceitem.php';
require_once 'class/bankentity.php';

$priceObject		= new class_price();
$invoiceObject		= new class_invoice();
$invoiceitemObject	= new class_invoiceitem();
$bankentityObject	= new class_bankentity(); 

if (isset($_GET['id']) && trim($_GET['id']) != '') {

	$id             = trim($_GET['id']);
	$invoiceData    = $invoiceObject->getById($id);

	if(!$invoiceData) {
		header('Location: /invoice/booking/');
		exit;
	}
	$smarty->assign('invoiceData', $invoiceData);
}

/* Check posted data. */
if(count($_POST) > 0 && !isset($_POST['generate_invoice'])) {

	$errors		= array();

	if(!isset($_POST['search_participant_id'])) {
		$errors[] = 'Please add owner of this invoice';
	} else if(trim($_POST['search_participant_id']) == '') {
		$errors[] = 'Please add owner of this invoice';
	}

	if(!isset($_POST['template_code'])) {
		$errors[] = 'Please add make of this invoice';
	} else if(trim($_POST['template_code']) == '') {
		$errors[] = 'Please add make of this invoice';
	}

	if(!isset($_POST['bankentity_id'])) {
		$errors[] = 'Please add bank account of the statement';	
	} else if(trim($_POST['bankentity_id']) == '') {
		$errors[] = 'Please add bank account of the statement';	
	}
	
	if(!isset($_POST['price_id'])) {
		$errors[] = 'Please select the room and price';
	} else if(trim($_POST['price_id']) == '') {
		$errors[] = 'Please select the room and price';
	} else {
		$priceData = $priceObject->getById(trim($_POST['price_id']));
		
		if(!$priceData) {
			$errors[] = 'Please select the valid price of the room';
		} else {
			if(!isset($_POST['invoiceitem_date_start'])) {
				$errors[] = 'Please select a start date';
			} else if(trim($_POST['invoiceitem_date_start']) == '') {
				$errors[] = 'Please select a start date';
			} else if(!isset($_POST['invoiceitem_date_end'])) {
				$errors[] = 'Please select a end date';
			} else if(trim($_POST['invoiceitem_date_end']) == '') {
				$errors[] = 'Please select a end date';
			} else if($invoiceObject->validateDate(trim($_POST['invoiceitem_date_start'])) == '') {
				$errors[] = 'Please select a start date';
			} else if($invoiceObject->validateDate(trim($_POST['invoiceitem_date_end'])) == '') {
				$errors[] = 'Please select a end date';
			} else {
				// Check booking conflict.
				if($invoiceObject->checkBooking($priceData['product_id'], $invoiceObject->validateDate(trim($_POST['invoiceitem_date_start'])), $invoiceObject->validateDate(trim($_POST['invoiceitem_date_end'])), (isset($invoiceData) ? $invoiceData['invoice_id'] : null))) {
					$errors[] = 'Date already been booked.';
				}
			}			
		}
	}


	
	if(count($errors) == 0) {

		$datediff = strtotime(trim($_POST['invoiceitem_date_end'])) - strtotime(trim($_POST['invoiceitem_date_start']));

		$data							= array();								
		$data['template_code']		    = trim($_POST['template_code']);	
		$data['invoice_date_payment']   = trim($_POST['invoiceitem_date_start']);
        $data['participant_id']         = trim($_POST['search_participant_id']);   
        $data['bankentity_id']         	= trim($_POST['bankentity_id']);

		$idata								= array();
		$idata['price_id']					= trim($_POST['price_id']);
		$idata['invoiceitem_date_start']	= trim($_POST['invoiceitem_date_start']);		
		$idata['invoiceitem_date_end']		= trim($_POST['invoiceitem_date_end']);
		$idata['invoiceitem_quantity']		= round($datediff / (60 * 60 * 24));
		$idata['invoiceitem_amount_unit']	= $priceData['price_amount'];
		$idata['invoiceitem_title']			= $idata['invoiceitem_quantity'].' nights in the '.$priceData['product_name'];

		if(isset($invoiceData)) {
			$where 	    = array();
			$where[]	= $invoiceObject->getAdapter()->quoteInto('invoice_id = ?', $invoiceData['invoice_id']);
			$success	= $invoiceObject->update($data, $where);		
			$success 	= $invoiceData['invoice_id'];
			
			$where	= $invoiceitemObject->getAdapter()->quoteInto('invoiceitem_id = ?', $invoiceData['invoiceitem_id']);
			$invoiceitemObject->update($idata, $where);	
		} else {
			$data['invoice_type']	= 'BOOKING';
			$success	= $invoiceObject->insert($data);
			// Add record.
			$idata['invoice_id']	= $success;
			$invoiceitemObject->insert($idata);	
		}

		header('Location: /invoice/booking/');
		exit;
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errors', implode('<br />', $errors));	
}

$bankentityPairs = $bankentityObject->pairs();
if($bankentityPairs) $smarty->assign('bankentityPairs', $bankentityPairs);

/* Display the template  */	
$smarty->display('invoice/booking/details.tpl');
?>