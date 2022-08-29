<?php
//custom recruiter item class as recruiter table abstraction
class class_company extends Zend_Db_Table_Abstract {
   //declare table variables
    protected $_name 		= 'company';
	protected $_primary 	= 'company_id';

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	 public function insert(array $data) {
        // add a timestamp
        $data['company_added'] = date('Y-m-d H:i:s');
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
        $data['company_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	/**
	 * get job by job company Id
 	 * @param string job id
     * @return object
	 */
	public function pairs() {

		$select = $this->_db->select()
			->from(array('company' => 'company'), array('company_id', 'company_name'))
			->where('company_deleted = 0');

		$result = $this->_db->fetchPairs($select);
		return ($result == false) ? false : $result = $result;		
	}
	/**
	 * get job by job company Id
 	 * @param string job id
     * @return object
	 */
	public function getById($id) {

		$select = $this->_db->select()
			->from(array('company' => 'company'))
			->where('company_deleted = 0 and company.company_id = ?', $id)
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
	
		$where	= 'company_deleted = 0';
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
							$where .= "lower(company_name) like lower('%$text%')";
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
			->from(array('company' => 'company'))
			->where($where)
			->order('company_name desc');

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
	public function search($query, $limit = 20) {

		$select = $this->_db->select()
			->from(array('company' => 'company'))
			->where("company_deleted = 0 and lower(concat(company_name, company_address)) like lower(?)", "%$query%")
			->limit($limit)
			->order("LOCATE('$query', concat_ws(company_name, company_address))");

		$result = $this->_db->fetchAll($select);	
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

	function createCode() {
		/* New id. */
		$id = "";
		$Alphabet 	= "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		/* First two Alphabets. */
		$count = strlen($Alphabet) - 1;
		for($i=0;$i<3;$i++){
			$id .= $Alphabet[rand(0,$count)];
		}
		return $id;
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
}
?>