<?php
/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
require_once 'includes/auth.php';

global $zfsession;
// Clear the identity from the session
$zfsession->identity = null; 
$zfsession->activeAccount = null; 
$zfsession->entity = null; 
$zfsession->activeEntity = null; 
$zfsession = null;
unset($zfsession->identity);
unset($zfsession->activeAccount);
unset($zfsession->entity);
unset($zfsession->activeEntity);
unset($zfsession);
//redirect to login page
header('Location: /login.php');
exit;

?>