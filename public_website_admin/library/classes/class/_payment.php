<?php

require_once 'campaign.php';

//custom account item class as account table abstraction
class class_payment extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected	$_name	= '_payment';
	protected	$_primary	= '_payment_code';
	
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
        $data['_payment_added'] = date('Y-m-d H:i:s');
        $data['_payment_code']  = $this->createCode();

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
        $data['_payment_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job payment Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code, $type = '') {
	
		switch($type) {
			case 'BOOKING' :	
				$select = $this->_db->select()	
						->from(array('_payment' => '_payment'))	
						->joinLeft(array('booking' => 'booking'), "booking.booking_code = _payment._payment_type = 'BOOKING' and booking.booking_code_payment._payment_reference")
						->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = booking.campaign_code', array())						
						->where('_payment_deleted = 0 and booking_deleted = 0')
						->where($this->_campaign->_campaignsql)
						->where('_payment_code = ?', $code)
						->limit(1);
			break;
			default : 
				$select = $this->_db->select()	
						->from(array('_payment' => '_payment'))					
						->where('_payment_deleted = 0')
						->where('_payment_code = ?', $code)
						->limit(1);
		}
		
		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}	
	
	public function getByType($code, $type) {
	
		switch($type) {
			case 'BOOKING' :	
				$select = $this->_db->select()	
						->from(array('_payment' => '_payment'))	
						->joinLeft(array('booking' => 'booking'), "booking.booking_code = _payment._payment_type = 'BOOKING' and booking.booking_code = _payment._payment_reference")
						->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = booking.campaign_code', array())						
						->where('_payment_deleted = 0 and booking_deleted = 0')
						->where($this->_campaign->_campaignsql)
						->where('_payment_reference = ?', $code)
						->where('_payment_type = ?', $type);
			break;
			default : 
				$select = $this->_db->select()	
						->from(array('_payment' => '_payment'))					
						->where('_payment_deleted = 0')
						->where('_payment_code = ?', $code);
		}
		
		$result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	
	}
	
	public function getAll()
	{
		$select = $this->_db->select()	
				->from(array('_payment' => '_payment'))	
				->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_code = _payment.invoice_code')												
				->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code')
				->where('_payment_deleted = 0 and invoice_deleted = 0')
				->where($this->_campaign->_campaignsql);						
						
		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code)
	{
		$select = $this->_db->select()	
						->from(array('_payment' => '_payment'))	
					   ->where('_payment_code = ?', $code)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createCode() {
		/* New code. */
		$code = "";
		$codeAlphabet = "1234567890";
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