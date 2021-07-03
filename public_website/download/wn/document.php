<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/* Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'administration/includes/auth.php';

/* objects. */
require_once 'class/ADMIN/document.php';
require_once 'class/ADMIN/File.php';

$documentObject	= new class_wn_document();
$fileObject		= new File();
$reference		= isset($_REQUEST['reference']) && trim($_REQUEST['reference']) != '' ? trim($_REQUEST['reference']) : '';

$documentData = $documentObject->getByReference($reference);

if($documentData) {
		
		$file					= 	isset($_GET['pdf']) && trim($_GET['pdf']) == 1 ?  str_replace('.html', '.pdf', $_SERVER['DOCUMENT_ROOT'].$documentData['document_filepath']) : $_SERVER['DOCUMENT_ROOT'].$documentData['document_filepath'];
		$filename			= 	isset($_GET['pdf']) && trim($_GET['pdf']) == 1 ?  str_replace('.html', '.pdf', $documentData['document_filename']) : $documentData['document_filename'];
		$validMimeType	= $fileObject->file_content_type($file);
					
		header("Content-Type: $validMimeType");
		header("Cache-Control: no-cache");
		header("Accept-Ranges: none");
		header("Content-Disposition: attachment; filename=\"".$filename."\"");			
		
		echo file_get_contents($file);
		exit;		

} else {
	echo 'Invalid reference';
	exit;
}


?>