<?php

require_once 'campaign.php';

//custom account item class as account table abstraction
class class_productitemdata extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected	$_name				= 'productitemdata';

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
        $data['productitemdata_added'] 	= date('Y-m-d H:i:s');
        $data['productitemdata_code']  	= $this->createCode();
		$data['campaign_code'] 				= $this->_campaign->_campaign;
		
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
        $data['productitemdata_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job productitemdata Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		$select = $this->_db->select()	
					->from(array('productitemdata' => 'productitemdata'))	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = productitemdata.campaign_code')	
					->joinLeft(array('productitem' => 'productitem'), 'productitem.productitem_code = productitemdata.productitem_code')						
					->where('productitemdata_deleted = 0 and productitem_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('productitemdata.productitemdata_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}	
	
	/**
	 * get job by job productitemdata Id
 	 * @param string job id
     * @return object
	 */
	public function getByItem($code)
	{
		$select = $this->_db->select()	
					->from(array('productitemdata' => 'productitemdata'))	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = productitemdata.campaign_code')	
					->joinLeft(array('productitem' => 'productitem'), 'productitem.productitem_code = productitemdata.productitem_code')						
					->where('productitemdata_deleted = 0 and productitem_deleted = 0')					
					->where($this->_campaign->_campaignsql)
					->where('productitemdata.productitem_code = ?', $code)
					->where('productitemdata_deleted = 0');

	   $result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function getAll()
	{		
		$select = $this->_db->select()	
					->from(array('productitemdata' => 'productitemdata'))	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = productitemdata.campaign_code')	
					->joinLeft(array('productitem' => 'productitem'), 'productitem.productitem_code = productitemdata.productitem_code')						
					->where('productitemdata_deleted = 0 and productitem_deleted = 0')					
					->where($this->_campaign->_campaignsql)
					->order('productitemdata_name');						

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
		$select = $this->select() 
					->from(array('productitemdata' => 'productitemdata'))
					   ->where('productitemdata_code = ?', $code)
					   ->limit(1);

	   $result = $this->fetchRow($select);
        return ($result == false) ? false : $result = $result;					   
		
	}
	
	function createCode() {
		/* New code. 	*/
		$code = "";

		$codeAlphabet = "123456789";
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<5;$i++) {
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