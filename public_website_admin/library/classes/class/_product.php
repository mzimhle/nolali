<?php

//custom account item class as account table abstraction
class class_product extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 		= '_product';
	protected $_primary 	= '_product_code';
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data)
    {
        // add a timestamp
        $data['_product_added'] = date('Y-m-d H:i:s');
		$data['_product_code']  	= $this->createReference();

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
        $data['_product_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job _product Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		$select = $this->_db->select()	
					->from(array('_product' => '_product'))	
					->where('_product_code = ?', $code)
					->limit(1);
       
		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;

	}	
	
	public function getAll($where = NULL, $order = NULL)
	{
		$select = $this->_db->select()	
						->from(array('_product' => '_product'))					
						->where('_product._product_deleted = 0')
						->order('_product_name');						
						
		$result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function pairs() {
		$select = $this->select()
					   ->from(array('_product' => '_product'), array('_product._product_code', "concat(_product_type, ' - ',_product._product_name, ' (',_product._product_quantity,')') as _product_name"))
					   ->where('_product_deleted = 0 and _product_active = 1')
					   ->order('_product._product_added ASC');

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
					   ->where('_product_code = ?', $code)
					   ->limit(1);

	   $result = $this->fetchRow($select);
        return ($result == false) ? false : $result = $result;					   
		
	}
	
	function createReference() {
		/* New reference.
		$code = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<2;$i++){
			$reference .= $codeAlphabet[rand(0,$count)];
		}
		*/
		 
		$code = time();
		 
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($code);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createReference();
		} else {
			return $code;
		}
	}		
}
?>