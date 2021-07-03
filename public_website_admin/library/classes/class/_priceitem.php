<?php

require_once 'campaign.php';

//custom account item class as account table abstraction
class class_priceitem extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name		= '_priceitem';
	protected $_primary	= '_priceitem_code';
	public $_campaign			= null;
	
	function init()	{
		
		global $zfsession;

		$this->_campaign	= new class_campaign();			
	}	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	public function insert(array $data) {
        // add a timestamp
        $data['_priceitem_added']		= date('Y-m-d H:i:s');
        $data['_priceitem_code']		= $this->createCode();
		print_r($data); exit;
		return parent::insert($data);	
    }
	
	/**
	 * Update the database record
	 * example: $table->update($data, $where);
	 * @param query string $where
	 * @param array $data
     * @return boolean
	 */
    public function update(array $data, $where) {
        // add a timestamp
         $data['_priceitem_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByReference($reference, $type, $price = '') {
		
		if($price == '') {
			switch($type) {
				case 'BOOKING' :
				$select = $this->_db->select()	
								->from(array('_priceitem' => '_priceitem'))
								->joinLeft(array('booking' => 'booking'), 'booking.booking_code = _priceitem._priceitem_reference')
								->joinLeft(array('_price' => '_price'), '_price._price_code = _priceitem._price_code')							
								->joinLeft(array('productitem' => 'productitem'), 'productitem.productitem_code = _price._price_reference', array('productitem_name', 'productitem_description', 'productitem_page'))
								->joinLeft(array('product' => 'product'), 'product.product_code = productitem.product_code', array('product_name', 'product_description', 'product_page'))
								->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = booking.campaign_code')
								->where('_priceitem_deleted = 0 and _priceitem._priceitem_deleted = 0 and booking_deleted = 0 and productitem_deleted = 0')
								->where($this->_campaign->_campaignsql)
								->where('_priceitem._priceitem_type = ?', $type)
								->where('_priceitem._priceitem_reference = ?', $reference);
				}
			
			$result = $this->_db->fetchAll($select);	   
			return ($result == false) ? false : $result = $result;
			
		} else {
			switch($type) {
				case 'BOOKING' :		
					$select = $this->_db->select()	
							->from(array('_priceitem' => '_priceitem'))
							->joinLeft(array('booking' => 'booking'), 'booking.booking_code = _priceitem._priceitem_reference')
							->joinLeft(array('_price' => '_price'), '_price._price_code = _priceitem._price_code')							
							->joinLeft(array('productitem' => 'productitem'), 'productitem.productitem_code = _price._price_reference')
							->joinLeft(array('product' => 'product'), 'product.product_code = productitem.product_code', array('product_name', 'product_description', 'product_page'))
							->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = booking.campaign_code')
							->where('_priceitem_deleted = 0 and _priceitem._priceitem_deleted = 0 and booking_deleted = 0 and productitem_deleted = 0')
							->where($this->_campaign->_campaignsql)
							->where('_priceitem._priceitem_type = ?', $type)
							->where('_priceitem._priceitem_reference = ?', $reference)
							->where('_price._price_code = ?', $price);
			}
			
			$result = $this->_db->fetchRow($select);	   
			return ($result == false) ? false : $result = $result;		
		}
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByCode($code) {
		$select = $this->_db->select()	
						->from(array('_priceitem' => '_priceitem'))
						->joinLeft(array('_price' => '_price'), '_price._price_code = _priceitem._price_code')
						->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = _priceitem.campaign_code')
						->where('_priceitem_deleted = 0 and _priceitem._priceitem_deleted = 0')
						->where($this->_campaign->_campaignsql)
						->where('_priceitem._priceitem_code = ?', $code)
						->limit(1);

	   $result = $this->_db->fetchRow($select);	
       return ($result == false) ? false : $result = $result;					   
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code) {
		$select = $this->_db->select()	
						->from(array('_priceitem' => '_priceitem'))	
					   ->where('_priceitem_code = ?', $code)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
       return ($result == false) ? false : $result = $result;					   
	}
	
	function createCode() {
		/* New code. */
		$code = "";
		$codeAlphabet = '1234567890';
		
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