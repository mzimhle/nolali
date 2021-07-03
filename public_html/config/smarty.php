<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR .$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/* Show all errors. */
error_reporting(E_ALL);

/* path constants */
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('LIBS', ROOT . '/library');
define('WWW', 'http://' . $_SERVER['HTTP_HOST']);
define('URI', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

/* 
	Setup Smarty Templating System.
*/

require_once(LIBS.'/classes/smarty/Smarty.class.php');

$smarty = new Smarty;

/* config smarty debug build setup. */
$smarty->debugging 		= false;

/* set smarty cache settings */
$smarty->caching 			= false;
$smarty->force_compile 	= true;

$smarty->compile_check 	= true; 	/* don't check for dependent file changes */
$smarty->cache_lifetime 	= 0; 		/* 2 = per template defined! 0=disabled */

/* set smarty folders */
$smarty->template_dir 	= ROOT.'/';
$smarty->compile_dir 	= ROOT.'/cache/smarty/compile/';
$smarty->config_dir 	= LIBS.'/classes/smarty/config/';
$smarty->cache_dir 		= ROOT.'/cache/smarty/cache/';
$smarty->plugins_dir 	= array(LIBS.'/classes/smarty/plugins/', LIBS.'/classes/smarty/smarty_custom_plugins/');

/* Get a random number for the images. */
$cachRandom = substr(md5(rand(123,9876123) . time()), 1, 10); $smarty->assign('nc',$cachRandom); 
?>