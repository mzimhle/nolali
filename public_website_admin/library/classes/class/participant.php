<?php

require_once 'participantlogin.php';
require_once 'campaign.php';

//custom account item class as account table abstraction
class class_participant extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name			= 'participant';
	protected $_primary		= 'participant_code';
	
	public $_campaign			= null;
	public $_participantlogin	= null;
	
	function init()	{
	
		global $zfsession;

		$this->_campaign				= new class_campaign();		
		$this->_participantlogin		= new class_participantlogin();
	}

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	public function insert(array $data) {
        // add a timestamp
        $data['participant_added']	= date('Y-m-d H:i:s');
        $data['participant_code']	= isset($data['participant_code']) && trim($data['participant_code']) != '' ? $data['participant_code'] : $this->createCode();
		$data['campaign_code']		= $this->_campaign->_campaign;

		return parent::insert($data);	

    }
	
	public function insertParticipant(array $data, $type) {
		
		$insert													= array();
		$insert['areapost_code']							= isset($data['areapost_code']) && trim($data['areapost_code']) != '' ? $data['areapost_code'] : null;
		$insert['participant_name']						= isset($data['participant_name']) && trim($data['participant_name']) != '' ? $data['participant_name'] : null;
		$insert['participant_surname']					= isset($data['participant_surname']) && trim($data['participant_surname']) != '' ? $data['participant_surname'] : null;
		$insert['participant_email']						= isset($data['participant_email']) && trim($data['participant_email']) != '' ? $data['participant_email'] : null;		
		$insert['participant_cellphone']				= isset($data['participant_cellphone']) && trim($data['participant_cellphone']) != '' ? $data['participant_cellphone'] : null;
		$insert['participant_subscribe']				= isset($data['participant_subscribe']) && trim($data['participant_subscribe']) != '' ? $data['participant_subscribe'] : 1;
		$insert['participant_image_name']			= isset($data['participant_image_name']) && trim($data['participant_image_name']) != '' ? $data['participant_image_name'] : null;
		$insert['participant_image_extension']		= isset($data['participant_image_extension']) && trim($data['participant_image_extension']) != '' ? $data['participant_image_extension'] : null;
		$insert['participant_image_path']				= isset($data['participant_image_path']) && trim($data['participant_image_path']) != '' ? $data['participant_image_path'] : null;
		
		$success = $this->insert($insert);

		if($success) {
			/* Insert login data. */
			$participantData = $this->getCode($success);			
			
			if($participantData) {
				
				switch($type) {
					case 'EMAIL' : 
						/* Create a new login record. */
						$this->_participantlogin->insertLogin($participantData, $type, $success);
					break;
					case 'FACEBOOK' : 
						/* Create a new login record. */
						$this->_participantlogin->insertLogin(array_merge($participantData, $data), $type, $success);						
					break;
					case 'LINKEDIN' : 
						/* Create a new login record. */
						$this->_participantlogin->insertLogin(array_merge($participantData, $data), $type, $success);						
					break;
					case 'GOOGLE' : 
						/* Create a new login record. */
						$this->_participantlogin->insertLogin(array_merge($participantData, $data), $type, $success);						
					break;							
				}
				return $success;
			}		
		}
		
		return $success;
	}
	
	public function updateParticipant(array $data, $type) {

		if(isset($data['participant_code'])) {
			
			/* Update participant. */
			$partwhere	= array();
			$partwhere[] = $this->getAdapter()->quoteInto('campaign_code = ?', $this->_campaign->_campaign);
			$partwhere[] = $this->getAdapter()->quoteInto('participant_code = ?', $data['participant_code']);
			
			parent::update($data, $partwhere);
			
			/* Update mailinglist. */
			$tempData = $this->getByCode($data['participant_code']);

			if($tempData) {
				 
				/* Update participantlogin. */
				$loginwhere = array();
				$loginwhere[] = $this->getAdapter()->quoteInto('campaign_code = ?', $this->_campaign->_campaign);
				$loginwhere[] = $this->_participantlogin->getAdapter()->quoteInto('participant_code = ?', $tempData['participant_code']);
				$loginwhere[] = $this->_participantlogin->getAdapter()->quoteInto('participantlogin_type = ?', $type);
				
				$this->_participantlogin->updateLogin($tempData, $loginwhere, $type);	
				
				return $tempData['participant_code'];
			}
			
			return false;
		} else {
			return false;
		}
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
         $data['participant_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job participant Id
 	 * @param string job id
     * @return object
	 */
	public function checkEmail($email) {
		$select = $this->_db->select()	
							->from(array('participant' => 'participant'))	
							->where('participant_email = ?', $email)
							->where('participant_deleted = 0')
							->where($this->_campaign->_campaignsql);

	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function getAll()	{
	
		$select = $this->_db->select()	
						->from(array('participant' => 'participant'))
						->joinLeft('areapost', 'areapost.areapost_code = participant.areapost_code')
						->joinLeft('campaign', 'campaign.campaign_code = participant.campaign_code')
						->joinLeft('participantlogin', 'participantlogin.participant_code = participant.participant_code and participantlogin_deleted = 0', array('participantlogin_type' =>new Zend_Db_Expr('GROUP_CONCAT(DISTINCT participantlogin.participantlogin_type)')))						
						->where('participant_deleted = 0')
						->where($this->_campaign->_campaignsql)
						->group('participant.participant_code')
						->order(array('participant_name', 'participant_surname'));

	   $result = $this->_db->fetchAll($select);
       return ($result == false) ? false : $result = $result;
	   
	}
	
	public function search($query, $limit = 20) {
		
		$select = $this->_db->select()	
				->from(array('participant' => 'participant'))
				->joinLeft('areapost', 'areapost.areapost_code = participant.areapost_code')
				->joinLeft('campaign', 'campaign.campaign_code = participant.campaign_code')
				->joinLeft('participantlogin', 'participantlogin.participant_code = participant.participant_code and participantlogin_deleted = 0', array('participantlogin_type' =>new Zend_Db_Expr('GROUP_CONCAT(DISTINCT participantlogin.participantlogin_type)')))						
				->where("concat(participant_name, participant_surname, participant_email, participant_cellphone) like lower(?)", "%$query%")
				->where($this->_campaign->_campaignsql)					
				->limit($limit)
				->group('participant.participant_code')
				->order("LOCATE('$query', participant.participant_name)");

		$result = $this->_db->fetchAll($select);	
        return ($result == false) ? false : $result = $result;					

	}
	
	public function getSearch($search, $start, $length)
	{	
		if($search == '') {
			$select = $this->_db->select()	
					->from(array('participant' => 'participant'))
					->joinLeft('areapost', 'areapost.areapost_code = participant.areapost_code', array('areapost_name'))
					->joinLeft('campaign', 'campaign.campaign_code = participant.campaign_code', array('campaign_name', 'campaign_domain'))
					->joinLeft('participantlogin', 'participantlogin.participant_code = participant.participant_code and participantlogin_deleted = 0', array('participantlogin_type' =>new Zend_Db_Expr('GROUP_CONCAT(DISTINCT participantlogin.participantlogin_type)')))
					->where($this->_campaign->_campaignsql)
					->where('participant_deleted = 0')
					->group('participant.participant_code')					
					->order('participant_added desc');			
		} else {
			$select = $this->_db->select()	
					->from(array('participant' => 'participant'))
					->joinLeft('areapost', 'areapost.areapost_code = participant.areapost_code', array('areapost_name'))
					->joinLeft('campaign', 'campaign.campaign_code = participant.campaign_code', array('campaign_name', 'campaign_domain'))
					->joinLeft('participantlogin', 'participantlogin.participant_code = participant.participant_code and participantlogin_deleted = 0', array('participantlogin_type' =>new Zend_Db_Expr('GROUP_CONCAT(DISTINCT participantlogin.participantlogin_type)')))
					->where('participant_deleted = 0')
					->where("concat(participant_name, participant_surname, participant_email, participant_cellphone) like lower(?)", "%$search%")
					->where($this->_campaign->_campaignsql)	
					->group('participant.participant_code')
					->order('participant_added desc');			
		}

		$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");

		if ($start == '' || $length == '') { 
			$result = $this->_db->fetchAll($select);
		} else { 
			$result = $this->_db->fetchAll($select . " limit $start, $length");
		}

		return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);	
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByCode($code)
	{
		$select = $this->_db->select()	
						->from(array('participant' => 'participant'))	
						->joinLeft('campaign', 'campaign.campaign_code = participant.campaign_code')
						->joinLeft('areapost', 'areapost.areapost_code = participant.areapost_code')		
						->joinLeft('participantlogin', 'participantlogin.participant_code = participant.participant_code and participantlogin_deleted = 0', array('participantlogin_type' =>new Zend_Db_Expr('GROUP_CONCAT(DISTINCT participantlogin.participantlogin_type)')))
					   ->where('participant.participant_code = ?', $code)					   
					   ->where('participant_deleted = 0')
					   ->where($this->_campaign->_campaignsql)
					   ->group('participant.participant_code')
					   ->limit(1);

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
						->from(array('participant' => 'participant'))
						->joinLeft('campaign', 'campaign.campaign_code = participant.campaign_code')
						->joinLeft('areapost', 'areapost.areapost_code = participant.areapost_code')	
					   ->where('participant_code = ?', $code)
					   ->where($this->_campaign->_campaignsql)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createPassword() {
		/* New code. */
		$password = "";
		$codeAlphabet = "abcdefghigklmnopqrstuvwxyz";
		$codeAlphabet .= "0123456789";
		
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<5;$i++){
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
		
		for($i=0;$i<3;$i++){
			$code .= $codeAlphabet[rand(0,$count)];
		}
		
		$code = time().$code;
		
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($code);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createCode();
		} else {
			return $code;
		}
	}
	
	/**
	 * get job by job participant Id
 	 * @param string job id
     * @return object
	 */
	public function getByCell($cell, $code = null) {
	
		if($code == null) {
			$select = $this->_db->select()	
						->from(array('participant' => 'participant'))	
						->joinLeft('campaign', 'campaign.campaign_code = participant.campaign_code')
						->joinLeft('areapost', 'areapost.areapost_code = participant.areapost_code')
						->where('participant_cellphone = ?', $cell)
						->where('participant_deleted = 0')
						->where($this->_campaign->_campaignsql)
						->limit(1);
       } else {
			$select = $this->_db->select()	
						->from(array('participant' => 'participant'))
						->joinLeft('campaign', 'campaign.campaign_code = participant.campaign_code')						
						->joinLeft('areapost', 'areapost.areapost_code = participant.areapost_code')
						->where('participant_cellphone = ?', $cell)
						->where('participant_code != ?', $code)
						->where('participant_deleted = 0')
						->where($this->_campaign->_campaignsql)
						->limit(1);		
	   }
	   
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * get job by job participant Id
 	 * @param string job id
     * @return object
	 */
	public function getByEmail($email, $code = null) {
	
		if($code == null) {
			$select = $this->_db->select()	
						->from(array('participant' => 'participant'))	
						->joinLeft('campaign', 'campaign.campaign_code = participant.campaign_code')
						->joinLeft('areapost', 'areapost.areapost_code = participant.areapost_code')
						->where('participant_email = ?', $email)
						->where('participant_deleted = 0')
						->where($this->_campaign->_campaignsql)
						->limit(1);
       } else {
			$select = $this->_db->select()	
						->from(array('participant' => 'participant'))	
						->joinLeft('campaign', 'campaign.campaign_code = participant.campaign_code')
						->joinLeft('areapost', 'areapost.areapost_code = participant.areapost_code')
						->where('participant_email = ?', $email)
						->where('participant_code != ?', $code)
						->where($this->_campaign->_campaignsql)
						->where('participant_deleted = 0')
						->limit(1);		
	   }
	   
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function validateIDnumber($idnr) {	
		if(strlen(trim($idnr)) == 13) {
			if(preg_match('/([0-9][0-9])(([0][1-9])|([1][0-2]))(([0-2][0-9])|([3][0-1]))([0-9])([0-9]{3})([0-9])([0-9])([0-9])/', trim($idnr))) {
				return trim($idnr);
			} else {
				return '';
			}
		} else {
			return '';
		}
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
	
	public function validateDate($string) {
		if(preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $string)) {
			if(date('Y-m-d', strtotime($string)) != $string) {
				return '';
			} else {
				return $string;
			}
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
}
?>