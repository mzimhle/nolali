<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';
/* objects. */
require_once 'class/template.php';
require_once 'class/invoiceitem.php';

$templateObject	= new class_template();
$invoiceitemObject	= new class_invoiceitem();

if (isset($_GET['id']) && trim($_GET['id']) != '') {
	
	$id = trim($_GET['id']);
	
	$templateData = $templateObject->getById($id);

	if(!$templateData) {
		header('Location: /template/');
		exit;		
	}
} else {
	header('Location: /template/');
	exit;		
}


$invoiceData = $invoiceitemObject->getForTemplate();

if($invoiceData) {
	$smarty->assign('invoiceData', $invoiceData);
	$smarty->assign('invoiceitemData', $invoiceData['items']);
}

$html = $smarty->fetch($zfsession->config['path'].$templateData['template_file']);

$html = str_replace('[date]', date("F j, Y, g:i a"), $html);
$html = str_replace('[host]', $_SERVER['HTTP_HOST'], $html);
$html = str_replace('[site]', 'http://yam.loc/', $html);
$html = str_replace('[mediapath]', $zfsession->config['site'].'/media/template/'.strtolower($templateData['template_id']).'/media/', $html);	

echo $html;
exit;
?>