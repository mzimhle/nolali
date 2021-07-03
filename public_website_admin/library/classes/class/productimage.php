<?php

require_once 'campaign.php';

//custom account item class as account table abstraction
class class_productimage extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected 	$_name 						= 'productimage';
	public 			$productcode	= null;
	
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
        $data['productimage_added'] = date('Y-m-d H:i:s');
        $data['productimage_code']  = isset($data['productimage_code']) ? $data['productimage_code'] : $this->createCode();

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
        $data['productimage_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	public function remove($code) {
		return $this->delete('productimage_code = ?', $code);		
	}
	
	/**
	 * get job by job productimage Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		$select = $this->_db->select()	
					->from(array('productimage' => 'productimage'))	
					->joinLeft(array('product' => 'product'), 'product.product_code = productimage.product_code')	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = product.campaign_code')	
					->where($this->_campaign->_campaignsql)
					->where('productimage_deleted = 0')
					->where('productimage_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}	
	
	/**
	 * get job by job productimagetype Id
 	 * @param string job id
     * @return object
	 */
	public function getByProduct($code)
	{
		$select = $this->_db->select()	
					->from(array('productimage' => 'productimage'))	
					->joinLeft(array('product' => 'product'), 'product.product_code = productimage.product_code')
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = product.campaign_code')		
					->where($this->_campaign->_campaignsql)
					->where('productimage_deleted = 0')
					->where('productimage.product_code = ?', $code);
       
	   $result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}	
	
	public function getPrimaryByProduct($code) {
		
		$select = $this->_db->select()	
					->from(array('productimage' => 'productimage'))	
					->joinLeft(array('product' => 'product'), 'product.product_code = productimage.product_code')	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = product.campaign_code')	
					->where($this->_campaign->_campaignsql)
					->where('productimage_deleted = 0')
					->where('productimage_primary = 1')
					->where('product.product_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
       return ($result == false) ? false : $result = $result;	
	}
	
	public function updatePrimaryByProduct($code, $productcode) {
		
		$item = $this->getPrimaryByProduct($productcode);
		
		if($item) {
			$data = array();
			$where = null;
			$data['productimage_primary'] = 0;
			
			$where		= $this->getAdapter()->quoteInto('productimage_code = ?', $item['productimage_code']);
			$success	= $this->update($data, $where);				
		}

		$data = array();
		$data['productimage_primary'] = 1;
			
		$where		= $this->getAdapter()->quoteInto('productimage_code = ?', $code);
		$success	= $this->update($data, $where);
		
		return $success;
	}
	
	/**
	 * get job by job product Id
 	 * @param string job id
     * @return object
	 */
	public function getByProductCampaign($code)
	{
		
		$select = $this->_db->select()	
					->from(array('productimage' => 'productimage'))	
					->joinLeft(array('product' => 'product'), 'product.product_code = productimage.product_code')	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = product.campaign_code')
					->where($this->_campaign->_campaignsql)
					->where('productimage_deleted = 0')
					->where('productimage.product_code = ?', $code);
       
	   $result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}	
	
	public function getAll($where = NULL, $order = NULL)
	{
		$select = $this->_db->select()	
					->from(array('productimage' => 'productimage'))	
					->joinLeft(array('product' => 'product'), 'product.product_code = productimage.product_code')	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = product.campaign_code')	
					->where($this->_campaign->_campaignsql)
					->where('productimage_deleted = 0')				
					->where($where)
					->order($order);						
						
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
						->from(array('productimage' => 'productimage'))	
					   ->where('productimage_code = ?', $code)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;
	}
	
	function createCode() {
		/* New code. */
		$code = "";
		$codeAlphabet = "1234567890";
		
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<15;$i++){
			$code .= $codeAlphabet[rand(0,$count)];
		}
		
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