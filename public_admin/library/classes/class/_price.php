<?php

require_once 'campaign.php';

//custom account item class as account table abstraction
class class_price extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name		= '_price';
	protected $_primary	= '_price_code';
	
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

	public function insert(array $data) {
        // add a timestamp
        $data['_price_added']		= date('Y-m-d H:i:s');
		$data['_price_startdate']	= date('Y-m-d H:i:s');
        $data['_price_code']		= $this->createCode();
		
		if((isset($data['_price_reference']) && trim($data['_price_reference']) != '') && 
				(isset($data['_price_product']) && trim($data['_price_product']) != '') &&
					(isset($data['_price_type']) && trim($data['_price_type']) != '')) {
			
			$priceData = $this->getByProductPrice($data['_price_product'], $data['_price_type'], $data['_price_reference']);

			if($priceData) {
				
				/* Increase id to the latest one. */
				$data['_price_id'] = $priceData['_price_id']+1;
				
				/* Update previous item. */
				$udata = array();
				$udata['_price_enddate']	= date('Y-m-d H:i:s');
				$udata['_price_active'] 		= 0;
				
				$where	= $this->getAdapter()->quoteInto('_price_code = ?', $priceData['_price_code']);
				$this->update($udata, $where);	
			
			}
		} else {
			return false;
		}
		
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
         $data['_price_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByProductPrice($product, $type, $code) {
	
		$select = $this->_db->select()	
							->from(array('_price' => '_price'), array('_price_code', '_price_id', '_price_type', '_price_product', '_price_reference', '_price_cost', '_price_startdate', '_price_enddate', new Zend_Db_Expr("MAX(_price_id) AS _price_id")))
							->where('_price_deleted = 0')
							->where('_price._price_product = ?', $product)
							->where('_price._price_type = ?', $type)
							->where('_price._price_reference = ?', $code)
							->group('_price._price_reference')
							->limit(1);
							
		$result = $this->_db->fetchRow($select);	   
		return ($result == false) ? false : $result = $result;
		
	}
	
	public function pairs($product, $type) {
		
		switch($product) {
			case 'PRODUCTITEM' :
				$select = $this->select()
						   ->from(array('_price' => '_price'), array('_price._price_code', "concat(_price_type, ' - ',productitem.productitem_name, ' ( R ',_price._price_cost,')') as _price_name"))
						   ->joinLeft(array('productitem' => 'productitem'), 'productitem.productitem_code = _price._price_reference', array())
						   ->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = productitem.campaign_code', array())
						   ->where('productitem_deleted = 0 and _price_deleted = 0')
						   ->where('productitem_active = 1 and _price_active = 1')
						   ->where('_price._price_type = ?', $type)
						   ->where($this->_campaign->_campaignsql)
						   ->order('productitem.productitem_name ASC');		
		}

		$result = $this->_db->fetchPairs($select);
		return ($result == false) ? false : $result = $result;
	}	
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByProduct($product, $code, $type = '') {
		
		if($type == '') {
			$select = $this->_db->select()	
						->from(array('_price' => '_price'))
						->where('_price_deleted = 0')
						->where('_price._price_product = ?', $product)
						->where('_price._price_reference = ?', $code)
						->order('_price_active');
		} else {
			$select = $this->_db->select()	
						->from(array('_price' => '_price'))
						->where('_price_deleted = 0')
						->where('_price._price_product = ?', $product)
						->where('_price._price_type = ?', $type)
						->where('_price._price_reference = ?', $code)
						->order('_price_active');
		}

		$result = $this->_db->fetchAll($select);	   
		return ($result == false) ? false : $result = $result;
		
	}	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByCode($code) {
		$select = $this->_db->select()	
						->from(array('_price' => '_price'))
						->where('_price_deleted = 0')
					   ->where('_price._price_code = ?', $code)
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
						->from(array('_price' => '_price'))	
					   ->where('_price_code = ?', $code)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
       return ($result == false) ? false : $result = $result;					   
	}
	
	function createCode() {
		/* New reference. 
		$reference = "";
		$codeAlphabet = '123456789';
		
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<5;$i++){
			$reference .= $codeAlphabet[rand(0,$count)];
		}
		*/
		
		$reference = time();
		
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($reference);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createCode();
		} else {
			return $reference;
		}
	}

}
?>