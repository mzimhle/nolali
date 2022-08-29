<?php
require_once '_comm.php';
//custom recruiter item class as recruiter table abstraction
class class_entity extends Zend_Db_Table_Abstract {
   //declare table variables
    protected $_name 		= 'entity';
	protected $_primary 	= 'entity_id';
	
	public	$_account	= null;
	public	$_config	= null;

	function init()	{
		global $zfsession;
		$this->_comm = new class_comm();
		$this->_activeAccount = isset($zfsession->activeAccount) ? $zfsession->activeAccount : null;
		$this->_account = $zfsession->activeAccount['account_id'];
		$this->_where = isset($this->_activeAccount['account_type']) ? ($this->_activeAccount['account_type'] == 'SUPER' ? 'entity.account_id is not null' : 'entity.account_id = '.$zfsession->activeAccount['account_id']) : null;	
	}

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	public function insert(array $data) {
        // add a timestamp
        $data['entity_added']	= date('Y-m-d H:i:s');
        $data['entity_code']  	= $this->createCode();
		$data['account_id']  	= $this->_account;
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
        $data['entity_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	/**
	 * get domain by domain Municipality Id
 	 * @param string domain id
     * @return object
	 */
	public function pairs() {

		$select = $this->_db->select()
			->from(array('entity' => 'entity'), array('entity_id', 'entity_name'))
			->where($this->_where);			

		$result = $this->_db->fetchPairs($select);
        return ($result == false) ? false : $result = $result;					   
	}
	/**
	 * get domain by domain Municipality Id
 	 * @param string domain id
     * @return object
	 */
	public function getByAccount($id) {

		$select = $this->_db->select()
			->from(array('entity' => 'entity'), array('entity_id', 'entity_name'))
			->joinInner(array('account' => 'account'), "account.account_id = entity.account_id", array())
			->where("account_type = 'ADMIN' and account.account_id = ?", $id);

		$result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;					   
	}	
	/**
	 * get job by job entity Id
 	 * @param string job id
     * @return object
	 */
	public function getById($id) {

		// Invoice total amounts paid, already paid, pending amount
		$invoicepaid = $this->_db->select()
			->from(array('invoice' => 'invoice'), array('entity_id'))
			->joinInner(array('statement' => 'statement'), "statement.invoice_id = invoice.invoice_id and statement_deleted = 0", array('invoice_amount_paid' => new Zend_Db_Expr('SUM(statement_amount)')))
			->where('invoice.entity_id = ?', $id);

		$invoice = $this->_db->select()
			->from(array('invoice' => 'invoice'), array('entity_id'))
			->joinInner(array('invoiceitem' => 'invoiceitem'), "invoiceitem.invoice_id = invoice.invoice_id and invoiceitem_deleted = 0", array())
			->joinInner(array('price' => 'price'), "price.price_id = invoiceitem.price_id and price_deleted = 0", array('invoice_amount_total' => new Zend_Db_Expr('SUM(ifnull(price_amount*invoiceitem_quantity,0))'), 'invoice_amount_unpaid' => new Zend_Db_Expr('SUM(ifnull(price_amount*invoiceitem_quantity,0))-ifnull(invoice_amount_paid,0)')))
			->joinLeft(array('invoicepaid' => $invoicepaid), 'invoicepaid.entity_id = invoice.entity_id', array('invoice_amount_paid'))
			->where('invoice.entity_id = ?', $id)
			->group('invoice.entity_id');

		$sectionstotal = $this->_db->select()
			->from(array('statement' => 'statement'), array('entity_id', 'section_amount_negetive' => new Zend_Db_Expr('SUM(if(0 > IFNULL(statement_amount, 0), IFNULL(statement_amount, 0), 0))'), 'section_amount_positive' => new Zend_Db_Expr('SUM(if(0 <= IFNULL(statement_amount, 0), IFNULL(statement_amount, 0), 0))')))
			->where('statement_deleted = 0 and statement_active = 1')
			->where('statement.entity_id = ?', $id)
			->group(array('statement.entity_id'));

		$select = $this->_db->select()
			->from(array('entity' => 'entity'))
			->joinInner(array('account' => 'account'), "account.account_id = entity.account_id and entity_deleted = 0")
			->joinLeft(array('invoice' => $invoice), 'invoice.entity_id = entity.entity_id', array('invoice_amount_total', 'invoice_amount_paid', 'invoice_amount_unpaid'))
			->joinLeft(array('sectionstotal' => $sectionstotal), 'sectionstotal.entity_id = entity.entity_id', array('section_amount_negetive', 'section_amount_positive', 'section_amount_left' => new Zend_Db_Expr('IFNULL(section_amount_positive, 0) - IFNULL(section_amount_negetive, 0)')))
			->where('entity_deleted = 0 and entity.entity_id = ?', $id)
			->where($this->_where)	
			->limit(1);		

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;		
	}
	/**
	 * get domain by domain Municipality Id
 	 * @param string domain id
     * @return object
	 */	
	public function paginate($start, $length, $filter = array()) {
	
		$where	= 'entity_id is not null';
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
							$where .= "concat(entity_name, ' ', entity_code) like lower('%$text%')";
							if(($s+1) != count($array)) {
								$where .= ' or ';
							}
						}
					}
					$where .= ")";
				} else if(isset($filter[$i]['filter_csv']) && (int)trim($filter[$i]['filter_csv']) == 1) {
					$csv = 1;
				}
			}
		}

		$select = $this->_db->select()
			->from(array('entity' => 'entity'))	
			->where('entity_deleted = 0')
			->where($this->_where)	
			->where($where);

		$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");
		$result = $this->_db->fetchAll($select . " limit $start, $length");
		return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);
	}


	/**
	 * get job by job entity Id
 	 * @param string job id
     * @return object
	 */	
	public function search($query, $limit = 20) {

		$select = $this->_db->select()
			->from(array('entity' => 'entity'))
            ->where('entity.entity_active = 1 and entity.entity_deleted = 0 and entity.account_id = ?', $this->_account)
			->where("lower(concat(entity_name, entity_contact_email, entity_contact_cellphone)) like lower(?)", "%$query%")
			->limit($limit)
			->order("LOCATE('$query', concat_ws(entity_name, entity_contact_email, entity_contact_cellphone))");

		$result = $this->_db->fetchAll($select);	
        return ($result == false) ? false : $result = $result;					
	}	
    
	/**
	 * get job by job entity Id
 	 * @param string job id
     * @return object
	 */
	public function getByCell($cell, $id = null) {
		if($id == null) {
            $select = $this->_db->select()
                ->from(array('entity' => 'entity'))
                ->where('entity.entity_deleted = 0 and entity_contact_cellphone = ?', $cell)
                ->limit(1);
		} else {
            $select = $this->_db->select()
                ->from(array('entity' => 'entity'))
                ->where('entity_contact_cellphone = ?', $cell)
				->where('entity_deleted = 0 and entity_id != ?', $id)
				->limit(1);		
		}

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;
	}	
	/**
	 * get job by job entity Id
 	 * @param string job id
     * @return object
	 */
	public function getByEmail($email, $id = null) {
		if($id == null) {
            $select = $this->_db->select()
                ->from(array('entity' => 'entity'))
				->where('entity_deleted = 0 and entity_contact_email = ?', $email)
				->limit(1);
		} else {
            $select = $this->_db->select()
                ->from(array('entity' => 'entity'))
				->where('entity_contact_email = ?', $email)
				->where('entity_deleted = 0 and entity_id != ?', $id)
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