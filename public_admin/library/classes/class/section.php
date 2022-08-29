<?php
//custom recruiter item class as recruiter table abstraction
class class_section extends Zend_Db_Table_Abstract {
   //declare table variables
    protected $_name    = 'section';
	protected $_primary = 'section_id';
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	 public function insert(array $data) {
        // add a timestamp
        $data['section_added'] = date('Y-m-d H:i:s');
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
        $data['section_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	/**
	 * get job by job bank Id
 	 * @param string job id
     * @return object
	 */
	public function pairs() {

		$select = $this->_db->select()
			->from(array('section' => 'section'), array('section_id', "section_name"))
            ->joinInner(array('category' => 'category'), 'category.category_id = category.category_id')
			->where('section_deleted = 0 and section_deleted = 0');

		$result = $this->_db->fetchPairs($select);
		return ($result == false) ? false : $result = $result;		
	}
	/**
	 * get job by job section Id
 	 * @param string job id
     * @return object
	 */
	public function getById($id) {

		$select = $this->_db->select()
			->from(array('section' => 'section'))
            ->joinInner(array('category' => 'category'), 'category.category_id = category.category_id')
			->where('section.section_id = ?', $id)			
			->limit(1);		

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;		
	}	
	/**
	 * get job by job section Id
 	 * @param string job id
     * @return object
	 */
	public function getByCategory($category) {

		$select = $this->_db->select()
			->from(array('section' => 'section'))
            ->joinInner(array('category' => 'category'), 'section.category_id = category.category_id')
			->where('section.category_id = ?', $category);	

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;		
	}	
	/**
	 * get job by job template Id
 	 * @param string job id
     * @return object
	 */
	public function paginate($start, $length, $filter = array()) {
	
		$where	= 'section.section_deleted = 0';
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
							$where .= "lower(section.section_name) like lower('%$text%')";
							if(($s+1) != count($array)) {
								$where .= ' or ';
							}
						}
					}
					$where .= ")";
				} else if(isset($filter[$i]['filter_section']) && trim($filter[$i]['filter_section']) != '') {
                    $text = trim($filter[$i]['filter_section']);
                    $this->sanitize($text);
                    $where .= " and section.statementsection_id = $text";
				}
			}
		}

		$select = $this->_db->select()
			->from(array('section' => 'section'))
            ->joinInner(array('category' => 'category'), 'category.category_id = section.category_id', array('category_name'))
			->where($where)				
			->order('section_name desc');

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