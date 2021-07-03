<?php

require_once '_campaignpackage.php';

//custom account item class as account table abstraction
class class_campaign extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 		= 'campaign';
	protected $_primary 	= 'campaign_code';
	
	public $_campaignpackage	= null;
	
	function init()	{
	
		$this->_campaignpackage	= new class_campaignpackage();
		
		global $zfsession;

		if(isset($zfsession->domainData)) {
			$this->_campaign 		= $zfsession->domainData['campaign_code'];			
			$this->_campaignsql = "campaign.campaign_code = '".$zfsession->domainData['campaign_code']."'";
		} else {
			$this->_campaignsql = 'campaign.campaign_code = campaign.campaign_code';
		}		
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
        $data['campaign_added'] = date('Y-m-d H:i:s');
		
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
        $data['campaign_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job campaign Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code) {
		
		$select = $this->_db->select()	
					->from(array('campaign' => 'campaign'))	
					->joinLeft(array('campaigntype' => 'campaigntype'), 'campaigntype.campaigntype_code = campaign.campaigntype_code')	
					->joinLeft(array('areapost' => 'areapost'), 'areapost.areapost_code = campaign.areapost_code')
					->where('campaign_code = ?', $code)
					->limit(1);		
	   
	   $result = $this->_db->fetchRow($select);
	   
	   if($result) {
			$campaignpackageData = $this->_campaignpackage->getCampaignComponents($code, 'PAGE');
			
			$result['_component'] = $campaignpackageData;
	   }
	   
       return ($result == false) ? false : $result = $result;		
	}	
	
	public function getAll()
	{
		$select = $this->_db->select()	
						->from(array('campaign' => 'campaign'))	
						->joinLeft(array('campaigntype' => 'campaigntype'), 'campaigntype.campaigntype_code = campaign.campaigntype_code')	
						->joinLeft(array('areapost' => 'areapost'), 'areapost.areapost_code = campaign.areapost_code')					
						->where('campaign_deleted = 0')
						->order('campaign_name desc');						

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
	}
	
	public function pairs() {
		$select = $this->select()
					   ->from(array('campaign' => 'campaign'), array('campaign.campaign_code', 'campaign.campaign_company'))
					   ->where('campaign_active = 1')
					   ->order('campaign.campaign_added ASC');

		$result = $this->_db->fetchPairs($select);
		return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($reference)
	{
		$select = $this->_db->select()	
						->from(array('campaign' => 'campaign'))	
					   ->where('campaign_code = ?', $reference)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;					   

	}
	
	function createReference() {
		/* New reference. */
		$reference = "";
		$codeAlphabet = "123456789";
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<4;$i++){
			$reference .= $codeAlphabet[rand(0,$count)];
		}
		
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($reference);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createReference();
		} else {
			return $reference;
		}
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
	
	public function validateNumber($string) {
		if(preg_match('/^0[0-9]{9}$/', $this->onlyNumber(trim($string)))) {
			return $this->onlyNumber(trim($string));
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
	
	public function onlyNumber($string) {

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