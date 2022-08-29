<?php
require_once 'invoiceitem.php';
//custom recruiter item class as recruiter table abstraction
class class_invoicemonthly extends Zend_Db_Table_Abstract {
   //declare table variables
    protected $_name 		= 'invoicemonthly';
	protected $_primary 	= 'invoicemonthly_id';

	public $_PDFCROWD	    = null;
	public $_entity    		= null;
    public $_activeEntity	= null;
	public $_invoiceitem   	= null;

	
	function init()	{
		global $zfsession;
		$this->_invoiceitem		= new class_invoiceitem();
		$this->_entity			= isset($zfsession->entity) ? $zfsession->entity : null;
        $this->_activeEntity	= isset($zfsession->activeEntity) ? $zfsession->activeEntity : null;
		$this->_vat         	= isset($zfsession->config['vat']) ? $zfsession->config['vat'] : null;
	} 
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	 public function insert(array $data) {
        // add a timestamp
        $data['invoicemonthly_added']	= date('Y-m-d H:i:s');
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
        $data['invoicemonthly_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	/**
	 * get job by job invoicemonthly Id
 	 * @param string job id
     * @return object
	 */
	public function getById($id) {

		$select = $this->_db->select()
			->from(array('invoicemonthly' => 'invoicemonthly'))
            ->joinInner(array('entity' => 'entity'), 'entity.entity_id = invoicemonthly.entity_id')
			->joinInner(array('bankentity' => 'bankentity'), 'bankentity.bankentity_id = invoicemonthly.bankentity_id')
            ->joinInner(array('participant' => 'participant'), 'participant.participant_id = invoicemonthly.participant_id')
			->where('invoicemonthly_deleted = 0 and invoicemonthly.entity_id = ?', $this->_entity)
			->where('invoicemonthly.invoicemonthly_id = ?', $id)
			->limit(1);		

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;		
	}
	/**
	 * get job by job invoicemonthly Id
 	 * @param string job id
     * @return object
	 */
	public function getForTodayList() {

		$today		= (int)date('d');
		$lastday	= (int)date("t");

		$itemtotal = $this->_db->select()
			->from(array('invoiceitem' => 'invoiceitem'), array('invoicemonthly_id', 'invoice_amount_total' => new Zend_Db_Expr('SUM(IFNULL(invoiceitem_amount_total, 0))')))
			->where('invoiceitem_deleted = 0')
			->group('invoiceitem.invoicemonthly_id');

		$select = $this->_db->select()
			->from(array('invoicemonthly' => 'invoicemonthly'))
            ->joinInner(array('entity' => 'entity'), 'entity.entity_id = invoicemonthly.entity_id')
			->joinInner(array('bankentity' => 'bankentity'), 'bankentity.bankentity_id = invoicemonthly.bankentity_id')
            ->joinInner(array('participant' => 'participant'), 'participant.participant_id = invoicemonthly.participant_id')
			->joinLeft(array('invoiceitem' => $itemtotal), 'invoiceitem.invoicemonthly_id = invoicemonthly.invoicemonthly_id', array('invoice_amount_total'))
			->joinLeft(array('invoice' => 'invoice'), "invoice.invoicemonthly_id = invoicemonthly.invoicemonthly_id and invoice_type = 'MONTHLY' and template_code = 'INVOICE'", array())
			->where("invoicemonthly_deleted = 0 and DAYOFMONTH(invoicemonthly_date) = $today or ($today = $lastday and DAYOFMONTH(invoicemonthly_date) > $lastday)")
			->where("invoice.invoice_id = null or invoice.invoice_id is null or invoice.invoice_id = ''");

		$result = $this->_db->fetchAll($select);
		
		if($result) {
			for($i = 0; $i < count($result); $i++) {
				$item = $this->_invoiceitem->getByMonthlyInvoice($result[$i]['invoicemonthly_id']);
				$result[$i]['items'] = $item !== false ? $item : array();
			}
		}
		return ($result == false) ? false : $result = $result;
	}
	/**
	 * get job by job template Id
 	 * @param string job id
     * @return object
	 */
	public function paginateInvoices($start, $length, $filter = array()) {
	
		$where	= 'invoice_deleted = 0';

		if(count($filter) > 0) {
			for($i = 0; $i < count($filter); $i++) {
				if(isset($filter[$i]['filter_search']) && trim($filter[$i]['filter_search']) != '') {
					$array = explode(" ",trim($filter[$i]['filter_search']));					
					if(count($array) > 0) {
						$where .= " and (";
						for($s = 0; $s < count($array); $s++) {
							$text = $array[$s];
							$this->sanitize($text);
							$where .= "lower(participant_name, participant_surname) like lower('%$text%')";
							if(($s+1) != count($array)) {
								$where .= ' or ';
							}
						}
					}
					$where .= ")";
				} else if(isset($filter[$i]['filter_monthly']) && trim($filter[$i]['filter_monthly']) != '') {
					$text = trim($filter[$i]['filter_monthly']);
					$this->sanitize($text);
					$where .= " and invoice.invoicemonthly_id = $text";
				}
			}
		}

		$itemtotal = $this->_db->select()
			->from(array('invoiceitem' => 'invoiceitem'), array('invoicemonthly_id', 'invoice_amount_total' => new Zend_Db_Expr('SUM(IFNULL(invoiceitem_amount_total, 0))')))
			->where('invoiceitem_deleted = 0')
			->group('invoicemonthly_id');

		$paymenttotal = $this->_db->select()
			->from(array('statement' => 'statement'), array('invoice_id', 'invoice_amount_paid' => new Zend_Db_Expr('SUM(IFNULL(statement.statement_amount, 0))')))
			->where('statement_deleted = 0')
			->group('invoice_id');

		$select = $this->_db->select()	
			->from(array('invoice' => 'invoice'))
			->joinInner(array('participant' => 'participant'), "participant.participant_id = invoice.participant_id", array('participant_name', 'participant_surname', 'participant_email', 'participant_cellphone'))
			->joinInner(array('entity' => 'entity'), "entity.entity_id = participant.entity_id", array())
			->joinInner(array('invoicemonthly' => 'invoicemonthly'), "invoicemonthly.invoicemonthly_id = invoice.invoicemonthly_id", array())
			->joinLeft(array('invoiceitem' => $itemtotal), 'invoiceitem.invoicemonthly_id = invoice.invoicemonthly_id', array('invoice_amount_total'))
			->joinLeft(array('statement' => $paymenttotal), 'statement.invoice_id = invoice.invoice_id', array('invoice_amount_paid', 'invoice_amount_due' => new Zend_Db_Expr('IFNULL(invoice_amount_total, 0) - IFNULL(invoice_amount_paid, 0)')))
			->where('entity_deleted = 0 and participant_deleted = 0 and invoice_deleted = 0 and invoicemonthly_deleted = 0')
			->where($where)
			->group('invoice.invoice_id');	

		$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");
		$result = $this->_db->fetchAll($select . " limit $start, $length");
		return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);
	}	
	/**
	 * get job by job template Id
 	 * @param string job id
     * @return object
	 */
	public function paginate($start, $length, $filter = array()) {
	
		$where	= 'invoicemonthly_deleted = 0';
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
							$where .= "lower(participant_name, participant_surname) like lower('%$text%')";
							if(($s+1) != count($array)) {
								$where .= ' or ';
							}
						}
					}
					$where .= ")";
				}
			}
		}

		$itemtotal = $this->_db->select()
			->from(array('invoiceitem' => 'invoiceitem'), array('invoicemonthly_id', 'invoice_amount_total' => new Zend_Db_Expr('SUM(IFNULL(invoiceitem_amount_total, 0))')))
			->where('invoiceitem_deleted = 0')
			->group('invoiceitem.invoicemonthly_id');

		$select = $this->_db->select()
			->from(array('invoicemonthly' => 'invoicemonthly'))
            ->joinInner(array('entity' => 'entity'), 'entity.entity_id = invoicemonthly.entity_id', array())
			->joinInner(array('bankentity' => 'bankentity'), 'bankentity.bankentity_id = invoicemonthly.bankentity_id', array('bankentity_name'))
            ->joinInner(array('participant' => 'participant'), 'participant.participant_id = invoicemonthly.participant_id', array('participant_name', 'participant_surname', 'participant_email', 'participant_cellphone'))
			->joinLeft(array('invoiceitem' => $itemtotal), 'invoiceitem.invoicemonthly_id = invoicemonthly.invoicemonthly_id', array('invoice_amount_total'))
			->where("invoicemonthly_deleted = 0");

		if($csv) {
			$result = $this->_db->fetchAll($select);
			return ($result == false) ? false : $result = $result;	
		} else {
			$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");
			$result = $this->_db->fetchAll($select . " limit $start, $length");
			return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);
		}
	}	

	public function validateDate($string) {
		if(preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $string)) {
			if(date('Y-m-d', strtotime($string)) != $string) {
				return '';
			} else {
				return $string;
			}
		} else {
			return '';
		}
	}
	
    function sanitize(&$string) { $string = preg_replace("/[^a-zA-Z0-9_]+/", "", $string);}
    function sanitizeArray(&$array) { for($i = 0; $i < count($array); $i++) { $array[$i] = preg_replace("/[^a-zA-Z0-9_]+/", "", $array[$i]); } }	
}
?>