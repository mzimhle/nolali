<?php

require_once 'campaign.php';
require_once 'productimage.php';
require_once 'productitem.php';
require_once '_price.php';

//custom account item class as account table abstraction
class class_product extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 			= 'product';
	
	public $_campaign		= null;
	public $_productimage	= null;
	public $_productitem		= null;
	public $_price	= null;
	
	function init()	{
		
		global $zfsession;
		
		$this->_campaign		= new class_campaign();	
		$this->_productimage	= new class_productimage();	
		$this->_productitem		= new class_productitem();
		$this->_price	= new class_price();
		
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
        $data['product_added'] 	= date('Y-m-d H:i:s');
        $data['product_code']  	= $this->createReference();
		$data['campaign_code'] 	= $this->_campaign->_campaign;

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
        $data['product_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job product Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{		
		$select = $this->_db->select()	
					->from(array('product' => 'product'))	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = product.campaign_code')			
					->joinLeft(array('productimage' => 'productimage'), 'productimage.product_code = product.product_code and productimage_primary = 1 and productimage_deleted = 0', array('productimage_filename', 'productimage_primary', 'productimage_extension', 'productimage_path', 'productimage_code'))
					->where('product_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('product.product_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
	   
		if($result) {
			$result['productimages']	= $this->_productimage->getByProduct($result['product_code']);
			$result['productitems']	= $this->_productitem->getByProduct($result['product_code']);
			$result['_prices']			= $this->_price->getByProduct($result['product_code'], 'PRODUCTITEM');
		}
		
        return ($result == false) ? false : $result = $result;

	}
	
	public function getByCampaign($code)
	{		
		$select = $this->_db->select()	
					->from(array('product' => 'product'))	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = product.campaign_code')	
					->where('product_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('product.campaign_code = ?', $code)
					->order('product_added');	

	   $result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function getAll($where = 'product_deleted = 0', $order = 'product_name desc')
	{		
		$select = $this->_db->select()	
					->from(array('product' => 'product'))	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = product.campaign_code')
					->joinLeft(array('productimage' => 'productimage'), 'productimage.product_code = product.product_code and productimage_primary = 1 and productimage_deleted = 0', array('productimage_filename', 'productimage_primary', 'productimage_extension', 'productimage_path', 'productimage_code'))
					->where('product_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where($where)
					->order($order);	

		$result = $this->_db->fetchAll($select);
		
		if($result) {			
			for($i = 0; $i < count($result); $i++) {
				$result[$i]['productimages']	= $this->_productimage->getByProduct($result[$i]['product_code']);
				$result[$i]['productitems']	= $this->_productitem->getByProduct($result[$i]['product_code']);
				$result[$i]['_prices']	= $this->_price->getByProduct($result[$i]['product_code'], 'PRODUCTITEM');
			}
		}
		
		return ($result == false) ? false : $result = $result;
	}
	
	public function pairs() {
		
		$select = $this->select()
					   ->from(array('product' => 'product'), array('product.product_code', 'product.product_name'))
					   ->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = product.campaign_code', array())						   
					   ->where('product_deleted = 0 and product_active = 1')
					   ->where($this->_campaign->_campaignsql)
					   ->order('product.product_added ASC');

		$result = $this->_db->fetchPairs($select);
		return ($result == false) ? false : $result = $result;
	}	
	

	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($reference)
	{
		$select = $this->_db->select()	
						->from(array('product' => 'product'))	
					   ->where('product_code = ?', $reference)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;
	}
	
	function createReference() {
		/* New reference. */
		$reference = "";
		$codeAlphabet = "123456789";

		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<10;$i++){
			$reference .= $codeAlphabet[rand(0,$count)];
		}
		
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($reference);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createReference();
		} else {
			return $reference;
		}
	}		
}
?>