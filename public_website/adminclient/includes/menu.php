<?php
/**
 * Standard includes
 */
global $smarty,  $zfsession;

//used for selected menu items
$page = explode('/',$_SERVER['REQUEST_URI']);
$currentPage = isset($page[2]) && trim($page[2]) != '' ? trim($page[2]) : '';

$smarty->assign('currentPage', $currentPage);

 /* Display the template */	
$smarty->display('adminclient/MU3H/includes/menu.tpl');
?>