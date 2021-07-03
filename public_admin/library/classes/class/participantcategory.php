<?php

require_once 'campaign.php';

//custom account item class as account table abstraction
class class_participantcategory extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 		= 'participantcategory';
	protected $_primary	= 'participantcategory_code';
	
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
        $data['participantcategory_added']	= date('Y-m-d H:i:s');
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
        $data['participantcategory_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job participantcategory Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		$select = $this->_db->select()	
					->from(array('participantcategory' => 'participantcategory'))
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = participantcategory.campaign_code')
					->where('participantcategory_code = ?', $code)
					->where('participantcategory_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}	
	
	public function getAll()
	{
		$select = $this->_db->select()	
					->from(array('participantcategory' => 'participantcategory'))
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = participantcategory.campaign_code')
					->where($this->_campaign->_campaignsql)
					->where('participantcategory_deleted = 0');				
						
		$result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function pairs() {
		$select = $this->select()
					   ->from(array('participantcategory' => 'participantcategory'), array('participantcategory.participantcategory_code', 'participantcategory.participantcategory_name'))
					   ->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = participantcategory.campaign_code', array())
					   ->where('participantcategory.participantcategory_deleted = 0')
					   ->where($this->_campaign->_campaignsql)
					   ->order('participantcategory.participantcategory_added ASC');

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
					   ->where('participantcategory_code = ?', $code)
					   ->limit(1);

	   $result = $this->fetchRow($select);
        return ($result == false) ? false : $result = $result;					   
		
	}
}
?>