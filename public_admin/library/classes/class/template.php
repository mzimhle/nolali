<?php

require_once 'campaign.php';

//custom account item class as account table abstraction
class class_template extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected 	$_name 		= 'template';
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
        $data['template_added'] = date('Y-m-d H:i:s');
        $data['template_code']  	= isset($data['template_code']) ? $data['template_code'] : $this->createCode();
		$data['campaign_code']	= $this->_campaign->_campaign;
		
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
        $data['template_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job template Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		$select = $this->_db->select()	
					->from(array('template' => 'template'))
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = template.campaign_code')	
					->where($this->_campaign->_campaignsql)
					->where('template_deleted = 0')
					->where('template_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}
	
	/**
	 * get job by job template Id
 	 * @param string job id
     * @return object
	 */
	public function getAll()
	{
		$select = $this->_db->select()	
					->from(array('template' => 'template'))	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = template.campaign_code')
					->where($this->_campaign->_campaignsql)
					->where('template_deleted = 0');
       
		$result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}	
	
	public function pairs()
	{
		$select = $this->_db->select()
					->from(array('template' => 'template'), array('template.template_code', 'template.template_name'))
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = template.campaign_code', array())	
					->where($this->_campaign->_campaignsql)
					->where('template_deleted = 0')
					->order('template_name');
						
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
						->from(array('template' => 'template'))	
					   ->where('template_code = ?', $code)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;
	}
	
	function createCode() {
		/* New code. 
		$code = "";
		$codeAlphabet = "1234567890";

		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<10;$i++){
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