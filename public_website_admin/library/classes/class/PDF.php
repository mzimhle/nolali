<?php

require_once 'pdfcrowd/pdfcrowd.php';

class CLASS_PDFCROWD {

	public $_user			= 'willow_nettica';
	public $_password	= '6be184b78c92a8da33964db13d079b6e';
	public $_PDF			= null;
	
	function __construct() {

		$this->_PDF = new Pdfcrowd($this->_user, $this->_password);
		
	}
}

?>