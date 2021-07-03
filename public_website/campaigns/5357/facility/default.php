<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';

require_once 'class/productitem.php';

$productitemObject = new class_productitem();

/* Setup Pagination. */
$productitemData = $productitemObject->getAll();

if($productitemData) $smarty->assign_by_ref('productitemData', $productitemData);

/* End Pagination Setup. */
$smarty->display('facility/default.tpl');

?>