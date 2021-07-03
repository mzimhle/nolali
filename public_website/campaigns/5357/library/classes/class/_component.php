<?php

//custom account item class as account table abstraction
class class_component extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected	$_name	= '_component';
	protected	$_primary	= '_component_code';	

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data)
    {
        // add a timestamp
        $data['_component_added'] = date('Y-m-d H:i:s');
        $data['_component_code']		= $this->createReference();
		
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
        $data['_component_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job _component Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		
		$select = $this->_db->select()	
					->from(array('_component' => '_component'))
					->joinLeft(array('_package' => '_package'), '_package._package_code = _component._package_code')
					->joinLeft(array('_product' => '_product'), '_product._product_code = _component._product_code')
					->where('_component_deleted = 0 and _package_deleted = 0 and _product_deleted = 0')
					->where('_component._component_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function getProductByPackage($product, $package) {
		$select = $this->_db->select()	
					->from(array('_component' => '_component'))
					->joinLeft(array('_package' => '_package'), '_package._package_code = _component._package_code')
					->joinLeft(array('_product' => '_product'), '_product._product_code = _component._product_code')
					->where('_component_deleted = 0 and _package_deleted = 0 and _product_deleted = 0')	
					->where('_component._product_code = ?', $product)
					->where('_component._package_code = ?', $package)
					->where('_component_deleted = 0');	
					
		$result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;					
	}
	/**
	 * get job by job _component Id
 	 * @param string job id
     * @return object
	 */
	public function getByPackage($code)
	{		
		$select = $this->_db->select()	
					->from(array('_component' => '_component'))
					->joinLeft(array('_package' => '_package'), '_package._package_code = _component._package_code')
					->joinLeft(array('_product' => '_product'), '_product._product_code = _component._product_code')
					->where('_component_deleted = 0 and _package_deleted = 0 and _product_deleted = 0')	
					->where('_component._package_code = ?', $code)
					->where('_component_deleted = 0');

		$result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function getAll()
	{	
		$select = $this->_db->select()	
					->from(array('_component' => '_component'))
					->joinLeft(array('_package' => '_package'), '_package._package_code = _component._package_code')
					->joinLeft(array('_product' => '_product'), '_product._product_code = _component._product_code')
					->where('_component_deleted = 0 and _package_deleted = 0 and _product_deleted = 0')
					->order('_component_added');						

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
						->from(array('_component' => '_component'))		
					   ->where('_component_code = ?', $code)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;				   		
	} 
	
	function createReference() {
		/* New code. 
		$code = "";

		$codeAlphabet = "123456789";
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<6;$i++) {
			$code .= $codeAlphabet[rand(0,$count)];
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