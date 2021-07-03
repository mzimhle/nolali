<?php

require_once 'campaign.php';

//custom account item class as account table abstraction
class class_productprice extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected	$_name	= 'productprice';

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
        $data['productprice_added'] = date('Y-m-d H:i:s');
        $data['productprice_code']  = $this->createReference();

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
        $data['productprice_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	public function remove($code) {
		return $this->delete('productprice_code = ?', $code);		
	}
	
	/**
	 * get job by job productprice Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		$select = $this->_db->select()	
					->from(array('productprice' => 'productprice'))	
					->joinLeft(array('product' => 'product'), 'product.product_code = productprice.product_code')		
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = product.campaign_code')						
					->where('productprice_code = ?', $code)
					->where($this->_campaign->_campaignsql)
					->where('productprice_deleted = 0')
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}	
	
	public function getAll($where = NULL, $order = NULL)
	{
		
		$select = $this->_db->select()	
					->from(array('productprice' => 'productprice'))	
					->joinLeft(array('product' => 'product'), 'product.product_code = productprice.product_code')	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = product.campaign_code')											
					->where('productprice_deleted = 0')		
					->where($this->_campaign->_campaignsql)					
					->where($where)
					->order($order);						
						
		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
	}
	
	public function getByProduct($product)
	{
		$select = $this->_db->select()	
					->from(array('productprice' => 'productprice'))
					->joinLeft(array('product' => 'product'), 'product.product_code = productprice.product_code')
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = product.campaign_code')						
					->where('product.product_code = ?', $product)
					->where($this->_campaign->_campaignsql)
					->where('productprice_deleted = 0');					
						
		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
		
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($reference)
	{
		$select = $this->select() 
					   ->where('productprice_code = ?', $reference)
					   ->limit(1);

	   $result = $this->fetchRow($select);
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