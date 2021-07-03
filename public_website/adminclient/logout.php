<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'adminclient/MU3H/includes/auth.php';

global $zfsession;

// Clear the identity from the session
unset($zfsession->userData);
unset($zfsession);
unset($zfsession);

//redirect to login page
header('Location: /admin/login.php');
exit;
?>