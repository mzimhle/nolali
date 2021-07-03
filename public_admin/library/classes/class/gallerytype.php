<?php

require_once 'campaign.php';

//custom account item class as account table abstraction
class class_gallerytype extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 		= 'gallerytype';
	protected $_primary	= 'gallerytype_code';
	
	public $_campaign			= null;
	
	function init() {
		
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
        $data['gallerytype_added']	= date('Y-m-d H:i:s');
		$data['gallerytype_code']	= $this->createCode();
		$data['campaign_code']		= $this->_campaign->_campaign;
		
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
        $data['gallerytype_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job gallerytype Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		$select = $this->_db->select()	
					->from(array('gallerytype' => 'gallerytype'))
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = gallerytype.campaign_code')
					->where('gallerytype_code = ?', $code)
					->where('gallerytype_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}	
	
	public function getAll()
	{
		$select = $this->_db->select()	
					->from(array('gallerytype' => 'gallerytype'))
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = gallerytype.campaign_code')
					->where($this->_campaign->_campaignsql)
					->where('gallerytype_deleted = 0');				
						
		$result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function pairs() {
		$select = $this->select()
					   ->from(array('gallerytype' => 'gallerytype'), array('gallerytype.gallerytype_code', 'gallerytype.gallerytype_name'))
					   ->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = gallerytype.campaign_code', array())
					   ->where('gallerytype.gallerytype_deleted = 0')
					   ->where($this->_campaign->_campaignsql)
					   ->order('gallerytype.gallerytype_added ASC');

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
					   ->where('gallerytype_code = ?', $code)
					   ->limit(1);

	   $result = $this->fetchRow($select);
        return ($result == false) ? false : $result = $result;					   
		
	}
	
	function createCode() {
		/* New code. */
		$code = "";
		$codeAlphabet = "0123456789";

		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<5;$i++){
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