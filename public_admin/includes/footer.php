<?php
/*** Standard includes */
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';

if (!empty($_GET['getproductprice']) && $_GET['getproductprice'] != '') {
	
	require_once 'class/price.php';

	$priceObject	= new class_price();
	
	$id = trim($_GET['getproductprice']);
	
	$priceData = $priceObject->getByProduct($id);
	$html = "<option value=''> -- There is no price for this product or service -- </option>";
	if($priceData) {
		$html = "";
		foreach($priceData as $item) {
			$html .= '<option value="'.$item['price_id'].'">'.$item['price_quantity'].' of this product at R '.number_format($item['price_amount'], 2, ',', ' ').($item['price_discount'] != 0 ? ', discounted by '.$item['price_discount'].'% from R '.number_format($item['price_original'], 2, ',', ' ') : '').'</option>';
		}
	}
	echo $html;
	exit;
}

if (!empty($_GET['addcompany']) && $_GET['addcompany'] != '') {
	
	/* Class files */
	require_once 'class/company.php';
	/* Class objects */
	$companyObject	    = new class_company(); 
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 1;	

	if(isset($_GET['company_id']) && trim($_GET['company_id']) != '') {

		$code = trim($_GET['company_id']);

		$companyData = $companyObject->getById($code);

		if(!$companyData) {
			$errorArray['error']	= 'Company does not exist';
			$errorArray['result']	= 0;				
		}
	}
	
	if($errorArray['result'] == 1) {
		if(!isset($_GET['company_name'])) {
			$errorArray['error'] = 'Please add name of the company';	
			$errorArray['result']	= 0;
		} else if(trim($_GET['company_name']) == '') {
			$errorArray['error'] = 'Please add name of the company';	
			$errorArray['result']	= 0;
		}

		if(!isset($_GET['company_address'])) {
			$errorArray['error'] = 'Please add physical address';	
			$errorArray['result']	= 0;
		} else if(trim($_GET['company_address']) == '') {
			$errorArray['error'] = 'Please add physical address';	
			$errorArray['result']	= 0;
		}

		if(!isset($_GET['company_cellphone'])) {
			$errorArray['error'] = 'Please add a valid South African cellphone number';
			$errorArray['result']	= 0;
		} else if(trim($_GET['company_cellphone']) == '') {
			$errorArray['error'] = 'Please add a valid South African cellphone number';
			$errorArray['result']	= 0;
		} else if($companyObject->validateNumber(trim($_GET['company_cellphone'])) == '') {
			$errorArray['error'] = 'Please add a valid cellphone number.';
			$errorArray['result']	= 0;
		}

		if(!isset($_GET['company_email'])) {
			$errorArray['error'] = 'Please add a valid email address';
			$errorArray['result']	= 0;
		} else if(trim($_GET['company_email']) == '') {
			$errorArray['error'] = 'Please add a valid email address';
			$errorArray['result']	= 0;
		} else if($companyObject->validateEmail(trim($_GET['company_email'])) == '') {
			$errorArray['error'] = 'Please add a valid email address';
			$errorArray['result']	= 0;
		}

		if($errorArray['result'] == 1) {
			/* Add the details. */
			$data								= array();				
			$data['company_name']		= trim($_GET['company_name']);
			$data['company_address']		= trim($_GET['company_address']);
			$data['company_email']			= trim($_GET['company_email']);
			$data['company_cellphone']	= trim($_GET['company_cellphone']);
			/* Insert or update. */
			if(!isset($companyData)) {
				/* Insert */
				$success	= $companyObject->insert($data);
			} else {
				/* Update */
				$where		= $companyObject->getAdapter()->quoteInto('company_id = ?', $companyData['company_id']);
				$companyObject->update($data, $where);		
				$success	= $companyData['company_id'];			
			}
		}
	}
	echo json_encode($errorArray);
	die();
}

if (!empty($_GET['getParticipant']) && $_GET['getParticipant'] != '') {
	/* Class files */
	require_once 'class/participant.php';
	/* Class objects */
	$participantObject	    = new class_participant(); 

	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 1;	
	$errorArray['data']		= array();

	$id = (int)trim($_GET['getParticipant']);

	$participantData = $participantObject->getById($id);

	if($participantData) {
		$errorArray['data'] = $participantData;
	} else {
		$errorArray['result']	= 0;
		$errorArray['error']	= 'We could not find the participant';	
	}

	echo json_encode($errorArray);
	die();
}

