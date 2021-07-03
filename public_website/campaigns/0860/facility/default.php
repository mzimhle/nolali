<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';

require_once 'class/product.php';

$productObject = new class_product();

/* Setup Pagination. */
$productData = $productObject->getAll('product.product_deleted = 0', 'product_name');

if($productData) $smarty->assign('productData', $productData);

/* End Pagination Setup. */
$smarty->display($zfsession->domainData['smartypath'].'/facility/default.tpl');

?>