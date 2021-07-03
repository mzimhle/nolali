<?php

require_once 'campaign.php';
require_once 'PDF.php';

//custom account item class as account table abstraction
class class_invoice extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected	$_name		= 'invoice';
	protected	$_primary		= 'invoice_code';
	
	public $_campaign			= null;
	public $_PDFCROWD			= null;
	
	function init()	{
		
		global $zfsession;

		$this->_campaign			= new class_campaign();	
		$this->_PDFCROWD		= new CLASS_PDFCROWD();
		
	}

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data)
    {
        // add a timestamp
        $data['invoice_added'] 	= date('Y-m-d H:i:s');
        $data['invoice_code']  	= isset($data['invoice_code']) ? $data['invoice_code'] : $this->createCode();
		$data['campaign_code']	= $this->_campaign->_campaign;
		
		return parent::insert($data);
		
    }
	
	/**
	 * Update the database record
	 * example: $table->update($data, $where);
	 * @param query string $where
	 * @param array $data
     * @return boolean
	 */
    public function update(array $data, $where)
    {
        // add a timestamp
        $data['invoice_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job invoice Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
	
		$selectpayment = $this->_db->select()	
							->from(array('invoicepayment' => 'invoicepayment'), array('invoice_code', new Zend_Db_Expr("SUM(invoicepayment_amount) AS payment_total")))
							->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_code = invoicepayment.invoice_code', array())		
							->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code', array())								
							->where('invoice_deleted = 0 and campaign_deleted = 0 and invoicepayment_deleted = 0')
							->where($this->_campaign->_campaignsql)
							->group('invoicepayment.invoice_code');
		
		$selectitem = $this->_db->select()	
							->from(array('invoiceitem' => 'invoiceitem'), array(
											'invoice_code',
											new Zend_Db_Expr("(SUM(invoiceitem_amount) * invoiceitem_quantity) AS item_total_sub"),
											new Zend_Db_Expr("(SUM(invoiceitem_amount) * invoiceitem_quantity) * (campaign.campaign_vat) AS item_vat"),
											new Zend_Db_Expr("(SUM(invoiceitem_amount) * invoiceitem_quantity) + ((SUM(invoiceitem_amount) * invoiceitem_quantity) * (campaign.campaign_vat)) AS item_total")
										))
							->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_code = invoiceitem.invoice_code', array())		
							->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code', array())								
							->where('invoice_deleted = 0 and campaign_deleted = 0 and invoiceitem_deleted = 0')
							->where($this->_campaign->_campaignsql)
							->group('invoiceitem.invoice_code');
							
		$select = $this->_db->select()
							->from(array('invoice' => 'invoice'), array('participant_code','invoice_person_name','invoice_person_number','invoice_person_email','invoice_type','invoice_reference','invoice_make','invoice_pdf','invoice_notes', 'invoice_added',
							new Zend_Db_Expr("(invoiceitem.item_total - invoicepayment.payment_total) as payment_remainder")))
							->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code')
							->joinLeft(array('invoiceitem' => $selectitem), 'invoiceitem.invoice_code = invoice.invoice_code')
							->joinLeft(array('invoicepayment' => $selectpayment), 'invoicepayment.invoice_code = invoice.invoice_code')
							->where('invoice_deleted = 0 and campaign_deleted = 0')						
							->where($this->_campaign->_campaignsql)
							->where('invoice.invoice_code = ?', $code)						
							->group('invoiceitem.invoice_code');
							
		$result = $this->_db->fetchRow($select);	   
		return ($result == false) ? false : $result = $result;

	}	

	/**
	 * get job by job invoice Id
 	 * @param string job id
     * @return object
	 */
	public function getAll()
	{
		
		$selectpayment = $this->_db->select()	
							->from(array('invoicepayment' => 'invoicepayment'), array('invoice_code', new Zend_Db_Expr("SUM(invoicepayment_amount) AS payment_total")))
							->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_code = invoicepayment.invoice_code', array())		
							->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code', array())								
							->where('invoice_deleted = 0 and campaign_deleted = 0 and invoicepayment_deleted = 0')
							->where($this->_campaign->_campaignsql)
							->group('invoicepayment.invoice_code');
		
		$selectitem = $this->_db->select()	
							->from(array('invoiceitem' => 'invoiceitem'), array(
											'invoice_code',
											new Zend_Db_Expr("(SUM(invoiceitem_amount) * invoiceitem_quantity) AS item_total_sub"),
											new Zend_Db_Expr("(SUM(invoiceitem_amount) * invoiceitem_quantity) * (campaign.campaign_vat) AS item_vat"),
											new Zend_Db_Expr("(SUM(invoiceitem_amount) * invoiceitem_quantity) + ((SUM(invoiceitem_amount) * invoiceitem_quantity) * (campaign.campaign_vat)) AS item_total")
										))
							->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_code = invoiceitem.invoice_code', array())		
							->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code', array())								
							->where('invoice_deleted = 0 and campaign_deleted = 0 and invoiceitem_deleted = 0')
							->where($this->_campaign->_campaignsql)
							->group('invoiceitem.invoice_code');
							
		$select = $this->_db->select()
							->from(array('invoice' => 'invoice'), array('participant_code','invoice_person_name','invoice_person_number','invoice_person_email','invoice_type','invoice_reference','invoice_make','invoice_pdf','invoice_notes', 'invoice_added',
							new Zend_Db_Expr("(invoiceitem.item_total - invoicepayment.payment_total) as payment_remainder")))
							->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code')
							->joinLeft(array('invoiceitem' => $selectitem), 'invoiceitem.invoice_code = invoice.invoice_code')
							->joinLeft(array('invoicepayment' => $selectpayment), 'invoicepayment.invoice_code = invoice.invoice_code')
							->where('invoice_deleted = 0 and campaign_deleted = 0')						
							->where($this->_campaign->_campaignsql)				
							->group('invoiceitem.invoice_code');

		$result = $this->_db->fetchAll($select);	
		return ($result == false) ? false : $result = $result;

	}

	public function validateEmail($string) {
		if (!filter_var($string, FILTER_VALIDATE_EMAIL)) {
		  return '';
		} else {
		  return $string;
		}
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code)
	{
		$select = $this->_db->select()	
						->from(array('invoice' => 'invoice'))	
					   ->where('invoice_code = ?', $code)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;
	}
	
	function createCode() {
		/* New code. */
		$code = "";
		$codeAlphabet = "123456789";
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<7;$i++){
			$code .= $codeAlphabet[rand(0,$count)];
		}
		
		$alpha = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<3;$i++){
			$alpha .= $codeAlphabet[rand(0,$count)];
		}
		
		$code = $alpha.$code;
		
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($code);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createCode();
		} else {
			return $code;
		}
	}
	
}
?>