if (isset($_POST['addUpdateParticipant']) && $_POST['addUpdateParticipant'] != '') {
	/* Class files */
	require_once 'class/participant.php';
	/* Class objects */
	$participantObject	    = new class_participant(); 

	$errorArray				= array();
	$errorArray['message']	= '';
	$errorArray['result']	= 1;	
	$errorArray['id']		= 1;	
	$errors					= array();

	if(isset($_POST['participant_id']) && trim($_POST['participant_id']) != '') {
		$participantData = $participantObject->getById(trim($_POST['participant_id']));
		if(!$participantData) {
			$errorArray['message']	= 'Participant was not found';
			$errorArray['result']	= 0;				
			echo json_encode($errorArray);
			die();
		}
	}
	
	if(!isset($_POST['participant_name'])) {
		$errors[] = 'Please add name of the participant';	
	} else if(trim($_POST['participant_name']) == '') {
		$errors[] = 'Please add name of the participant';	
	}

    if(isset($_POST['participant_cellphone']) && trim($_POST['participant_cellphone']) != '') {
		if($participantObject->validateNumber(trim($_POST['participant_cellphone'])) == '') {
			$errors[] = 'Please add a valid cellphone number.';
		} else {
			/* Check if cellphone already exists. */
			$check = isset($participantData) ? $participantData['participant_id'] : null;
			$checkCellphone = $participantObject->getByCell(trim($_POST['participant_cellphone']), $check);
			if($checkCellphone) {
				$errors[] = 'The cellphone number has already been used by another person.';
			}
		}
    }

    if(isset($_POST['participant_email']) && trim($_POST['participant_email']) != '') {
		if($participantObject->validateEmail(trim($_POST['participant_email'])) == '') {
			$errors[] = 'Please add a valid email address';
		} else {
			/* Check if cellphone already exists. */
			$check = isset($participantData) ? $participantData['participant_id'] : null;
			$checkCellphone = $participantObject->getByEmail(trim($_POST['participant_email']), $check);
			if($checkCellphone) {
				$errors[] = 'The email address has already been used by another person.';
			}
		}
    }

	if(count($errors) == 0) {
		/* Add the details. */
		$data							= array();				
		$data['participant_name']		= trim($_POST['participant_name']);
		$data['participant_address']	= trim($_POST['participant_address']);
        $data['participant_email']		= $participantObject->validateEmail(trim($_POST['participant_email']));
		$data['participant_cellphone']	= $participantObject->validateNumber(trim($_POST['participant_cellphone']));

		/* Insert or update. */
		if(!isset($participantData)) {
			/* Insert new participant. */
			$success	= $participantObject->insert($data);
		} else {
			/* Update participant. */
            $where      = array();
			$where[]    = $participantObject->getAdapter()->quoteInto('entity_id = ?', $zfsession->entity);
			$where[]    = $participantObject->getAdapter()->quoteInto('participant_id = ?', $participantData['participant_id']);
			$success	= $participantObject->update($data, $where);	
			$success 	= $participantData['participant_id'];
		}
	}
	/* Check errors and redirect if there are non. */
	if(count($errors) != 0) {
		$errorArray['message']	= implode('<br />', $errors);
		$errorArray['result']	= 0;
	} else {
		$errorArray['id'] = $success;
		$errorArray['message'] = $data['participant_name'];
	}
	
	echo json_encode($errorArray);
	die();
}

if (!empty($_GET['getProductCategory']) && $_GET['getProductCategory'] != '') {
	/* Class files */
	require_once 'class/productcategory.php';
	/* Class objects */
	$productcategoryObject	    = new class_productcategory(); 

	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 1;	
	$errorArray['data']		= array();

	$id = (int)trim($_GET['getProductCategory']);

	$productcategoryData = $productcategoryObject->getById($id);

	if($productcategoryData) {
		$errorArray['data'] = $productcategoryData;
	} else {
		$errorArray['result']	= 0;
		$errorArray['error']	= 'We could not find the participant';	
	}

	echo json_encode($errorArray);
	die();
}

if (isset($_POST['addUpdateProductCategory']) && $_POST['addUpdateProductCategory'] != '') {
	/* Class files */
	require_once 'class/productcategory.php';
	/* Class objects */
	$productcategoryObject	    = new class_productcategory(); 

	$errorArray				= array();
	$errorArray['message']	= '';
	$errorArray['result']	= 1;	
	$errorArray['id']		= 1;	
	$errors					= array();

	if(isset($_POST['productcategory_id']) && trim($_POST['productcategory_id']) != '') {
		$productcategoryData = $productcategoryObject->getById(trim($_POST['productcategory_id']));
		if(!$productcategoryData) {
			$errorArray['message']	= 'Product category was not found';
			$errorArray['result']	= 0;				
			echo json_encode($errorArray);
			die();
		}
	}

	if(!isset($_POST['productcategory_name'])) {
		$errors[] = 'Please add name of the product category';	
	} else if(trim($_POST['productcategory_name']) == '') {
		$errors[] = 'Please add name of the product category';	
	}

	if(count($errors) == 0) {
		/* Add the details. */
		$data							= array();				
		$data['productcategory_name']	= trim($_POST['productcategory_name']);
		/* Insert or update. */
		if(!isset($productcategoryData)) {
			/* Insert new productcategory. */
			$success	= $productcategoryObject->insert($data);
		} else {
			/* Update productcategory. */
            $where      = array();
			$where[]    = $productcategoryObject->getAdapter()->quoteInto('entity_id = ?', $zfsession->entity);
			$where[]    = $productcategoryObject->getAdapter()->quoteInto('productcategory_id = ?', $productcategoryData['productcategory_id']);
			$success	= $productcategoryObject->update($data, $where);	
			$success 	= $productcategoryData['productcategory_id'];
		}
	}
	/* Check errors and redirect if there are non. */
	if(count($errors) != 0) {
		$errorArray['message']	= implode('<br />', $errors);
		$errorArray['result']	= 0;
	} else {
		$errorArray['id'] = $success;
		$errorArray['message'] = $data['productcategory_name'].' has been added';
	}

	echo json_encode($errorArray);
	die();
}

if (!empty($_GET['viewInvoice']) && $_GET['viewInvoice'] != '') {
	/* Class files */
	require_once 'class/invoice.php';
	/* Class objects */
	$invoiceObject	    = new class_invoice(); 

	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 1;	
	$errorArray['data']		= array();

	$id = (int)trim($_GET['viewInvoice']);

	$invoiceData = $invoiceObject->getById($id);

	if($invoiceData) {
		$errorArray['data'] = $invoiceData;
	} else {
		$errorArray['result']	= 0;
		$errorArray['error']	= 'We could not find the invoice';	
	}

	echo json_encode($errorArray);
	die();
}
/* Display the template */		
$smarty->display('includes/footer.tpl');
?>



