<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';
/* objects. */
require_once 'class/invoice.php';

$invoiceObject		= new class_invoice();

if (isset($_GET['id']) && trim($_GET['id']) != '') {
	
	$id = trim($_GET['id']);
	
	$invoiceData = $invoiceObject->getById($id);

	if(!$invoiceData) {
		echo 'Could not download invoice PDF';
		exit;		
	}

} else {
	echo 'Could not download invoice PDF';
	exit;		
}

$url = $invoiceObject->createInvoice($id);

if(false !== $url) {
    // We'll be outputting a PDF
    header('Content-type: application/pdf');
    // It will be called downloaded.pdf
    header('Content-Disposition: attachment; filename="'.$invoiceData['invoice_code'].'.pdf"');
    // The PDF source is in original.pdf
    readfile($url);
}
exit;
?>