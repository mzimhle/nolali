<?php
//custom recruiter item class as recruiter table abstraction
class class_entityproduct extends Zend_Db_Table_Abstract {
	//declare table variables
    protected $_name 		= 'entityproduct';
	protected $_primary 	= 'entityproduct_id';

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	 public function insert(array $data) {
        // add a timestamp
        $data['entityproduct_added']	= date('Y-m-d H:i:s');
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
        $data['entityproduct_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	/**
	 * get job by job entityproduct Id
 	 * @param string job id
     * @return object
	 */
	public function getById($id) {

		$select = $this->_db->select()
			->from(array('entityproduct' => 'entityproduct'))
            ->joinInner(array('entity' => 'entity'), 'entity.entity_id = entityproduct.entity_id')
			->where('entityproduct_deleted = 0 and entityproduct.entityproduct_id = ?', $id)
			->limit(1);		

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;		
	}
	/**
	 * get job by job entityproduct Id
 	 * @param string job id
     * @return object
	 */
	public function AlreadyExists($code, $entity) {

		$select = $this->_db->select()
			->from(array('entityproduct' => 'entityproduct'))
            ->joinInner(array('entity' => 'entity'), 'entity.entity_id = entityproduct.entity_id')
			->where('entityproduct_deleted = 0 and entityproduct.entityproduct_code = ?', $code)
			->where('entity_deleted = 0 and entityproduct.entity_id = ?', $entity)			
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
	
		$where	= 'entityproduct_deleted = 0';
		$csv	= 0;

		if(count($filter) > 0) {
			for($i = 0; $i < count($filter); $i++) {
				if(isset($filter[$i]['filter_entity']) && trim($filter[$i]['filter_entity']) != '') {
                    $text = trim($filter[$i]['filter_entity']);
                    $this->sanitize($text);
                    $where .= " and entityproduct.entity_id = $text";
				}
			}
		}

		$select = $this->_db->select()
			->from(array('entityproduct' => 'entityproduct'))
            ->joinInner(array('entity' => 'entity'), 'entity.entity_id = entityproduct.entity_id', array())
			->where($where);

		$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");
		$result = $this->_db->fetchAll($select . " limit $start, $length");
		return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);
	}	

    function sanitize(&$string) { $string = preg_replace("/[^a-zA-Z0-9_]+/", "", $string);}
    function sanitizeArray(&$array) { for($i = 0; $i < count($array); $i++) { $array[$i] = preg_replace("/[^a-zA-Z0-9_]+/", "", $array[$i]); } }	
}
?>