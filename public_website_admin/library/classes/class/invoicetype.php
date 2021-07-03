<?php

//custom account item class as account table abstraction
class class_invoicetype extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name = 'invoicetype';

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data)
    {
        // add a timestamp
        $data['invoicetype_added'] = date('Y-m-d H:i:s');

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
        $data['invoicetype_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	public function remove($code) {
		return $this->delete('invoicetype_code = ?', $code);		
	}
	
	/**
	 * get job by job invoicetype Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		$select = $this->_db->select()	
					->from(array('invoicetype' => 'invoicetype'))	
					->where('invoicetype_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}	
	
	public function getAll($where = NULL, $order = NULL)
	{
		$select = $this->_db->select()	
						->from(array('invoicetype' => 'invoicetype'))					
						->where($where)
						->order($order);						
						
		return $this->_db->fetchAll($select);
	}
	
	public function pairs() {
		$select = $this->select()
					   ->from(array('invoicetype' => 'invoicetype'), array('invoicetype.invoicetype_code', 'invoicetype.invoicetype_name'))
					   ->order('invoicetype.invoicetype_added ASC');

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
					   ->where('invoicetype_code = ?', $reference)
					   ->limit(1);

	   $result = $this->fetchRow($select);
        return ($result == false) ? false : $result = $result;					   
		
	}
	
	function createReference() {
		/* New reference. */
		$reference = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<2;$i++){
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