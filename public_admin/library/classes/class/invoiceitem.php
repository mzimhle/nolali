<?php

require_once 'campaign.php';

//custom account item class as account table abstraction
class class_invoiceitem extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected	$_name			= 'invoiceitem';
	protected	$_primary			= 'invoiceitem_code';
	
	public $_campaign			= null;
	
	function init()	{
		
		global $zfsession;

		$this->_campaign			= new class_campaign();	
		
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
        $data['invoiceitem_added'] = date('Y-m-d H:i:s');
        $data['invoiceitem_code']  = $this->createCode();

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
        $data['invoiceitem_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }

	/**
	 * get job by job invoiceitem Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {
		$select = $this->_db->select()	
					->from(array('invoiceitem' => 'invoiceitem'))	
					->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_code = invoiceitem.invoice_code')
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code')
					->where($this->_campaign->_campaignsql)
					->where('invoiceitem_deleted = 0 and invoice_deleted = 0')		
					->where('invoiceitem_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function getByInvoice($code) {
		
		$select = $this->_db->select()	
					->from(array('invoiceitem' => 'invoiceitem'))	
					->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_code = invoiceitem.invoice_code')
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code')
					->where($this->_campaign->_campaignsql)
					->where('invoiceitem_deleted = 0 and invoice_deleted = 0')					
					->where('invoiceitem.invoice_code = ?', $code);						
						
		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;			
	}
	
	public function getAll()
	{	
		$select = $this->_db->select()	
					->from(array('invoiceitem' => 'invoiceitem'))	
					->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_code = invoiceitem.invoice_code')
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code')
					->where($this->_campaign->_campaignsql)
					->where('invoiceitem_deleted = 0 and invoice_deleted = 0');						
						
		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;		
	}
	
	public function hourDiff($start, $end) {
	
		$end = strtotime($end);
		$start = strtotime($start);
		$datediff = $end - $start;
		return floor($datediff/(60*60*24*60));
	
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code)
	{
		$select = $this->_db->select()	
						->from(array('invoiceitem' => 'invoiceitem'))
					   ->where('invoiceitem_code = ?', $code)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createCode() {
		/* New code. */
		$code = "";
		$codeAlphabet = "123456789";
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<5;$i++){
			$code .= $codeAlphabet[rand(0,$count)];
		}
		
		$code = $code.time();
		
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