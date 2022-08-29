<?php

//custom company item class as company table abstraction
class class_template extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected 	$_name	    = 'template';
	public		$_primary   = 'template_id';
	
	function init()	{
		global $zfsession;
        $this->_account = isset($zfsession->activeEntity) ? $zfsession->activeEntity['account_id'] : $zfsession->account;
		$this->_entity  = isset($zfsession->activeEntity) ? $zfsession->activeEntity['entity_id'] : null;
        $this->_where   = $this->_entity != null ? "entity_id = ".$this->_entity." and account_id = ".$this->_account : "account_id = ".$zfsession->account." and entity_id is null or entity_id = ''";	
	}
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */
	public function insert(array $data) {
        // add a timestamp
        $data['template_added']	= date('Y-m-d H:i:s');				
        $data['account_id']	    = $this->_account;
        $data['entity_id']	    = $this->_entity;		
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
        $data['template_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	/**
	 * get job by job template Id
 	 * @param string job id
     * @return object
	 */
	public function getById($id) {
		$select = $this->_db->select()	
			->from(array('template' => 'template'))
			->where('template_id = ?', $id)
            ->where($this->_where)
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
	
		$where	= 'template_deleted = 0';
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
							$where .= "lower(template_code) like lower('%$text%')";
							if(($s+1) != count($array)) {
								$where .= ' or ';
							}
						}
					}
					$where .= ")";
				}
			}
		}

		$select = $this->_db->select()
			->from(array('template' => 'template'))
			->where($where)
            ->where($this->_where)
			->order('template_code desc');

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
	 * get job by job template Id
 	 * @param string job id
     * @return object
	 */	
	public function getTemplate($category, $code, $id = null) {
        if($id == null) {
            $select = $this->_db->select()	
                ->from(array('template' => 'template'))
                ->where("template_category = ?", $category)
                ->where($this->_where)
                ->where("template_deleted = 0 and template_code = ?", $code)
                ->limit(1);
        } else {
            $select = $this->_db->select()
                ->from(array('template' => 'template'))
                ->where("template_category = ?", $category)
                ->where("template_code = ?", $code)
                ->where($this->_where)
                ->where("template_deleted = 0 and template_id != ?", $id)
                ->limit(1);
        }

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;
	}

    function sanitize(&$string) { $string = preg_replace("/[^a-zA-Z0-9_]+/", "", $string);}
    function sanitizeArray(&$array) { for($i = 0; $i < count($array); $i++) { $array[$i] = preg_replace("/[^a-zA-Z0-9_]+/", "", $array[$i]); } }
}
?>