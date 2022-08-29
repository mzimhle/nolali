<?php
//custom recruiter item class as recruiter table abstraction
class class_content extends Zend_Db_Table_Abstract {
   //declare table variables
    protected $_name 		= 'content';
	protected $_primary 	= 'content_id';

	public $_entity    = null;
	
	function init()	{
		global $zfsession;
		$this->_entity = $zfsession->entity;     
	}

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	 public function insert(array $data) {
        // add a timestamp
        $data['content_added']	= date('Y-m-d H:i:s');
        $data['entity_id']		= $this->_entity;       
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
        $data['content_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	/**
	 * get job by job content Id
 	 * @param string job id
     * @return object
	 */
	public function getById($id) {

		$select = $this->_db->select()
			->from(array('content' => 'content'))
			->joinInner(array('entity' => 'entity'), "entity_deleted = 0 and entity.entity_id = content.entity_id")
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and content.content_id = media.media_item_id and media.media_item_type = 'CONTENT' and media.media_primary = 1 and media.media_active = 1", array('media_code', 'media_path', 'media_ext'))
			->where('content_deleted = 0 and content.entity_id = ?', $this->_entity)
			->where('content.content_id = ?', $id)
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
	
		$where	= 'content_deleted = 0';

		if(count($filter) > 0) {
			for($i = 0; $i < count($filter); $i++) {
				if(isset($filter[$i]['filter_search']) && trim($filter[$i]['filter_search']) != '') {
					$array = explode(" ",trim($filter[$i]['filter_search']));					
					if(count($array) > 0) {
						$where .= " and (";
						for($s = 0; $s < count($array); $s++) {
							$text = $array[$s];
							$this->sanitize($text);
							$where .= "lower(content_name) like lower('%$text%')";
							if(($s+1) != count($array)) {
								$where .= ' or ';
							}
						}
					}
					$where .= ")";
				} else if(isset($filter[$i]['filter_type']) && trim($filter[$i]['filter_type']) != '') {
                    $text = trim($filter[$i]['filter_type']);
                    $this->sanitize($text);
                    $text = "'".str_replace(',', "','", $text)."'";
                    $where .= " and content_type in($text)";
				}
			}
		}
        
		$select = $this->_db->select()
			->from(array('content' => 'content'))
			->joinInner(array('entity' => 'entity'), "entity_deleted = 0 and entity.entity_id = content.entity_id", array('entity_name'))
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and content.content_id = media.media_item_id and media.media_item_type = 'CONTENT' and media.media_primary = 1 and media.media_active = 1", array('media_code', 'media_path', 'media_ext'))
			->where('content_deleted = 0 and content.entity_id = ?', $this->_entity)          
			->where($where)
			->order('content_name desc');

		$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");
		$result = $this->_db->fetchAll($select . " limit $start, $length");
		return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);
	}
	
    function sanitize(&$string) { $string = preg_replace("/[^a-zA-Z0-9_,]+/", "", $string);}
    function sanitizeArray(&$array) { for($i = 0; $i < count($array); $i++) { $array[$i] = preg_replace("/[^a-zA-Z0-9_]+/", "", $array[$i]); } }	
}
?>