<?php
require_once '_comm.php';
//custom recruiter item class as recruiter table abstraction
class class_account extends Zend_Db_Table_Abstract {
   //declare table variables
    protected $_name 		= 'account';
	protected $_primary 	= 'account_id';
	
	public	$_config	= null;
	
	function init()	{
		global $zfsession;
		$this->_comm        	= new class_comm();
		$this->_activeAccount   = isset($zfsession->activeAccount) ? $zfsession->activeAccount : null;
		$this->_config          = $zfsession->config;
	}
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	public function insert(array $data) {
        // add a timestamp
        $data['account_added']      = date('Y-m-d H:i:s');
        $data['account_reference']  = $this->createReference();
		$account = parent::insert($data);	
		// Get the participant details. 
		$accountData = $this->getById($account);

		if($accountData) {
			// Send an email.
			$templateData = $this->_comm->_template->getTemplate('EMAIL', 'REGISTERED');

			if($templateData) {
				$recipient							= array();
				$recipient['recipient_id']          = $accountData['account_id'];
				$recipient['recipient_name']        = $accountData['account_name'];
				$recipient['recipient_cellphone']   = $accountData['account_cellphone'];
				$recipient['recipient_email']       = $accountData['account_contact_email'];
				$recipient['recipient_type']        = 'ACCOUNT';	
				$recipient['recipient_from_name']	= 'Yam Accounting Solution';
				$recipient['recipient_from_email']	= 'admin@yamaccounting.com';		
				$recipient['recipient_media']       = $this->_config['site'].'/media/template/'.strtolower($templateData['template_id']).'/media/';				
				$this->_comm->sendEMAIL(array_merge($recipient, $accountData, $templateData));
			}
			// Send an sms. 
			$templateData = $this->_comm->_template->getTemplate('SMS', 'REGISTERED');
			if($templateData) {
				$recipient                          = array();
				$recipient['recipient_id'] 		    = $accountData['account_id'];
				$recipient['recipient_name'] 		= $accountData['account_name'];
				$recipient['recipient_cellphone'] 	= $accountData['account_cellphone'];
				$recipient['recipient_email']		= $accountData['account_contact_email'];
				$recipient['recipient_type']        = 'ACCOUNT';
				$this->_comm->sendSMS(array_merge($recipient, $accountData, $templateData));
			}				
		}

		return $account;
    }
	/**
	 * Update the database record
	 * example: $table->update($data, $where);
	 * @param query string $where
	 * @param array $data
     * @return boolean
	 */
    public function update(array $data, $where) {
        // add a timestamp
        $data['account_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	/**
	 * get job by job account Id
 	 * @param string job id
     * @return object
	 */
	public function getById($id) {
				
		$select = $this->_db->select()
			->from(array('account' => 'account'))
			->where('account.account_id = ?', $id)
			->limit(1);		

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;		
	}
	/**
	 * get domain by domain Municipality Id
 	 * @param string domain id
     * @return object
	 */
	public function pairs() {

		$select = $this->_db->select()
			->from(array('account' => 'account'), array('account_id', 'account_name'))
			->where("account_deleted = 0 and account_active = 1 and account_type = 'ADMIN'");			

		$result = $this->_db->fetchPairs($select);
        return ($result == false) ? false : $result = $result;					   
	}		
	/**
	 * Check user login
	 * example: $table->checkLogin($username, $admin_password);
	 * @param query string $username
	 * @param query string $admin_password
     * @return boolean
	 */
	public function checkLogin($username = '', $password= '') {
		$select = $this->_db->select()	
			->from(array('account' => 'account'))	
			->where('account_email = ?', $username)
			->where('account_password = ?', $password)
			->where("account_deleted = 0 and account_type = 'SUPER'"); // only super users can access this.

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;
	}
	/**
	 * get domain by domain Municipality Id
 	 * @param string domain id
     * @return object
	 */	
	public function paginate($start, $length, $filter = array()) {
	
		$where	= 'account_id is not null';
		$csv	= 0;

		if(count($filter) > 0) {
			for($i = 0; $i < count($filter); $i++) {
				if(isset($filter[$i]['filter_search']) && trim($filter[$i]['filter_search']) != '') {
					$array = explode(" ",trim($filter[$i]['filter_search']));					
					if(count($array) > 0) {
						$where .= " and (";
						for($s = 0; $s < count($array); $s++) {
							$text = $array[$s];
							$this->sanitize($text);
							$where .= "concat(account_name, ' ', account_email, ' ', account_cellphone) like lower('%$text%')";
							if(($s+1) != count($array)) {
								$where .= ' or ';
							}
						}
					}
					$where .= ")";
				} else if(isset($filter[$i]['filter_csv']) && (int)trim($filter[$i]['filter_csv']) == 1) {
					$csv = 1;
				}
			}
		}
		
		$select = $this->_db->select()
			->from(array('account' => 'account'))	
			->where($where);

		$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");
		$result = $this->_db->fetchAll($select . " limit $start, $length");
		return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);
	}

	/**
	 * get job by job account Id
 	 * @param string job id
     * @return object
	 */
	public function getByCell($cell, $id = null) {
		if($id == null) {
			$select = $this->_db->select()	
				->from(array('account' => 'account'))
				->where('account_cellphone = ?', $cell)						
				->where('account_deleted = 0')
				->limit(1);
		} else {
			$select = $this->_db->select()	
				->from(array('account' => 'account'))
				->where('account_cellphone = ?', $cell)
				->where('account_id != ?', $id)
				->where('account_deleted = 0')
				->limit(1);		
		}

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;
	}
	/**
	 * get job by job account Id
 	 * @param string job id
     * @return object
	 */
	public function getByEmail($email, $id = null) {
		if($id == null) {
			$select = $this->_db->select()	
				->from(array('account' => 'account'))
				->where('account_email = ?', $email)
				->where('account_deleted = 0')
				->limit(1);
		} else {
			$select = $this->_db->select()	
				->from(array('account' => 'account'))
				->where('account_email = ?', $email)
				->where('account_id != ?', $id)
				->where('account_deleted = 0')
				->limit(1);		
		}

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;
	}

	function createReference() {
		/* New id. */
		$id = "";
		$Alphabet 	= "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		/* First two Alphabets. */
		$count = strlen($Alphabet) - 1;
		for($i=0;$i<3;$i++){
			$id .= $Alphabet[rand(0,$count)];
		}
		return $id;
	}
	
	public function validateEmail($string) {
		if(!filter_var($string, FILTER_VALIDATE_EMAIL)) {
			return '';
		} else {
			return trim($string);
		}
	}
	
	public function validateNumber($string) {
		if(preg_match('/^0[0-9]{9}$/', $this->onlyNumber(trim($string)))) {
			return $this->onlyNumber(trim($string));
		} else {
			return '';
		}
	}
	
	public function onlyNumber($string) {
		/* Remove some weird charactors that windows dont like. */
		$string = strtolower($string);
		$string = str_replace(' ' , '' , $string);
		$string = str_replace('__' , '' , $string);
		$string = str_replace(' ' , '' , $string);
		$string = str_replace("`", "", $string);
		$string = str_replace("/", "", $string);
		$string = str_replace("\\", "", $string);
		$string = str_replace("'", "", $string);
		$string = str_replace("(", "", $string);
		$string = str_replace(")", "", $string);
		$string = str_replace("-", "", $string);
		$string = str_replace(".", "", $string);
		$string = str_replace('___' , '' , $string);
		$string = str_replace('__' , '' , $string);	 
		$string = str_replace(' ' , '' , $string);
		$string = str_replace('__' , '' , $string);
		$string = str_replace(' ' , '' , $string);
		$string = str_replace("`", "", $string);
		$string = str_replace("/", "", $string);
		$string = str_replace("\\", "", $string);
		$string = str_replace("'", "", $string);
		$string = str_replace("(", "", $string);
		$string = str_replace(")", "", $string);
		$string = str_replace("-", "", $string);
		$string = str_replace(".", "", $string);
		$string = str_replace("–", "", $string);	
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
	

    function sanitize(&$string) { $string = preg_replace("/[^a-zA-Z0-9_]+/", "", $string);}
    function sanitizeArray(&$array) { for($i = 0; $i < count($array); $i++) { $array[$i] = preg_replace("/[^a-zA-Z0-9_]+/", "", $array[$i]); } }	
}
?>