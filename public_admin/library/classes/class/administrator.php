<?php

require_once 'campaign.php';

//custom account item class as account table abstraction
class class_administrator extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 	= 'administrator';
	protected $_primary = 'administrator_code';
	
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
        $data['administrator_added']		= date('Y-m-d H:i:s');
		$data['administrator_code']		= $this->createCode();
		$data['campaign_code']				= $this->_campaign->_campaign;
		$data['administrator_password']	= $this->createPassword();
		
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
        $data['administrator_updated']	= date('Y-m-d H:i:s');		
		
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job administrator Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		$select = $this->_db->select()	
					->from(array('administrator' => 'administrator'))
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = administrator.campaign_code and campaign_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('administrator_code = ?', $code)
					->where('administrator_deleted = 0')
					->limit(1);
       
		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;

	}	
	
	/**
	 * get all administrators ordered by column name
	 * example: $collection->getAlladministrators('administrator_title');
	 * @param string $order
     * @return object
	 */
	public function checkLogin($username = '', $password= '')
	{
		$select = $this->select()
					   ->where('administrator_email = ?', $username)
					   ->where('administrator_active = 1')
					   ->where('administrator_deleted = 0')
					   ->where('campaign_code = "" or campaign_code is null')
					   ->where('administrator_password = ?', $password);
		
        $result = $this->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}
	
	public function getAll()
	{
		$select = $this->_db->select()	
					->from(array('administrator' => 'administrator'))
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = administrator.campaign_code and campaign_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('administrator_deleted = 0')					
					->order('administrator_name desc');						

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;

	}
	
	/**
	 * get job by job participant Id
 	 * @param string job id
     * @return object
	 */
	public function getByCell($cell, $code = null) {
	
		if($code == null) {
		$select = $this->_db->select()	
					->from(array('administrator' => 'administrator'))
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = administrator.campaign_code and campaign_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('administrator_cellphone = ?', $cell)
					->where('administrator_deleted = 0')
					->limit(1);
       } else {
		$select = $this->_db->select()	
					->from(array('administrator' => 'administrator'))
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = administrator.campaign_code and campaign_deleted = 0')
					->where($this->_campaign->_campaignsql)			
					->where('administrator_cellphone = ?', $cell)
					->where('administrator_code != ?', $code)
					->where('administrator_deleted = 0')
					->limit(1);		
	   }
	   
		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * get job by job administrator Id
 	 * @param string job id
     * @return object
	 */
	public function getByEmail($email, $code = null) {
	
		if($code == null) {
		$select = $this->_db->select()	
					->from(array('administrator' => 'administrator'))
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = administrator.campaign_code and campaign_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('administrator_email = ?', $email)
					->where('administrator_deleted = 0')
					->limit(1);
       } else {
		$select = $this->_db->select()	
					->from(array('administrator' => 'administrator'))
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = administrator.campaign_code and campaign_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('administrator_email = ?', $email)
					->where('administrator_code != ?', $code)
					->where('administrator_deleted = 0')
					->limit(1);		
	   }

	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	
	public function validateEmail($string) {
		if(preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', trim($string))) {
			return trim($string);
		} else {
			return '';
		}
	}
	
	public function validateCell($string) {
		if(preg_match('/^0[0-9]{9}$/', $this->onlyCellNumber(trim($string)))) {
			return $this->onlyCellNumber(trim($string));
		} else {
			return '';
		}
	}
	
	public function onlyCellNumber($string) {

		/* Remove some weird charactors that windows dont like. */
		$string = strtolower($string);
		$string = str_replace(' ' , '' , $string);
		$string = str_replace('__' , '' , $string);
		$string = str_replace(' ' , '' , $string);
		$string = str_replace("é", "", $string);
		$string = str_replace("è", "", $string);
		$string = str_replace("`", "", $string);
		$string = str_replace("/", "", $string);
		$string = str_replace("\\", "", $string);
		$string = str_replace("'", "", $string);
		$string = str_replace("(", "", $string);
		$string = str_replace(")", "", $string);
		$string = str_replace("-", "", $string);
		$string = str_replace(".", "", $string);
		$string = str_replace("ë", "", $string);	
		$string = str_replace('___' , '' , $string);
		$string = str_replace('__' , '' , $string);	
		$string = str_replace(' ' , '' , $string);
		$string = str_replace('__' , '' , $string);
		$string = str_replace(' ' , '' , $string);
		$string = str_replace("é", "", $string);
		$string = str_replace("è", "", $string);
		$string = str_replace("`", "", $string);
		$string = str_replace("/", "", $string);
		$string = str_replace("\\", "", $string);
		$string = str_replace("'", "", $string);
		$string = str_replace("(", "", $string);
		$string = str_replace(")", "", $string);
		$string = str_replace("-", "", $string);
		$string = str_replace(".", "", $string);
		$string = str_replace("ë", "", $string);	
		$string = str_replace("â€“", "", $string);	
		$string = str_replace("â", "", $string);	
		$string = str_replace("€", "", $string);	
		$string = str_replace("“", "", $string);	
		$string = str_replace("#", "", $string);	
		$string = str_replace("$", "", $string);	
		$string = str_replace("@", "", $string);	
		$string = str_replace("!", "", $string);	
		$string = str_replace("&", "", $string);	
		$string = str_replace(';' , '' , $string);		
		$string = str_replace(':' , '' , $string);		
		$string = str_replace('[' , '' , $string);		
		$string = str_replace(']' , '' , $string);		
		$string = str_replace('|' , '' , $string);		
		$string = str_replace('\\' , '' , $string);		
		$string = str_replace('%' , '' , $string);	
		$string = str_replace(';' , '' , $string);		
		$string = str_replace(' ' , '' , $string);
		$string = str_replace('__' , '' , $string);
		$string = str_replace(' ' , '' , $string);	
		$string = str_replace('-' , '' , $string);	
		$string = str_replace('+27' , '0' , $string);	
		$string = str_replace('(0)' , '' , $string);	
		
		$string = preg_replace('/^00/', '0', $string);
		$string = preg_replace('/^27/', '0', $string);
		
		$string = preg_replace('!\s+!',"", strip_tags($string));
		
		return $string;
				
	}
	
	/**
	 * get domain by domain Administrator Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code)
	{
		$select = $this->_db->select()	
						->from(array('administrator' => 'administrator'))	
					   ->where('administrator_code = ?', $code)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;
	}
	
	function createCode() {
		/* New code. 
		$code = "";
		//$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet = "123456789";
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<8;$i++){
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

	function createPassword() {
		/* New code. */
		$password = "";
		$codeAlphabet = "abcdefghigklmnopqrstuvwxyz";
		$codeAlphabet .= "0123456789";
		
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<6;$i++){
			$password .= $codeAlphabet[rand(0,$count)];
		}
		
		return $password;

	}	
}
?>