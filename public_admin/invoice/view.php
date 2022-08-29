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

$invoiceObject	= new class_invoice();

if (isset($_GET['id']) && trim($_GET['id']) != '') {
	
	$id = trim($_GET['id']);
	
	$invoiceData = $invoiceObject->getById($id);

	if(!$invoiceData) {
		header('Location: /template/');
		exit;		
	}
} else {
	header('Location: /template/');
	exit;		
}

$html = file_get_contents($zfsession->config['path'].$invoiceData['invoice_file_html']);

echo $html;

?>