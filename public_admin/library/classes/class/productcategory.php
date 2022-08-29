<?php
//custom recruiter item class as recruiter table abstraction
class class_productcategory extends Zend_Db_Table_Abstract {
   //declare table variables
    protected $_name    = 'productcategory';
	protected $_primary = 'productcategory_id';

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
        $data['productcategory_added']	= date('Y-m-d H:i:s');
        $data['entity_id']				= $this->_entity;		
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
        $data['productcategory_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	/**
	 * get job by job bank Id
 	 * @param string job id
     * @return object
	 */
	public function pairs() {

		$select = $this->_db->select()
			->from(array('productcategory' => 'productcategory'), array('productcategory_id', "productcategory_name"))
			->where('productcategory_deleted = 0 and entity_id = ?', $this->_entity);

		$result = $this->_db->fetchPairs($select);
		return ($result == false) ? false : $result = $result;		
	}
	/**
	 * get job by job productcategory Id
 	 * @param string job id
     * @return object
	 */
	public function getById($id) {

		$select = $this->_db->select()
			->from(array('productcategory' => 'productcategory'))
			->where('productcategory.productcategory_id = ?', $id)			
			->where('productcategory_deleted = 0 and entity_id = ?', $this->_entity)		
			->limit(1);		

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;		
	}		
	/**
	 * get job by job productcategory Id
 	 * @param string job id
     * @return object
	 */
	public function getAll() {

		$select = $this->_db->select()
			->from(array('productcategory' => 'productcategory'))
			->where('productcategory_deleted = 0 and entity_id = ?', $this->_entity);	

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;		
	}	
	/**
	 * get job by job template Id
 	 * @param string job id
     * @return object
	 */
	public function paginate($start, $length, $filter = array()) {
	
		$where	= 'productcategory.productcategory_deleted = 0';
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
							$where .= "lower(productcategory.productcategory_name) like lower('%$text%')";
							if(($s+1) != count($array)) {
								$where .= ' or ';
							}
						}
					}
					$where .= ")";
				} else if(isset($filter[$i]['filter_section']) && trim($filter[$i]['filter_section']) != '') {
                    $text = trim($filter[$i]['filter_section']);
                    $this->sanitize($text);
                    $where .= " and productcategory.statementsection_id = $text";
				}
			}
		}

		$select = $this->_db->select()
			->from(array('productcategory' => 'productcategory'))
			->where('productcategory_deleted = 0 and entity_id = ?', $this->_entity)
			->order('productcategory_name desc');

		if($csv) {
			$result = $this->_db->fetchAll($select);
			return ($result == false) ? false : $result = $result;	
		} else {
			$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");
			$result = $this->_db->fetchAll($select . " limit $start, $length");
			return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);
		}
	}	

    function sanitize(&$string) { $string = preg_replace("/[^a-zA-Z0-9_]+/", "", $string);}
    function sanitizeArray(&$array) { for($i = 0; $i < count($array); $i++) { $array[$i] = preg_replace("/[^a-zA-Z0-9_]+/", "", $array[$i]); } }	
}
?>