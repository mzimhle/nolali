<?php

require_once 'pdfcrowd/pdfcrowd.php';

class CLASS_PDFCROWD {

	public $_user       = 'willow_nettica';
	public $_password	= 'a4db60b59d59d89960eeadf9c7c8f986';
	public $_PDF        = null;
	
	function __construct() {
        $this->_PDF = new PdfCrowd($this->_user, $this->_password);
	}
}
?>