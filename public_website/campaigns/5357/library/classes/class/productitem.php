<?php

require_once 'campaign.php';
require_once 'productitemimage.php';
require_once '_price.php';
require_once 'productitemdata.php';

//custom account item class as account table abstraction
class class_productitem extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected	$_name				= 'productitem';

	public $_campaign			= null;
	public $_productitemimage	= null;
	public $_price				= null;
	public $_productitemdata	= null;
	
	function init()	{
		
		global $zfsession;
		
		$this->_campaign			= new class_campaign();	
		$this->_productitemimage	= new class_productitemimage();
		$this->_price				= new class_price();
		$this->_productitemdata		= new class_productitemdata();
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
        $data['productitem_added'] 	= date('Y-m-d H:i:s');
        $data['productitem_code']  	= $this->createCode();
		$data['campaign_code'] 			= $this->_campaign->_campaign;
		
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
        $data['productitem_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job productitem Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		$select = $this->_db->select()	
					->from(array('productitem' => 'productitem'))	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = productitem.campaign_code')	
					->joinLeft(array('product' => 'product'), 'product.product_code = productitem.product_code')
					->joinLeft(array('productitemimage' => 'productitemimage'), 'productitemimage.productitem_code = productitem.productitem_code and productitemimage_primary = 1 and productitemimage_deleted = 0', array('productitemimage_filename', 'productitemimage_primary', 'productitemimage_extension', 'productitemimage_path', 'productitemimage_code'))					
					->where('productitem_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('productitem.productitem_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}	
	
	/**
	 * get job by job productitem Id
 	 * @param string job id
     * @return object
	 */
	public function getByProduct($code)
	{
		$select = $this->_db->select()	
					->from(array('productitem' => 'productitem'))				
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = productitem.campaign_code')						
					->joinLeft(array('product' => 'product'), 'product.product_code = productitem.product_code')
					->joinLeft(array('productitemimage' => 'productitemimage'), 'productitemimage.productitem_code = productitem.productitem_code and productitemimage_primary = 1 and productitemimage_deleted = 0', array('productitemimage_filename', 'productitemimage_primary', 'productitemimage_extension', 'productitemimage_path', 'productitemimage_code'))							
					->where('productitem.product_code = ?', $code)
					->where($this->_campaign->_campaignsql)
					->where('productitem_deleted = 0');

	   $result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function getPrimaryByProduct($code) {
		
		$select = $this->_db->select()	
					->from(array('productitem' => 'productitem'))				
					->joinLeft(array('productitemimage' => 'productitemimage'), 'productitem.productitem_code = productitemimage.productitem_code and productitemimage_primary = 1')
					->joinLeft(array('product' => 'product'), 'product.product_code = productitem.product_code')			
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = productitem.campaign_code')	
					->where('productitem.product_code = ?', $code)
					->where($this->_campaign->_campaignsql)
					->where('productitem_deleted = 0');

	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;		
	}
	
	public function getAll()
	{		
		$select = $this->_db->select()	
						->from(array('productitem' => 'productitem'))	
						->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = productitem.campaign_code')	
						->joinLeft(array('product' => 'product'), 'product.product_code = productitem.product_code')					->joinLeft(array('productitemimage' => 'productitemimage'), 'productitemimage.productitem_code = productitem.productitem_code and productitemimage_primary = 1 and productitemimage_deleted = 0', array('productitemimage_filename', 'productitemimage_primary', 'productitemimage_extension', 'productitemimage_path', 'productitemimage_code'))											
						->where('productitem_deleted = 0')
						->where($this->_campaign->_campaignsql)
						->order('productitem_name');						

		$result = $this->_db->fetchAll($select);
		
		if($result) {
			for($i = 0; $i < count($result); $i++) {
				$result[$i]['productitemimage'] = $this->_productitemimage->getByProductItem($result[$i]['productitem_code']);
				$result[$i]['price'] = $this->_price->getByActive('PRODUCTITEM', $result[$i]['productitem_code']);
				$result[$i]['feature'] = $this->_productitemdata->getByItemType($result[$i]['productitem_code'], 'FEATURES');
			}
		}

		return ($result == false) ? false : $result = $result;		
	}
	
	 public function pairs() {
		
		$select = $this->select()
					   ->from(array('productitem' => 'productitem'), array('productitem.productitem_code', 'productitem.productitem_name'))
					   ->joinLeft(array('product' => 'product'), 'product.product_code = productitem.product_code')	
					   ->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = productitem.campaign_code')	
					   -where('productitem_active = 1 and productitem_deleted = 0')
					   ->where($this->_campaign->_campaignsql)
					   ->order('productitem.productitem_added ASC');

		$result = $this->_db->fetchPairs($select);
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
					->from(array('productitem' => 'productitem'))
					   ->where('productitem_code = ?', $code)
					   ->limit(1);

	   $result = $this->fetchRow($select);
        return ($result == false) ? false : $result = $result;					   
		
	}
	
	function createCode() {
		/* New code. 
		$code = "";

		$codeAlphabet = "123456789";
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<10;$i++) {
			$code .= $codeAlphabet[rand(0,$count)];
		}
		*/
		
		$code = time();
		
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