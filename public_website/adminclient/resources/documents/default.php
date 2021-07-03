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

error_reporting(!E_ALL);

require_once 'class/MU3H/campaigndocument.php';

$campaigndocumentObject = new class_campaigndocument();

/* Filter. */
$filter						= "campaigndocument_deleted = 0";
$filter_fields				= "search_text~t"; // filter fields to remember
$filter_search_fields 	= "campaigndocument_name~t"; // should be text only fields
$select_score 			= '';
$order_score 			= '';

require_once 'administration/includes/filter.php';
global $filter;

/* Setup Pagination. */
$campaigndocumentData = $campaigndocumentObject->getAll($filter,'campaigndocument.campaigndocument_added DESC');

if($campaigndocumentData) $smarty->assign_by_ref('campaigndocumentData', $campaigndocumentData);

/* End Pagination Setup. */


 /* Display the template
 */	
$smarty->display('adminclient/MU3H/resources/documents/default.tpl');

?>