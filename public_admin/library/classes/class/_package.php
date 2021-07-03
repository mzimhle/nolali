<?php

//custom account item class as account table abstraction
class class_package extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 		= '_package';
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data)
    {
        // add a timestamp
        $data['_package_added'] 	= date('Y-m-d H:i:s');     		
		$data['_package_code']		= $this->createReference();
		
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
        $data['_package_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job _package Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		
		$select = $this->_db->select()	
					->from(array('_package' => '_package'))
					->joinLeft(array('_initial' => '_price'), "_initial._price_type = 'INITIAL' and _initial._price_product = 'PACKAGE' and _initial._price_reference = _package._package_code and now() between _initial._price_startdate and _initial._price_enddate", array('_package_price_initial' => '_price_cost'))
					->joinLeft(array('_price' => '_price'), "_price._price_type = 'MONTHLY' and _price._price_product = 'PACKAGE' and _price._price_reference = _package._package_code and now() between _price._price_startdate and _price._price_enddate", array('_package_price_monthly' => '_price_cost'))			
					->where('_package_deleted = 0')
					->where('_package_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}
	
	
	public function getAll()
	{		
		$select = $this->_db->select()	
					->from(array('_package' => '_package'))
					->joinLeft(array('_initial' => '_price'), "_initial._price_type = 'INITIAL' and _initial._price_product = 'PACKAGE' and _initial._price_reference = _package._package_code and now() between _initial._price_startdate and _initial._price_enddate", array('_package_price_initial' => '_price_cost'))
					->joinLeft(array('_price' => '_price'), "_price._price_type = 'MONTHLY' and _price._price_product = 'PACKAGE' and _price._price_reference = _package._package_code and now() between _price._price_startdate and _price._price_enddate", array('_package_price_monthly' => '_price_cost'))	
					->where('_package_deleted = 0')
					->order('_package_name');	

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
	}
	
	public function pairs() {
		
		$select = $this->select()
					   ->from(array('_package' => '_package'), array('_package_code', "_package_name"))
					   ->where('_package_deleted = 0 and _package_active = 1')		
					   ->order('_package._package_added ASC');

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
						->from(array('_package' => '_package'))		
					   ->where('_package_code = ?', $reference)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;				   		
	}
	
	function createReference() {
		/* New reference. 
		$reference = "";
		//$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet = "123456789";
		
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<4;$i++){
			$reference .= $codeAlphabet[rand(0,$count)];
		}
		*/
		$reference = time();
		
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