<?php
ini_set('safe_mode', false);
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
require_once 'includes/auth.php';
/* objects. */
require_once 'class/invoice.php';
require_once 'class/invoiceitem.php';

$invoiceObject          = new class_invoice();
$invoiceitemObject      = new class_invoiceitem(); 

if (isset($_GET['id']) && trim($_GET['id']) != '') {

	$id             = trim($_GET['id']);
	$invoiceData    = $invoiceObject->getById($id);

	if(!$invoiceData) {
		header('Location: /invoice/');
		exit;
	}
	$smarty->assign('invoiceData', $invoiceData);
}

/* Check posted data. */
if(count($_POST) > 0 && !isset($_POST['generate_invoice'])) {

	$errors		= array();
    
    if(!isset($zfsession->entity)) {
        if(!isset($_POST['search_entity_id'])) {
            $errors[] = 'Please add owner of this invoice';
        } else if(trim($_POST['search_entity_id']) == '') {
            $errors[] = 'Please add owner of this invoice';
        }
    } else {
        if(!isset($_POST['search_participant_id'])) {
            $errors[] = 'Please add owner of this invoice';
        } else if(trim($_POST['search_participant_id']) == '') {
            $errors[] = 'Please add owner of this invoice';
        }

    }
    
    if(!isset($_POST['invoice_date_payment'])) {
        $errors[] = 'Please add expiry date for the invoice';
    } else if(trim($_POST['invoice_date_payment']) == '') {
        $errors[] = 'Please add expiry date for the invoice';
    } else if($invoiceObject->validateDate(trim($_POST['invoice_date_payment'])) == '') {
        $errors[] = 'Please add a valid date';
    }

	if(count($errors) == 0) {

		$data							= array();								
		$data['template_code']		    = 'INVOICE';
        $data['invoice_date_payment']   = trim($_POST['invoice_date_payment']);
        $data['entity_id']              = !isset($zfsession->entity) ? trim($_POST['search_entity_id']) : null; 
        $data['participant_id']         = isset($zfsession->entity) ? trim($_POST['search_participant_id']) : null;         

		if(isset($invoiceData)) {
			$where 	    = array();
			$where[]	= $invoiceObject->getAdapter()->quoteInto('invoice_id = ?', $invoiceData['invoice_id']);
			$success	= $invoiceObject->update($data, $where);		
			$success 	= $invoiceData['invoice_id'];		
		} else {
			$success    = $invoiceObject->insert($data);
		}	

        $invoiceObject->updateInvoice($success);

		header('Location: /invoice/item.php?id='.$success);
		exit;
	}
	
	/* if we are here there are errors. */
	$smarty->assign('errors', implode('<br />', $errors));	
}

/* Display the template  */	
$smarty->display('invoice/details.tpl');
?>