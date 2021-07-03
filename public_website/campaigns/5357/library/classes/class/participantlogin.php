<?php

require_once 'campaign.php';

//custom account item class as account table abstraction
class class_participantlogin extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name		= 'participantlogin';
	protected $_primary	= 'participantlogin_code';
	
	public $_campaign			= null;
	
	function init()	{
	
		global $zfsession;

		$this->_campaign				= new class_campaign();		
	}
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	public function insert(array $data) {
        // add a timestamp
        $data['participantlogin_added']	= date('Y-m-d H:i:s');
        $data['participantlogin_code']		= isset($data['participantlogin_code']) && trim($data['participantlogin_code']) != '' ? $data['participantlogin_code'] : $this->createCode();
		$data['campaign_code']				= $this->_campaign->_campaign;
		
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
         $data['participantlogin_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	
	public function insertLogin($data, $type, $participantcode) {
        // add a timestamp
		$indata												= array();
        $indata['participantlogin_added']			= date('Y-m-d H:i:s');
        $indata['participantlogin_code']			= $this->createCode();
		$indata['participantlogin_hashcode'] 	= md5(date('Y-m-d H:i:s'));
		$indata['participantlogin_password'] 	= $this->createPassword();
		$indata['participant_code']					= $participantcode;
		$indata['campaign_code']					= $this->_campaign->_campaign;
		
		switch($type) {
			case 'FACEBOOK' :
				$indata['participantlogin_id']				= isset($data['id']) && trim($data['id']) != '' ? trim($data['id']) : null;
				$indata['participantlogin_name'] 			= isset($data['first_name']) && trim($data['first_name']) != '' ? trim($data['first_name']) : null;
				$indata['participantlogin_surname'] 	= isset($data['last_name']) && trim($data['last_name']) != '' ? trim($data['last_name']) : null;
				$indata['participantlogin_url']				= isset($data['link']) && trim($data['link']) != '' ? trim($data['link']) : null;
				$indata['participantlogin_username']	= isset($data['email']) && trim($data['email']) != '' ? trim($data['email']) : null;
				$indata['participantlogin_location']		= isset($data['location']['name']) && trim($data['location']['name']) != '' ? trim($data['location']['name']) : null;
				$indata['participantlogin_active']	 		= 1;
				$indata['participantlogin_type']	 		= $type;
				break;
			case 'EMAIL' :				
				$indata['participantlogin_id']				= null;
				$indata['participantlogin_name'] 			= isset($data['participant_name']) && trim($data['participant_name']) != '' ? trim($data['participant_name']) : null;
				$indata['participantlogin_surname'] 	= isset($data['participant_surname']) && trim($data['participant_surname']) != '' ? trim($data['participant_surname']) : null;
				$indata['participantlogin_username']	= isset($data['participant_email']) && trim($data['participant_email']) != '' ? trim($data['participant_email']) : null;
				$indata['participantlogin_location']		= isset($data['areapost_name']) && trim($data['areapost_name']) != '' ? trim($data['areapost_name']) : null;
				$indata['participantlogin_active']	 		= isset($data['participant_active']) && trim($data['participant_active']) != '' ? trim($data['participant_active']) : 0;
				$indata['participantlogin_image']	 		= isset($data['participant_image_name']) && trim($data['participant_image_name']) != '' ? $data['participant_image_path'].'/big_'.$data['participant_image_name'].$data['participant_image_extension'] : '';				
				$indata['participantlogin_type']	 		= $type;
				break;	
			case 'LINKEDIN' :
				$indata['participantlogin_id']				= isset($data['participantlogin_id']) && trim($data['participantlogin_id']) != '' ? trim($data['participantlogin_id']) : null;
				$indata['participantlogin_name'] 			= isset($data['participantlogin_name']) && trim($data['participantlogin_name']) != '' ? trim($data['participantlogin_name']) : null;
				$indata['participantlogin_surname'] 	= isset($data['participantlogin_surname']) && trim($data['participantlogin_surname']) != '' ? trim($data['participantlogin_surname']) : null;
				$indata['participantlogin_username']	= isset($data['participantlogin_username']) && trim($data['participantlogin_username']) != '' ? trim($data['participantlogin_username']) : null;
				$indata['participantlogin_active']	 		= 1;
				$indata['participantlogin_image']			= isset($data['participantlogin_image']) && trim($data['participantlogin_image']) != '' ? trim($data['participantlogin_image']) : null;
				$indata['participantlogin_type']	 		= $type;
				break;	
			case 'GOOGLE' :
				$indata['participantlogin_id']				= isset($data['participantlogin_id']) && trim($data['participantlogin_id']) != '' ? trim($data['participantlogin_id']) : null;
				$indata['participantlogin_name'] 			= isset($data['participantlogin_name']) && trim($data['participantlogin_name']) != '' ? trim($data['participantlogin_name']) : null;
				$indata['participantlogin_surname'] 	= isset($data['participantlogin_surname']) && trim($data['participantlogin_surname']) != '' ? trim($data['participantlogin_surname']) : null;
				$indata['participantlogin_url']				= isset($data['participantlogin_url']) && trim($data['participantlogin_url']) != '' ? trim($data['participantlogin_url']) : null;
				$indata['participantlogin_username']	= isset($data['participantlogin_username']) && trim($data['participantlogin_username']) != '' ? trim($data['participantlogin_username']) : null;
				$indata['participantlogin_location']		= isset($data['participantlogin_location']) && trim($data['participantlogin_location']) != '' ? trim($data['participantlogin_location']) : null;
				$indata['participantlogin_active']	 		= 1;
				$indata['participantlogin_type']	 		= $type;
				break;				
		}

		$participantlogincode =  parent::insert($indata);	

		
		return $participantlogincode;
    }
	
	/**
	 * Update the database record
	 * example: $table->update($data, $where);
	 * @param query string $where
	 * @param array $data
     * @return boolean
	 */
    public function updateLogin($data, $where, $type)
    {
        // add a timestamp
		$indata											= array();
        $indata['participantlogin_updated'] 	= date('Y-m-d H:i:s');
        $indata['campaign_code']				= $this->_campaign->_campaign;
		
		switch($type) {
			case 'FACEBOOK' :
				$indata['participantlogin_id']				= isset($data['id']) && trim($data['id']) != '' ? trim($data['id']) : null;
				$indata['participantlogin_name'] 			= isset($data['first_name']) && trim($data['first_name']) != '' ? trim($data['first_name']) : null;
				$indata['participantlogin_surname'] 	= isset($data['last_name']) && trim($data['last_name']) != '' ? trim($data['last_name']) : null;
				$indata['participantlogin_url']				= isset($data['link']) && trim($data['link']) != '' ? trim($data['link']) : null;
				$indata['participantlogin_username']	= isset($data['email']) && trim($data['email']) != '' ? trim($data['email']) : null;
				$indata['participantlogin_location']		= isset($data['location']['name']) && trim($data['location']['name']) != '' ? trim($data['location']['name']) : null;
				$indata['participantlogin_active']	 		= 1;
				$indata['participantlogin_lastlogin'] 		= date('Y-m-d H:i:s');
				break;	
			case 'EMAIL' :
				$indata['participantlogin_id']				= null;
				$indata['participantlogin_name'] 			= isset($data['participant_name']) && trim($data['participant_name']) != '' ? trim($data['participant_name']) : null;
				$indata['participantlogin_surname'] 	= isset($data['participant_surname']) && trim($data['participant_surname']) != '' ? trim($data['participant_surname']) : null;
				$indata['participantlogin_url']				= null;
				$indata['participantlogin_username']	= isset($data['participant_email']) && trim($data['participant_email']) != '' ? trim($data['participant_email']) : null;
				$indata['participantlogin_location']		= isset($data['areapost_name']) && trim($data['areapost_name']) != '' ? trim($data['areapost_name']) : null;
				$indata['participantlogin_active']	 		= isset($data['participant_active']) && trim($data['participant_active']) != '' ? trim($data['participant_active']) : 0;
				$indata['participantlogin_image']	 		= isset($data['participant_image_name']) && trim($data['participant_image_name']) != '' ? $data['participant_image_path'].'/big_'.$data['participant_image_name'].$data['participant_image_extension'] : '';
				$indata['participantlogin_type']	 		= 'EMAIL';
				break;		
			case 'LINKEDIN' :
				$indata['participantlogin_id']				= $data->id;
				$indata['participantlogin_name'] 			= isset($data->{'first-name'}) && trim($data->{'first-name'}) != '' ? trim($data->{'first-name'}) : null;
				$indata['participantlogin_surname'] 	= isset($data->{'last-name'}) && trim($data->{'last-name'}) != '' ? trim($data->{'last-name'}) : null;
				$indata['participantlogin_username']	= isset($data->{'email-address'}) && trim($data->{'email-address'}) != '' ? trim($data->{'email-address'}) : null;
				$indata['participantlogin_active']	 		= 1;
				$indata['participantlogin_image']			= isset($data->{'picture-url'}) && trim($data->{'picture-url'}) != '' ? trim($data->{'picture-url'}) : null;
				$indata['participantlogin_type']	 		= $type;
				$indata['participantlogin_lastlogin'] 		= date('Y-m-d H:i:s');
				break;		
			case 'GOOGLE' :
				$indata['participantlogin_id']				= isset($data['participantlogin_id']) && trim($data['participantlogin_id']) != '' ? trim($data['participantlogin_id']) : null;
				$indata['participantlogin_name'] 			= isset($data['participantlogin_name']) && trim($data['participantlogin_name']) != '' ? trim($data['participantlogin_name']) : null;
				$indata['participantlogin_surname'] 	= isset($data['participantlogin_surname']) && trim($data['participantlogin_surname']) != '' ? trim($data['participantlogin_surname']) : null;
				$indata['participantlogin_url']				= isset($data['participantlogin_url']) && trim($data['participantlogin_url']) != '' ? trim($data['participantlogin_url']) : null;
				$indata['participantlogin_username']	= isset($data['participantlogin_username']) && trim($data['participantlogin_username']) != '' ? trim($data['participantlogin_username']) : null;
				$indata['participantlogin_location']		= isset($data['participantlogin_location']) && trim($data['participantlogin_location']) != '' ? trim($data['participantlogin_location']) : null;
				$indata['participantlogin_active']	 		= 1;
				$indata['participantlogin_type']	 		= $type;
				$indata['participantlogin_lastlogin'] 		= date('Y-m-d H:i:s');
				break;						
		}

        return parent::update($indata, $where);
    }
	
	public function getAll()	{
	
		$select = $this->_db->select()	
						->from(array('participantlogin' => 'participantlogin'))
						->joinLeft('campaign', 'campaign.campaign_code = participantlogin.campaign_code')
						->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code')
						->where('participantlogin_deleted = 0  and participant_deleted = 0 and campaign_deleted = 0')
						->where($this->_campaign->_campaignsql);

	   $result = $this->_db->fetchAll($select);
       return ($result == false) ? false : $result = $result;
	   
	}
	
	/**
	 * get all administrators ordered by column name
	 * example: $collection->getAlladministrators('administrator_title');
	 * @param string $order
     * @return object
	 */
	public function checkLogin($username = '', $password= ''){
		$select = $this->_db->select()	
				->from(array('participantlogin' => 'participantlogin'))
				->joinLeft('campaign', 'campaign.campaign_code = participantlogin.campaign_code')
				->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code')
				->where('participantlogin_deleted = 0  and participant_deleted = 0 and campaign_deleted = 0')
				->where($this->_campaign->_campaignsql)
				->where('participantlogin_username = ?', $username)
				->where('participantlogin_active = 1')
				->where("participantlogin_type in('EMAIL')")
				->where('participantlogin_password = ?', $password);

	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * get all administrators ordered by column name
	 * example: $collection->getAlladministrators('administrator_title');
	 * @param string $order
     * @return object
	 */
	public function checkUsername($username, $type, $check = true){
			
			/* We are checking if the username exists by type of login */
		if($check == true) {
			$select = $this->_db->select()	
					->from(array('participantlogin' => 'participantlogin'))
					->joinLeft('campaign', 'campaign.campaign_code = participantlogin.campaign_code')
					->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code')
					->where('participantlogin_deleted = 0  and participant_deleted = 0 and campaign_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('participantlogin_username = ?', $username)
					->where("participantlogin_type = ?", $type);				
		} else {
			/* We are checking if current username already exist so that we can link the participantcode to it. */
			$select = $this->_db->select()	
					->from(array('participantlogin' => 'participantlogin'))
					->joinLeft('campaign', 'campaign.campaign_code = participantlogin.campaign_code')
					->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code')
					->where('participantlogin_deleted = 0  and participant_deleted = 0 and campaign_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('participantlogin_username = ?', $username)
					->where("participantlogin_type != ?", $type);					
		}
		
	   $result = $this->_db->fetchRow($select);
       return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * get all administrators ordered by column name
	 * example: $collection->getAlladministrators('administrator_title');
	 * @param string $order
     * @return object
	 */
	public function getByID($id, $type, $username = null){
			
			/* We are checking if the username exists by type of login */
		if($username != null) {
			$select = $this->_db->select()	
					->from(array('participantlogin' => 'participantlogin'))
					->joinLeft('campaign', 'campaign.campaign_code = participantlogin.campaign_code')
					->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code')
					->where('participantlogin_deleted = 0  and participant_deleted = 0 and campaign_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('participantlogin_id = ?', $id)
					->where("participantlogin_type = ?", $type)
					->where("participantlogin_username = ?", $username);				
		} else {
			/* We are checking if current username already exist so that we can link the participantcode to it. */
			$select = $this->_db->select()	
					->from(array('participantlogin' => 'participantlogin'))
					->joinLeft('campaign', 'campaign.campaign_code = participantlogin.campaign_code')
					->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code')
					->where('participantlogin_deleted = 0  and participant_deleted = 0 and campaign_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('participantlogin_id = ?', $id)
					->where("participantlogin_type = ?", $type);			
		}
		
	   $result = $this->_db->fetchRow($select);
       return ($result == false) ? false : $result = $result;
	}
	/**
	 * get job by job mailinglist Id
 	 * @param string job id
     * @return object
	 */
	public function getByHash($code, $activate) {
			$select = $this->_db->select()	
					->from(array('participantlogin' => 'participantlogin'))
					->joinLeft('campaign', 'campaign.campaign_code = participantlogin.campaign_code')
					->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code')
					->where('participantlogin_deleted = 0  and participant_deleted = 0 and campaign_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('mailinglist.mailinglist_hashcode = ?', $code)
					->where('participantlogin.participantlogin_active = ?', $activate)
					->group('mailinglist.mailinglist_code')
					->limit(1);
		
		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;	      
	}
	
	/**
	 * get job by job participant Id
 	 * @param string job id
     * @return object
	 */
	public function checkEmail($email, $participantcode = null) {
		
		if($participantcode == null) {
			$select = $this->_db->select()	
					->from(array('participantlogin' => 'participantlogin'))
					->joinLeft('campaign', 'campaign.campaign_code = participantlogin.campaign_code')
					->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code')
					->where('participantlogin_deleted = 0  and participant_deleted = 0 and campaign_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('participantlogin_username = ?', $email);
		} else {
			$select = $this->_db->select()	
					->from(array('participantlogin' => 'participantlogin'))
					->joinLeft('campaign', 'campaign.campaign_code = participantlogin.campaign_code')
					->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code')
					->where('participantlogin_deleted = 0  and participant_deleted = 0 and campaign_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('participantlogin_username = ?', $email)
					->where('participant_code != ?', $participantcode);		
		}
		
		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByParticipant($code, $type = null) {
		
		if($type == null) {
			$select = $this->_db->select()	
					->from(array('participantlogin' => 'participantlogin'))
					->joinLeft('campaign', 'campaign.campaign_code = participantlogin.campaign_code')
					->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code')
					->where('participantlogin_deleted = 0  and participant_deleted = 0 and campaign_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('participantlogin.participant_code = ?', $code);

		   $result = $this->_db->fetchAll($select);
	   
	   } else {
			$select = $this->_db->select()	
					->from(array('participantlogin' => 'participantlogin'))
					->joinLeft('campaign', 'campaign.campaign_code = participantlogin.campaign_code')
					->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code')
					->where('participantlogin_deleted = 0  and participant_deleted = 0 and campaign_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('participantlogin.participant_code = ?', $code)
					->where('participantlogin.participantlogin_type = ?', $type);

		   $result = $this->_db->fetchRow($select);	   
	   }
	   
       return ($result == false) ? false : $result = $result;					   
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByCode($reference) {
		$select = $this->_db->select()	
				->from(array('participantlogin' => 'participantlogin'))
				->joinLeft('campaign', 'campaign.campaign_code = participantlogin.campaign_code')
				->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code')
				->where('participantlogin_deleted = 0  and participant_deleted = 0 and campaign_deleted = 0')
				->where($this->_campaign->_campaignsql)
				->where('participantlogin_code = ?', $reference)
				->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByLogin($code, $login) {
			$select = $this->_db->select()	
					->from(array('participantlogin' => 'participantlogin'))
					->joinLeft('campaign', 'campaign.campaign_code = participantlogin.campaign_code')
					->joinLeft('participant', 'participant.participant_code = participantlogin.participant_code')
					->where('participantlogin_deleted = 0  and participant_deleted = 0 and campaign_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('participantlogin.participant_code = ?', $code)
					->where('participantlogin.participantlogin_type = ?', $login);

	   $result = $this->_db->fetchRow($select);	
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
						->from(array('participantlogin' => 'participantlogin'))	
					   ->where('participantlogin_code = ?', $code)
					   ->limit(1);

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
	
	
	function createCode() {
		/* New code. */
		$code = "";
		// $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet = '1234567890';
		
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