<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';

/* objects. */
require_once 'class/invoice.php';

$invoiceObject			= new class_invoice();

$code		= isset($_REQUEST['code']) && trim($_REQUEST['code']) != '' ? trim($_REQUEST['code']) : '';

$invoiceData = $invoiceObject->getByCode($code);

if($invoiceData) {

		$htmlfile 	= $_SERVER['DOCUMENT_ROOT'].$invoiceData['invoice_file'];
		$pdffile	= 	$_SERVER['DOCUMENT_ROOT'].str_replace('.html', '.pdf', $invoiceData['invoice_file']);

		header("Content-Type: application/pdf");
		header("Cache-Control: no-cache");
		header("Accept-Ranges: none");
		header('Content-Disposition: attachment; filename="'.$invoiceData['invoice_reference'].'.pdf"');			
		
		echo file_get_contents($pdffile);
		exit;		

} else {
	echo 'Invalid code';
	exit;
}


?>