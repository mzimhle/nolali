<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/*** Check for login */
require_once 'includes/auth.php';
/* Other resources. */

/* objects. */
require_once 'class/booking.php';
require_once 'class/_payment.php';
require_once 'class/File.php';

$bookingObject			= new class_booking();
$paymentObject	= new class_payment();
$fileObject					= new File(array('zip', 'doc', 'docx', 'txt', 'pdf'));

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$bookingData = $bookingObject->getByCode($code);
	
	if(!$bookingData) {
		header('Location: /booking/');
		exit;
	}
	
	$smarty->assign('bookingData', $bookingData);
	
	$paymentData = $paymentObject->getByType($code, 'BOOKING');

	if($paymentData) {
		$smarty->assign('paymentData', $paymentData);
	}
	
} else {
	header('Location: /booking/');
	exit;
}

if(isset($_GET['delete_code'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$code						= trim($_GET['delete_code']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
		$data	= array();
		$data['_payment_deleted'] = 1;
		
		$where 	= array();
		$where[]	= $paymentObject->getAdapter()->quoteInto('_payment_reference = ?', $bookingData['booking_code']);
		$where[]	= $paymentObject->getAdapter()->quoteInto('_payment_type = ?', 'BOOKING');
		$success	= $paymentObject->update($data, $where);	
		
		if(is_numeric($success) && $success > 0) {
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

/* Check posted data. */
if(count($_POST) > 0) {

	$errorArray	= array();
	$data 			= array();
	$formValid	= true;
	$success		= NULL;

	if(isset($_POST['_payment_paid_date']) && trim($_POST['_payment_paid_date']) == '') {
		$errorArray['_payment_paid_date'] = 'Date of payment is required';
		$formValid = false;		
	}
	
	if(isset($_POST['_payment_amount']) && (int)trim($_POST['_payment_amount']) == 0) {
		$errorArray['_payment_amount'] = 'Payment amount is required';
		$formValid = false;		
	}
	
	if(isset($_FILES['paymentfile'])) {
		/* Check validity of the CV. */
		if((int)$_FILES['paymentfile']['size'] != 0 && trim($_FILES['paymentfile']['name']) != '') {
			/* Check if its the right file. */
			$ext = $fileObject->file_extention($_FILES['paymentfile']['name']); 

			if($ext != '') {				
				$checkExt = $fileObject->getValidateExtention('paymentfile', $ext);				
				if(!$checkExt) {
					$errorArray['paymentfile'] = 'Invalid file type something funny with the file format';
					$formValid = false;						
				} else {
					/* Check width and height */
					$paymentfile = $fileObject->getValidateSize($_FILES['paymentfile']['size']);
					
					if(!$paymentfile) {
						$errorArray['paymentfile'] = 'File needs to be less than 2MB.';
						$formValid = false;							
					}
				}
			} else {
				$errorArray['paymentfile'] = 'Invalid file type';
				$formValid = false;									
			}
		} else {			
			switch((int)$_FILES['paymentfile']['error']) {
				case 1 : $errorArray['paymentfile'] = 'The uploaded file exceeds the maximum upload file size, should be less than 1M'; $formValid = false; break;
				case 2 : $errorArray['paymentfile'] = 'File size exceeds the maximum file size'; $formValid = false; break;
				case 3 : $errorArray['paymentfile'] = 'File was only partically uploaded, please try again'; $formValid = false; break;
				//case 4 : $errorArray['paymentfile'] = 'No file was uploaded'; $formValid = false; break;
				case 6 : $errorArray['paymentfile'] = 'Missing a temporary folder'; $formValid = false; break;
				case 7 : $errorArray['paymentfile'] = 'Faild to write file to disk'; $formValid = false; break;
			}
		}
	}

	if(count($errorArray) == 0 && $formValid == true) {
		
		$data = array();
		$data['_payment_amount'] 	= trim($_POST['_payment_amount']);
		$data['_payment_paid_date'] 	= trim($_POST['_payment_paid_date']);
		$data['_payment_reference']	= $bookingData['booking_code'];
		$data['_payment_type']			= 'BOOKING';

		$success	= $paymentObject->insert($data);			
		
		if(isset($_FILES['paymentfile'])) {
			if((int)$_FILES['paymentfile']['size'] != 0 && trim($_FILES['paymentfile']['name']) != '') {
			
				$ext 			= strtolower($fileObject->file_extention($_FILES['paymentfile']['name']));					
				$filename	= $success.'.'.$ext;
				$directory	= realpath(__DIR__.'/../../').$zfsession->domainData['campaign_directory'].'/media/booking/'.$bookingData['booking_code'].'/payments/';	
				$file			= $directory.$filename;

				if(!is_dir($directory)) mkdir($directory, 0777, true);
				
				if(file_put_contents($file, file_get_contents($_FILES['paymentfile']['tmp_name']))) {
					
					$data = array();
					$data['_payment_file']	= '/media/booking/'.$bookingData['booking_code'].'/payments/'.$filename;
					
					$where 	= array();
					$where[]	= $paymentObject->getAdapter()->quoteInto('_payment_reference = ?', $bookingData['booking_code']);
					$where[]	= $paymentObject->getAdapter()->quoteInto('_payment_type = ?', 'BOOKING');
					$success	= $paymentObject->update($data, $where);	
					
				} else {
					$errorArray['paymentfile'] = 'could not upload file, please try again';
					$formValid = false;			
				}
			}
		}
		
		
		if($success) {
			header('Location: /booking/payment.php?code='.$bookingData['booking_code']);
			exit;
		}

	}
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
	
}

$smarty->display('booking/payment.tpl');


?>