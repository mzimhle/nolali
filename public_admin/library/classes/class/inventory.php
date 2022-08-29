<?php
//custom recruiter item class as recruiter table abstraction
class class_inventory extends Zend_Db_Table_Abstract {
   //declare table variables
    protected $_name 		= 'inventory';
	protected $_primary 	= 'inventory_id';
	public $_entity    = null;
    public $_activeentity    = null;
	
	function init()	{
		global $zfsession;
		$this->_entity	= $zfsession->entity;
	}
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	public function insert(array $data) {
        // add a timestamp
        $data['inventory_added'] = date('Y-m-d H:i:s');
		return parent::insert($data);
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
        $data['inventory_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	/**
	 * get job by job inventory Id
 	 * @param string job id
     * @return object
	 */
	public function getById($id) {

		$select = $this->_db->select()
			->from(array('inventory' => 'inventory'))
			->joinLeft(array('statement' => 'statement'), "statement.inventory_id = inventory.inventory_id and statement_deleted = 0", array('bankentity_id', 'section_id', 'statement_date', 'statement_type', 'statement_amount', 'statement_reference', 'statement_text', 'statement_file'))
			->where('inventory_deleted = 0 and inventory.inventory_id = ?', $id)
			->limit(1);		

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;		
	}
	/**
	 * get job by job template Id
 	 * @param string job id
     * @return object
	 */
	public function paginate($start, $length, $filter = array()) {
	
		$where	= 'inventory_deleted = 0';
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
							$where .= "lower(inventory_file_name) like lower('%$text%')";
							if(($s+1) != count($array)) {
								$where .= ' or ';
							}
						}
					}
					$where .= ")";
				} else if(isset($filter[$i]['filter_product']) && trim($filter[$i]['filter_product']) != '') {
					$text = trim($filter[$i]['filter_product']);
					$this->sanitize($text);
					$where .= " and product_id = $text";	
				}
			}
		}

		$select = $this->_db->select()
			->from(array('inventory' => 'inventory'))
			->joinLeft(array('statement' => 'statement'), "statement.inventory_id = inventory.inventory_id and statement_deleted = 0", array('bankentity_id', 'section_id', 'statement_date', 'statement_type', 'statement_amount', 'statement_reference', 'statement_text', 'statement_file'))
			->where($where)
			->order('inventory_added desc');

		if($csv) {
			$result = $this->_db->fetchAll($select);
			return ($result == false) ? false : $result = $result;	
		} else {
			$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");
			$result = $this->_db->fetchAll($select . " limit $start, $length");
			return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);
		}
	}	

	/**
	 * get job by job participant Id
 	 * @param string job id
     * @return object
	 */	
	public function unlinked($query, $limit = 20) {

		$select = $this->_db->select()
			->from(array('inventory' => 'inventory'))
			->joinInner(array('product' => 'product'), "product.product_id = inventory.product_id and product_deleted = 0", array('product_name'))
			->joinLeft(array('statement' => 'statement'), "statement.inventory_id = inventory.inventory_id and statement_deleted = 0", array())
			->where('inventory_deleted = 0 and product.entity_id = ?', $this->_entity)
			->where("(statement_id is null or statement_id = null) and lower(concat(product_name, inventory_added, inventory_amount)) like lower(?)", "%$query%")
			->limit($limit)
			->order("LOCATE('$query', concat(product_name, inventory_added, inventory_amount))");

		$result = $this->_db->fetchAll($select);	
        return ($result == false) ? false : $result = $result;					
	}
	
    function sanitize(&$string) { $string = preg_replace("/[^a-zA-Z0-9_]+/", "", $string);}
    function sanitizeArray(&$array) { for($i = 0; $i < count($array); $i++) { $array[$i] = preg_replace("/[^a-zA-Z0-9_]+/", "", $array[$i]); } }	
}
?>