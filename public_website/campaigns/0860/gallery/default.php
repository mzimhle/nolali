<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'includes/auth.php';

require_once 'class/gallery.php';

$galleryObject = new class_gallery();

/* Setup Pagination. */
$galleryData = $galleryObject->getAll('gallery.gallery_deleted = 0', 'gallery_name');

if($galleryData) $smarty->assign('galleryData', $galleryData);

/* End Pagination Setup. */
$smarty->display($zfsession->domainData['smartypath'].'/gallery/default.tpl');

?>