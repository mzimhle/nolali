<?php
require_once '_comm.php';
//custom member item class as member table abstraction
class class_participant extends Zend_Db_Table_Abstract {
	//declare table variables
    protected $_name    = 'participant';
	protected $_primary = 'participant_id';

	public	$_comm		= null;
	public	$_config    = null;
    public	$_entity   = null;

	function init()	{
		global $zfsession;
		$this->_config	= $zfsession->config;
        $this->_entity	= $zfsession->entity;
	}
	/**
	 * Update the database record
	 * example: $table->update($data, $where);
	 * @param query string $where
	 * @param array $data
     * @return boolean
	 */
    public function insert(array $data) {
        // add a timestamp	
		$data['participant_added']  = date('Y-m-d H:i:s');
        $data['entity_id']			= $this->_entity;
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
        $data['participant_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	/**
	 * get job by job participant Id
 	 * @param string job id
     * @return object
	 */
	public function getById($id) {

		$select = $this->_db->select()
			->from(array('participant' => 'participant'))
			->joinInner(array('entity' => 'entity'), 'entity.entity_id = participant.entity_id')
			->where('participant.participant_id = ?', $id)
            ->where('participant.participant_deleted = 0 and participant.entity_id = ?', $this->_entity)
			->limit(1);

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;		
	}	
	/**
	 * get job by job link Id
 	 * @param string job id
     * @return object
	 */
	public function paginate($start, $length, $filter = array()) {

		$where	= 'participant.participant_id is not null';

		if(count($filter) > 0) {
			for($i = 0; $i < count($filter); $i++) {
				if(isset($filter[$i]['filter_search']) && trim($filter[$i]['filter_search']) != '') {
					$array = explode(" ",trim($filter[$i]['filter_search']));					
					if(count($array) > 0) {
						$where .= " and (";
						for($s = 0; $s < count($array); $s++) {
							$text = $array[$s];
							$this->sanitize($text);
							$where .= "lower(concat_ws(participant.participant_name, ' ', participant.participant_email, ' ', participant.participant_cellphone)) like lower('%$text%')";
							if(($s+1) != count($array)) {
								$where .= ' or ';
							}
						}
					}
					$where .= ")";
				} else if(isset($filter[$i]['filter_csv']) && trim($filter[$i]['filter_csv']) != '') {
					$text = trim($filter[$i]['filter_csv']);
					$this->sanitize($text);
					$type = $text;		
				}
			}
		}

		$select = $this->_db->select()
			->from(array('participant' => 'participant'))
			->joinInner(array('entity' => 'entity'), 'entity.entity_id = participant.entity_id', array('entity_name'))
            ->where('participant.participant_deleted = 0 and participant.entity_id = ?', $this->_entity)
			->where($where);

		$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");
		$result = $this->_db->fetchAll($select . " limit $start, $length");
		return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);
	}
	
	/**
	 * get job by job link Id
 	 * @param string job id
     * @return object
	 */
	public function getCSV($filter = array()) {

		$where	= 'participant.participant_deleted = 0';
        $type   = '';

		if(count($filter) > 0) {
			for($i = 0; $i < count($filter); $i++) {
				if(isset($filter[$i]['filter_search']) && trim($filter[$i]['filter_search']) != '') {
					$array = explode(" ",trim($filter[$i]['filter_search']));					
					if(count($array) > 0) {
						$where .= " and (";
						for($s = 0; $s < count($array); $s++) {
							$text = $array[$s];
							$this->sanitize($text);
							$where .= "lower(concat_ws(participant.participant_name, ' ', participant.participant_email, ' ', participant.participant_cellphone)) like lower('%$text%')";
							if(($s+1) != count($array)) {
								$where .= ' or ';
							}
						}
					}
					$where .= ")";
				} else if(isset($filter[$i]['filter_csv']) && trim($filter[$i]['filter_csv']) != '') {
					$text = trim($filter[$i]['filter_csv']);
					$this->sanitize($text);
					$type = $text;		
				}
			}
		}

		$select = $this->_db->select()
			->from(array('participant' => 'participant'))
			->joinInner(array('entity' => 'entity'), 'entity.entity_id = participant.entity_id')
            ->where('participant.participant_deleted = 0 and participant.entity_id = ?', $this->_entity)
			->where($where);
        $result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
	}

    function download_send_headers($filename) {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download  
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }

	/**
	 * get job by job participant Id
 	 * @param string job id
     * @return object
	 */	
	public function search($query, $limit = 20) {

		$select = $this->_db->select()
			->from(array('participant' => 'participant'))
			->joinInner(array('entity' => 'entity'), 'entity.entity_id = participant.entity_id')
            ->where('participant.participant_deleted = 0 and participant.entity_id = ?', $this->_entity)
			->where("participant_deleted = 0 and lower(concat(participant_name, participant_email, participant_cellphone)) like lower(?)", "%$query%")
			->limit($limit)
			->order("LOCATE('$query', concat_ws(participant_name, participant_email, participant_cellphone))");

		$result = $this->_db->fetchAll($select);	
        return ($result == false) ? false : $result = $result;					
	}

	/**
	 * get job by job participant Id
 	 * @param string job id
     * @return object
	 */
	public function getByCell($cell, $id = null) {
		if($id == null) {
            $select = $this->_db->select()
                ->from(array('participant' => 'participant'))
                ->joinInner(array('entity' => 'entity'), 'entity.entity_id = participant.entity_id')
                ->where('participant.participant_deleted = 0 and participant.entity_id = ?', $this->_entity)
                ->where('participant_cellphone = ?', $cell)
                ->limit(1);
		} else {
            $select = $this->_db->select()
                ->from(array('participant' => 'participant'))
                ->joinInner(array('entity' => 'entity'), 'entity.entity_id = participant.entity_id')
                ->where('participant.participant_deleted = 0 and participant.entity_id = ?', $this->_entity)
                ->where('participant_cellphone = ?', $cell)
				->where('participant_deleted = 0 and participant_id != ?', $id)
				->limit(1);		
		}

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;
	}	
	/**
	 * get job by job participant Id
 	 * @param string job id
     * @return object
	 */
	public function getByEmail($email, $id = null) {
		if($id == null) {
            $select = $this->_db->select()
                ->from(array('participant' => 'participant'))
                ->joinInner(array('entity' => 'entity'), 'entity.entity_id = participant.entity_id')
                ->where('participant.participant_deleted = 0 and participant.entity_id = ?', $this->_entity)
				->where('participant_deleted = 0 and participant_email = ?', $email)
				->limit(1);
		} else {
            $select = $this->_db->select()
                ->from(array('participant' => 'participant'))
                ->joinInner(array('entity' => 'entity'), 'entity.entity_id = participant.entity_id')
                ->where('participant.participant_deleted = 0 and participant.entity_id = ?', $this->_entity)
				->where('participant_email = ?', $email)
				->where('participant_deleted = 0 and participant_id != ?', $id)
				->limit(1);		
		}

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;
	}

	public function validateEmail($string) {
		if(!filter_var($string, FILTER_VALIDATE_EMAIL)) {
			return '';
		} else {
			return trim($string);
		}
	}
	
	public function validateNumber($string) {
        // validate.
		if(preg_match('/^0[0-9]{9}$/', $this->onlyNumber(trim($string)))) {
			return $this->onlyNumber(trim($string));
		} else {
			return '';
		}
	}
	
	public function onlyNumber($string) {
		/* Remove some weird charactors that windows dont like. */
		$string = strtolower($string);
		$string = str_replace(' ' , '' , $string);
		$string = str_replace('__' , '' , $string);
		$string = str_replace(' ' , '' , $string);
		$string = str_replace("`", "", $string);
		$string = str_replace("/", "", $string);
		$string = str_replace("\\", "", $string);
		$string = str_replace("'", "", $string);
		$string = str_replace("(", "", $string);
		$string = str_replace(")", "", $string);
		$string = str_replace("-", "", $string);
		$string = str_replace(".", "", $string);
		$string = str_replace('___' , '' , $string);
		$string = str_replace('__' , '' , $string);	 
		$string = str_replace(' ' , '' , $string);
		$string = str_replace('__' , '' , $string);
		$string = str_replace(' ' , '' , $string);
		$string = str_replace("`", "", $string);
		$string = str_replace("/", "", $string);
		$string = str_replace("\\", "", $string);
		$string = str_replace("'", "", $string);
		$string = str_replace("(", "", $string);
		$string = str_replace(")", "", $string);
		$string = str_replace("-", "", $string);
		$string = str_replace(".", "", $string);
		$string = str_replace("–", "", $string);	
		$string = str_replace("#", "", $string);	
		$string = str_replace("$", "", $string);	
		$string = str_replace("@", "", $string);	
		$string = str_replace("!", "", $string);	
		$string = str_replace("&", "", $string);	
		$string = str_replace(';' , '' , $string);		
		$string = str_replace(':' , '' , $string);		
		$string = str_replace('[' , '' , $string);		
		$string = str_replace(']' , '' , $string);		
		$string = str_replace('|' , '' , $string);		
		$string = str_replace('\\' , '' , $string);		
		$string = str_replace('%' , '' , $string);	
		$string = str_replace(';' , '' , $string);		
		$string = str_replace(' ' , '' , $string);
		$string = str_replace('__' , '' , $string);
		$string = str_replace(' ' , '' , $string);	
		$string = str_replace('-' , '' , $string);	
		$string = str_replace('+27' , '0' , $string);	
		$string = str_replace('(0)' , '' , $string);	
		$string = preg_replace('/^00/', '0', $string);
		$string = preg_replace('/^27/', '0', $string);
		$string = preg_replace('!\s+!',"", strip_tags($string));
		return $string;
	}

    function sanitize(&$string) { $string = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $string);}
    function sanitizeArray(&$array) { for($i = 0; $i < count($array); $i++) { $array[$i] = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $array[$i]); } }
	
	function cleanString($string) {
		//Lower case everything
		$string = strtoupper($string);
		//Make alphanumeric (removes all other characters)
		$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
		//Clean up multiple dashes or whitespaces
		$string = preg_replace("/[\s-]+/", " ", $string);
		//Convert whitespaces and underscore to dash
		$string = preg_replace("/[\s_]/", "-", $string);
		return $string;
	}	
}
?>