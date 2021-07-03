<?php

//custom account item class as account table abstraction
class class_campaigntype extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name = 'campaigntype';

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data)
    {
        // add a timestamp
        $data['campaigntype_added'] = date('Y-m-d H:i:s');
        
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
        $data['campaigntype_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job campaigntype Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		$select = $this->_db->select()	
					->from(array('campaigntype' => 'campaigntype'))	
					->where('campaigntype_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}	
	
	public function getAll()
	{
		$select = $this->_db->select()	
						->from(array('campaigntype' => 'campaigntype'))
						->order('campaigntype_name');						
						
		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
	}
	
	public function pairs() {
		$select = $this->select()
					   ->from(array('campaigntype' => 'campaigntype'), array('campaigntype.campaigntype_code', 'campaigntype.campaigntype_name'))
					   ->order('campaigntype.campaigntype_added ASC');

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
		$select = $this->select() 
					   ->where('campaigntype_code = ?', $reference)
					   ->limit(1);

	   $result = $this->fetchRow($select);
        return ($result == false) ? false : $result = $result;					   
		
	}
	
	function createReference() {
		/* New reference. */
		$reference = "";
		//$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet = "0123456789";
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<10;$i++){
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
}
?>