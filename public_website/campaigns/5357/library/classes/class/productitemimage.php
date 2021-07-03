<?php

require_once 'campaign.php';

//custom account item class as account table abstraction
class class_productitemimage extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected 	$_name 						= 'productitemimage';
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
        $data['productitemimage_added'] = date('Y-m-d H:i:s');


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
        $data['productitemimage_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job productitemimage Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		$select = $this->_db->select()	
					->from(array('productitemimage' => 'productitemimage'))	
					->joinLeft(array('productitem' => 'productitem'), 'productitem.productitem_code = productitemimage.productitem_code')	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = productitem.campaign_code')	
					->where($this->_campaign->_campaignsql)
					->where('productitemimage_deleted = 0')
					->where('productitemimage_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}	
	
	/**
	 * get job by job productitemimagetype Id
 	 * @param string job id
     * @return object
	 */
	public function getByProductItem($code)
	{
		$select = $this->_db->select()	
					->from(array('productitemimage' => 'productitemimage'))	
					->joinLeft(array('productitem' => 'productitem'), 'productitem.productitem_code = productitemimage.productitem_code')
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = productitem.campaign_code')		
					->where($this->_campaign->_campaignsql)
					->where('productitemimage_deleted = 0')
					->where('productitemimage.productitem_code = ?', $code);
       
	   $result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}	
	
	public function getPrimaryByProductItem($code) {
		
		$select = $this->_db->select()	
					->from(array('productitemimage' => 'productitemimage'))	
					->joinLeft(array('productitem' => 'productitem'), 'productitem.productitem_code = productitemimage.productitem_code')	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = productitem.campaign_code')	
					->where($this->_campaign->_campaignsql)
					->where('productitemimage_deleted = 0')
					->where('productitemimage_primary = 1')
					->where('productitem.productitem_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
       return ($result == false) ? false : $result = $result;	
	}
	
	public function updatePrimaryByProductItem($code, $productitemcode) {
		
		$item = $this->getPrimaryByProductItem($productitemcode);
		
		if($item) {
			$data = array();
			$where = null;
			$data['productitemimage_primary'] = 0;
			
			$where		= $this->getAdapter()->quoteInto('productitemimage_code = ?', $item['productitemimage_code']);
			$success	= $this->update($data, $where);				
		}

		$data = array();
		$data['productitemimage_primary'] = 1;
			
		$where		= $this->getAdapter()->quoteInto('productitemimage_code = ?', $code);
		$success	= $this->update($data, $where);
		
		return $success;
	}
	
	public function getAll()
	{
		$select = $this->_db->select()	
					->from(array('productitemimage' => 'productitemimage'))	
					->joinLeft(array('productitem' => 'productitem'), 'productitem.productitem_code = productitemimage.productitem_code')	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = productitem.campaign_code')	
					->where($this->_campaign->_campaignsql)
					->where('productitemimage_deleted = 0')				
					->order('productitemimage_added');						
						
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
						->from(array('productitemimage' => 'productitemimage'))	
					   ->where('productitemimage_code = ?', $code)
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