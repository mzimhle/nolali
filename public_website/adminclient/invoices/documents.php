<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';
require_once 'adminclient/MU3H/includes/auth.php';

/* objects. */
require_once 'class/invoice.php';
require_once 'class/invoicefile.php';
require_once 'class/File.php';

$invoiceObject		= new class_invoice();
$invoicefileObject 	= new class_invoicefile();
$fileObject 			= new File(array('doc', 'rtf', 'xls', 'ppt', 'docx', 'pdf', 'rar', 'zip', 'txt', 'png', 'gif', 'jpg'));

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$code = trim($_GET['code']);
	
	$invoiceData = $invoiceObject->getByCode($code);

	if(!$invoiceData) {
		header('Location: /admin/invoices/');
		exit;
	}
	$smarty->assign('invoiceData', $invoiceData);
} else {
	header('Location: /admin/invoices/');
	exit;
}

/* Check posted data. */
if(isset($_GET['invoicefile_code_delete'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$success					= NULL;
	$invoicefilecode		= trim($_GET['invoicefile_code_delete']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {	
		$data	= array();
		$data['invoicefile_deleted'] = 1;
		
		$where		= array();
		$where[]	= $invoicefileObject->getAdapter()->quoteInto('invoicefile_code = ?', $invoicefilecode);
		$where[]	= $invoicefileObject->getAdapter()->quoteInto('invoice_code = ?', $invoiceData['invoice_code']);
		
		$success	= $invoicefileObject->update($data, $where);	
		
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
	
	if(isset($_FILES['documentfile'])) {
		/* Check validity of the CV. */
		if((int)$_FILES['documentfile']['size'] != 0 && trim($_FILES['documentfile']['name']) != '') {
			/* Check if its the right file. */
			$ext = $fileObject->file_extention($_FILES['documentfile']['name']); 

			if($ext != '') {				
				$checkExt = $fileObject->getValidateExtention('documentfile', $ext);				
				if(!$checkExt) {
					$errorArray['documentfile'] = 'Please only upload jpg, jpeg or png image types';
					$formValid = false;						
				}
			} else {
				$errorArray['documentfile'] = 'Invalid file type';
				$formValid = false;									
			}
		} else {			
			switch((int)$_FILES['documentfile']['error']) {
				case 1 : $errorArray['documentfile'] = 'The uploaded file exceeds the maximum upload file size, should be less than 1M'; $formValid = false; break;
				case 2 : $errorArray['documentfile'] = 'File size exceeds the maximum file size'; $formValid = false; break;
				case 3 : $errorArray['documentfile'] = 'File was only partically uploaded, please try again'; $formValid = false; break;
				case 4 : $errorArray['documentfile'] = 'No file was uploaded'; $formValid = false; break;
				case 6 : $errorArray['documentfile'] = 'Missing a temporary folder'; $formValid = false; break;
				case 7 : $errorArray['documentfile'] = 'Faild to write file to disk'; $formValid = false; break;
			}
		}
	}

	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();		
		$data['invoicefile_code']				= $invoicefileObject->createReference();
		$data['invoicefile_description'] 	= trim($_POST['invoicefile_description']);					
		$data['invoice_code']					= $invoiceData['invoice_code'];
		$data['invoicefile_userfilename'] = trim($_FILES['documentfile']['name']);
		
		$ext 			= $fileObject->file_extention($_FILES['documentfile']['name']);					
		$filename	= $data['invoicefile_code'].'.'.$ext;
		$directory	= $_SERVER['DOCUMENT_ROOT'].$zfsession->domainData['campaign_directory'].'/media/invoice/'.$invoiceData['invoice_code'];
		$file			= $directory.'/'.$filename;	
		
		if(!is_dir($directory)) mkdir($directory, 0777, true);

		if(file_put_contents($file, file_get_contents($_FILES['documentfile']['tmp_name']))) {

			$data['invoicefile_filename'] 	= $filename;
			$data['invoicefile_path'] 			= $zfsession->link.'media/invoice/'.$invoiceData['invoice_code'].'/'.$filename;

			/* Insert */
			$success = $invoicefileObject->insert($data);	

			header('Location: /admin/invoices/documents.php?code='.$data['invoice_code']);
			exit();						
		} else {
			$errorArray['documentfile'] = 'Could not upload file, please try again.';
			$formValid = false;			
		}
	}	
	
	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);
}

$invoicefileData = $invoicefileObject->getByInvoiceCode($invoiceData['invoice_code']);

if($invoicefileData) {
	$smarty->assign('invoicefileData', $invoicefileData);
}


 /* Display the template
 */	
$smarty->display('adminclient/MU3H/invoices/documents.tpl');

?>