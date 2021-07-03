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

require_once 'class/invoice.php';

$invoiceObject = new class_invoice();

/* Setup Pagination. */
$invoiceData = $invoiceObject->getAll();

if($invoiceData) $smarty->assign_by_ref('invoiceData', $invoiceData);

 /* Display the template */	
$smarty->display('adminclient/MU3H/invoices/default.tpl');

?>