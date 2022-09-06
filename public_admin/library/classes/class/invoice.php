<?php
require_once 'pdfcrowd/pdfcrowd.php';
require_once 'template.php';
require_once 'PDF.php';

//custom entity item class as entity table abstraction
class class_invoice extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected	$_name 		= 'invoice';
	protected	$_primary	= 'invoice_id';

	public $_PDFCROWD       = null;
	public $_entity         = null;
    public $_activeEntity   = null;
	public $_template       = null;
	public $_where          = null;
	
	function init()	{
		global $zfsession;
		$this->_entity			= isset($zfsession->entity) ? $zfsession->entity : 0;
		$this->_account			= isset($zfsession->activeEntity) ? $zfsession->activeEntity['account_id'] : $zfsession->account;        
        $this->_activeEntity	= isset($zfsession->activeEntity) ? $zfsession->activeEntity : null;
		$this->_path         	= isset($zfsession->config) ? $zfsession->config['path'] : null;
		$this->_site         	= isset($zfsession->config) ? $zfsession->config['site'] : null;

        $this->_PDFCROWD		= new CLASS_PDFCROWD();
		$this->_template    	= new class_template();
        
        $this->_where           = isset($zfsession->entity) ? 'participant.entity_id = '.$zfsession->entity : 'entity.entity_deleted = 0';
	} 
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */
    public function insert(array $data) {
        // add a timestamp
        $data['invoice_added']  = isset($data['invoice_added']) ? $data['invoice_added'] : date('Y-m-d H:i:s');
        $data['invoice_code']	= isset($data['invoice_code']) ? $data['invoice_code'] : $this->createCode();
        $data['account_id']     = $this->_account;
        $data['entity_id']      = $this->_entity;        
		return parent::insert($data);	
    }
	/**
	 * Update the database record
	 * example: $table->update($data, $where);
	 * @param query string $where
	 * @param array $data
     * @return boolean
	 */
    public function update(array $data, $where){
        // add a timestamp
        $data['invoice_updated'] = date('Y-m-d H:i:s');
        $data['account_id'] = $this->_account;         
		return parent::update($data, $where);
    }
 
	/**
	 * Update the database record
	 * example: $table->update($data, $where);
	 * @param query string $where
	 * @param array $data
     * @return boolean
	 */
    function updateInvoice($id) {
        
        $data['invoice_file_html'] = null;        
        $data['invoice_file_pdf'] = null; 

        $where 	    = array();
        $where[]	= $this->getAdapter()->quoteInto('invoice_id = ?', $id);
        $this->update($data, $where);		

    }
    
	public function checkPayment($invoiceid) {

		$invoiceData = $this->getById($invoiceid);

		if($invoiceData) {

			$data 	= array();			

			if($invoiceData['invoice_amount_paid'] >= $invoiceData['invoice_amount_due']) {
				$data['invoice_paid'] 		= 1;				
				$data['invoice_paid_paid'] 	= date('Y-m-d H:i:s');				
			} else {
				$data['invoice_paid'] 		= 0;
				$data['invoice_paid_paid']	= date('Y-m-d H:i:s');				
			}
			
			$where	= $this->getAdapter()->quoteInto('invoice_id = ?', $invoiceData['invoice_id']);
			$this->update($data, $where);	
			return $invoiceData['invoice_id'];
		} else {
			return false;
		}
	}
	/**
	 * get job by job invoice Id
 	 * @param string job id
     * @return object
	 */
	public function getById($id) {

		$itemtotal = $this->_db->select()
			->from(array('invoiceitem' => 'invoiceitem'), array('invoice_id', 'invoice_amount_total' => new Zend_Db_Expr('SUM(IFNULL(invoiceitem_amount_total, 0))')))
			->where('invoiceitem_deleted = 0 and invoiceitem.invoice_id = ?', $id)
			->group('invoiceitem.invoice_id');

		$paymenttotal = $this->_db->select()
			->from(array('statement' => 'statement'), array('invoice_id', 'invoice_amount_paid' =>new Zend_Db_Expr('SUM(IFNULL(statement.statement_amount, 0))')))
			->where('statement_deleted = 0 and statement.invoice_id = ?', $id)
			->group('invoice_id');

		$select = $this->_db->select()	
			->from(array('invoice' => 'invoice'))
			->joinInner(array('account' => 'account'), "account.account_id = invoice.account_id", array('account_id', 'account_name', 'account_type', 'account_cellphone', 'account_email', 'account_reference'))
			->joinLeft(array('entity' => 'entity'), "entity.entity_id = invoice.entity_id and entity_deleted = 0", array( 'entity_name', 'entity_code', 'entity_contact_cellphone', 'entity_contact_email', 'entity_address_physical'))	            
			->joinLeft(array('participant' => 'participant'), "participant.participant_id = invoice.participant_id AND participant_deleted = 0", array('participant_name', 'participant_address', 'participant_email', 'participant_cellphone', 'participant_id'))
			->joinLeft(array('template' => 'template'), "template.template_category = 'TEMPLATE' and template.template_code = invoice.template_code and template_deleted = 0 and template.account_id = invoice.account_id", array('template_id', 'template_category', 'template_subject', 'template_file', 'template_message'))
			->joinLeft(array('itemtotal' => $itemtotal), 'itemtotal.invoice_id = invoice.invoice_id', array('invoice_amount_total'))
			->joinLeft(array('statement' => $paymenttotal), 'statement.invoice_id = invoice.invoice_id', array('invoice_amount_paid', 'invoice_amount_due' => new Zend_Db_Expr('IFNULL(invoice_amount_total, 0) - IFNULL(invoice_amount_paid, 0)')))
			->joinLeft(array('invoiceitem' => 'invoiceitem'), "invoiceitem.invoice_id = invoice.invoice_id and invoice.template_code = 'BOOK' and invoiceitem_deleted = 0", array('invoiceitem_date_start', 'invoiceitem_date_end', 'invoiceitem_quantity', 'invoiceitem_amount_total', 'invoiceitem_amount_unit'))
			->joinLeft(array('price' => 'price'), "price.price_id = invoiceitem.price_id and price_deleted = 0", array('price_id', 'price_amount'))
			->joinLeft(array('product' => 'product'), "product.product_id = price.product_id and product_deleted = 0", array('product_name', 'product_text'))
			->where('invoice_deleted = 0 and invoice.invoice_id = ?', $id)
            ->where('invoice.account_id = ?', $this->_account)
            ->where($this->_where)
			->group('invoice.invoice_id');

	   $result = $this->_db->fetchRow($select);
	   
	   if($result) {
            if(trim($result['entity_name']) != '') {
                $result['recipient_name'] = $result['entity_name'];
                $result['recipient_address_physical'] = $result['entity_address_physical'];
                $result['recipient_email'] = $result['entity_contact_email'];
                $result['recipient_cellphone'] = $result['entity_contact_cellphone'];
            } else {
                $result['recipient_name'] = $result['participant_name'];
                $result['recipient_address_physical'] = $result['participant_address'];
                $result['recipient_email'] = $result['participant_email'];
                $result['recipient_cellphone'] = $result['participant_cellphone'];
            }
           
			$itemsSelect = $this->_db->select()
				->from(array('invoiceitem' => 'invoiceitem'))
				->where('invoiceitem_deleted = 0 and invoiceitem.invoice_id = ?', $id);
				
			$items = $this->_db->fetchAll($itemsSelect);
			
			if($items) {
				$result['invoiceitems'] = $items;
			} else {
				$result['invoiceitems'] = array();
			}
	   }
       return ($result == false) ? false : $result = $result;
	}

	public function paginate($start, $length, $filter = array()) {

		$where			= 'invoice_deleted = 0';

		if(count($filter) > 0) {
			for($i = 0; $i < count($filter); $i++) {
				if(isset($filter[$i]['filter_search']) && trim($filter[$i]['filter_search']) != '') {
					$array = explode(" ",trim($filter[$i]['filter_search']));					
					if(count($array) > 0) {
						$where .= " and (";
						for($s = 0; $s < count($array); $s++) {
							$text = strtolower($array[$s]);
							$this->sanitize($text);
							$where .= "lower(concat_ws(',', concat(ifnull(product_name, ''),ifnull(invoice_code, ''), ifnull(participant_name, ''), ifnull(participant_cellphone, ''), ifnull(participant_email, ''), ifnull(participant_address, '')))) like lower('%$text%')";
							if(($s+1) != count($array)) {
								$where .= ' or ';
							}
						}
					}
					$where .= ")";
				} else if(isset($filter[$i]['filter_status']) && trim($filter[$i]['filter_status']) != '') {
					$text = trim($filter[$i]['filter_status']);
					$this->sanitize($text);
					$where .= " and invoice_active = '$text'";
				} else if(isset($filter[$i]['filter_item_type']) && trim($filter[$i]['filter_item_type']) != '') {
					$text = trim($filter[$i]['filter_item_type']);
					$this->sanitize($text);
					$where .= " and invoice_item_type = '$text'";
				} else if(isset($filter[$i]['filter_type']) && trim($filter[$i]['filter_type']) != '') {
					$text = trim($filter[$i]['filter_type']);
					$this->sanitize($text);
					$where .= " and invoice_type = '$text'";
				} else if(isset($filter[$i]['filter_template']) && trim($filter[$i]['filter_template']) != '') {
					$text = trim($filter[$i]['filter_template']);
					$this->sanitize($text);
					$where .= " and invoice.template_code = '$text'";                    
				} else if(isset($filter[$i]['filter_monthly']) && trim($filter[$i]['filter_monthly']) != '') {
					$text = trim($filter[$i]['filter_monthly']);
					$this->sanitize($text);
					$where .= " and invoicemonthly_id = $text";
				}
			}
		}

		$itemtotal = $this->_db->select()
			->from(array('invoiceitem' => 'invoiceitem'), array('invoice_id', 'invoice_amount_total' => new Zend_Db_Expr('SUM(IFNULL(invoiceitem_amount_total, 0))')))
			->where('invoiceitem_deleted = 0')
			->group('invoiceitem.invoice_id');

		$paymenttotal = $this->_db->select()
			->from(array('statement' => 'statement'), array('invoice_id', 'invoice_amount_paid' =>new Zend_Db_Expr('SUM(IFNULL(statement.statement_amount, 0))')))
			->where('statement_deleted = 0')
			->group('invoice_id');
 
		$select = $this->_db->select()	
			->from(array('invoice' => 'invoice'), array('invoice_code', 'invoice_id', 'invoice_added', 'template_code', 'invoice_file_html', 'invoice_file_pdf', 'invoice_text', 'invoice_paid', 'invoice_paid_paid', 'invoice_date_payment', 'invoice_type'))
			->joinLeft(array('entity' => 'entity'), "entity.entity_id = invoice.entity_id and entity_deleted = 0", array( 'entity_name', 'entity_code', 'entity_contact_cellphone', 'entity_contact_email'))
			->joinLeft(array('participant' => 'participant'), "participant.participant_id = invoice.participant_id AND participant_deleted = 0", array('participant_name', 'participant_address', 'participant_email', 'participant_cellphone', 'participant_id'))	
			->joinLeft(array('template' => 'template'), "template.template_category = 'TEMPLATE' and template.template_code = invoice.template_code and template_deleted = 0 and template.entity_id = participant.entity_id", array('template_id', 'template_category', 'template_subject', 'template_file', 'template_message'))
			->joinLeft(array('itemtotal' => $itemtotal), 'itemtotal.invoice_id = invoice.invoice_id', array('invoice_amount_total'))
			->joinLeft(array('statement' => $paymenttotal), 'statement.invoice_id = invoice.invoice_id', array('invoice_amount_paid', 'invoice_amount_due' => new Zend_Db_Expr('IFNULL(invoice_amount_total, 0) - IFNULL(invoice_amount_paid, 0)')))
			->joinLeft(array('invoiceitem' => 'invoiceitem'), "invoiceitem.invoice_id = invoice.invoice_id and invoice.template_code = 'BOOK' and invoiceitem_deleted = 0", array('invoiceitem_date_start', 'invoiceitem_date_end', 'invoiceitem_quantity', 'invoiceitem_amount_total', 'invoiceitem_amount_unit'))
			->joinLeft(array('price' => 'price'), "price.price_id = invoiceitem.price_id and price_deleted = 0", array('price_amount', 'price_quantity'))
			->joinLeft(array('product' => 'product'), "product.product_id = price.product_id and product_deleted = 0")
			->where($where)
            ->where('invoice.account_id = ?', $this->_account)
            ->where($this->_where)  
			->group('invoice.invoice_id');	

		$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");
		$result = $this->_db->fetchAll($select . " limit $start, $length");
		
		return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);
	}
	
	public function search($term, $limit = 10) {

		// Adhoc Invoices
		$invoicepaid = $this->_db->select()
			->from(array('invoice' => 'invoice'), array('invoice_id', 'invoice_type'))
			->joinInner(array('statement' => 'statement'), "statement.invoice_id = invoice.invoice_id and statement_deleted = 0", array('invoice_amount_paid' => new Zend_Db_Expr('SUM(statement_amount)')))
            ->where("invoice_deleted = 0 and invoice_deleted = 0 and invoice.invoice_type != 'MONTHLY' and invoice.entity_id = ?", $this->_entity)
			->group(array('invoice_id', 'invoice_type'));

		$invoice = $this->_db->select()	
			->from(array('invoice' => 'invoice'), array('invoice_code', 'invoice_id', 'invoice_type'))
			->joinInner(array('entity' => 'entity'), "entity.entity_id = invoice.entity_id", array('entity_name', 'entity_code'))
			->joinLeft(array('participant' => 'participant'), "participant.participant_id = invoice.participant_id AND participant_deleted = 0", array('participant_name', 'participant_address', 'participant_email', 'participant_cellphone', 'participant_id'))	
			->joinInner(array('invoiceitem' => 'invoiceitem'), "invoiceitem.invoice_id = invoice.invoice_id and invoiceitem_deleted = 0", array())
			->joinInner(array('price' => 'price'), "price.price_id = invoiceitem.price_id and price_deleted = 0", array('invoice_amount_total' => new Zend_Db_Expr('SUM(ifnull(price_amount*invoiceitem_quantity,0))'), 'invoice_amount_unpaid' => new Zend_Db_Expr('SUM(ifnull(price_amount*invoiceitem_quantity,0))-ifnull(invoice_amount_paid,0)')))
			->joinLeft(array('invoicepaid' => $invoicepaid), 'invoicepaid.entity_id = invoice.entity_id and invoicepaid.invoice_type = invoice.invoice_type and invoicepaid.invoice_id = invoice.invoice_id', array('invoice_amount_paid'))
            ->where("invoice_deleted = 0 and invoice.invoice_type != 'MONTHLY' and invoice.entity_id = ?", $this->_entity)	
			->where("lower(concat_ws(',', concat(ifnull(invoice_code, ''), ifnull(participant_name, ''), ifnull(participant_cellphone, ''), ifnull(participant_email, ''), ifnull(participant_address, '')))) like lower(?)", "%$term%")			
			->group(array('invoice_id', 'invoice_type'));

		// Monthly Invoices
		$monthly_invoicepaid = $this->_db->select()
			->from(array('invoicemonthly' => 'invoicemonthly'), array('entity_id'))
			->joinInner(array('invoice' => 'invoice'), "invoice.invoice_id = invoicemonthly.invoicemonthly_id and invoicemonthly_deleted = 0", array('invoice_id', 'invoice_type'))		
			->joinInner(array('statement' => 'statement'), "statement.invoice_id = invoice.invoice_id and statement_deleted = 0", array('invoice_amount_paid' => new Zend_Db_Expr('SUM(statement_amount)')))
            ->where("invoicemonthly_deleted = 0 and invoice_deleted = 0 and invoice.invoice_type = 'MONTHLY' and invoicemonthly.entity_id = ?", $this->_entity)
			->group(array('invoice_id', 'invoice_type'));

		$monthly_invoice = $this->_db->select()
			->from(array('invoicemonthly' => 'invoicemonthly'), array())
			->joinInner(array('invoice' => 'invoice'), "invoice.invoicemonthly_id = invoicemonthly.invoicemonthly_id and invoicemonthly_deleted = 0", array('invoice_code', 'invoice_id', 'invoice_type'))
			->joinInner(array('invoice' => 'invoice'), "invoice.invoice_id = invoice.invoice_id and invoice_deleted = 0", array('invoice_name'))
			->joinInner(array('entity' => 'entity'), "entity.entity_id = invoice.entity_id", array('entity_name', 'entity_code'))	
			->joinLeft(array('participant' => 'participant'), "participant.participant_id = invoice.participant_id", array('participant_name', 'participant_address', 'participant_email', 'participant_cellphone', 'participant_id'))			
			->joinInner(array('invoiceitem' => 'invoiceitem'), "invoiceitem.invoicemonthly_id = invoice.invoicemonthly_id and invoiceitem_deleted = 0", array())
			->joinInner(array('price' => 'price'), "price.price_id = invoiceitem.price_id and price_deleted = 0", array('invoice_amount_total' => new Zend_Db_Expr('SUM(ifnull(price_amount*invoiceitem_quantity,0))'), 'invoice_amount_unpaid' => new Zend_Db_Expr('SUM(ifnull(price_amount*invoiceitem_quantity,0))-ifnull(invoice_amount_paid,0)')))
			->joinLeft(array('invoicepaid' => $monthly_invoicepaid), 'invoicepaid.entity_id = invoicemonthly.entity_id', array('invoice_amount_paid'))			
            ->where("invoice_deleted = 0 and invoice.invoice_type = 'MONTHLY' and invoicemonthly.entity_id = ?", $this->_entity)		
			->where("lower(concat(invoice_code, participant_name, participant_address, participant_cellphone)) like lower(?)", "%$term%")			
			->group(array('invoice_id', 'invoice_type'));

		$select = $this->select()
			->union(array($invoice, $monthly_invoice))
			->order("LOCATE('$term', concat_ws(',', concat(ifnull(invoice_code, ''), ifnull(participant_name, ''), ifnull(participant_cellphone, ''), ifnull(participant_email, ''), ifnull(participant_address, ''))))")
			->limit($limit);

	   $result = $this->_db->fetchAll($select);
       return ($result == false) ? false : $result = $result;
	}
	
	function checkBooking($productid, $startdate, $enddate, $id = null) {
		
		if($id == null) {
			$sql = "select 
							i.invoice_id, 
							i.invoice_code,
							ii.invoiceitem_date_start, 
							ii.invoiceitem_date_end
						from 
							invoice i,
							invoiceitem ii,
							invoice be,
							price pr
						where
							i.invoice_id = ii.invoice_id
							and i.invoice_type = 'BOOKING'
							and i.invoice_id = be.invoice_id
							and be.entity_id = {$this->_entity}
							and ii.price_id = pr.price_id
							and pr.product_id = $productid
							and i.invoice_id in(
							select 
								ii.invoice_id
							from
								invoiceitem ii,
								invoice i,
								invoice p
							where
								ii.invoice_id = i.invoice_id
								and be.invoice_id = i.invoice_id
								and be.entity_id = {$this->_entity}
								and ((invoiceitem_date_start < '$startdate 00:00:00' and invoiceitem_date_end > '$enddate 23:59:59') OR
								(invoiceitem_date_start < '$enddate 23:59:59' and invoiceitem_date_end > '$startdate 00:00:00') OR
								(invoiceitem_date_start > '$startdate 00:00:00' and invoiceitem_date_end < '$enddate 23:59:59')))";

			$result = $this->_db->fetchRow($sql);
		} else {
			$sql = "select 
							i.invoice_id, 
							i.invoice_code,
							ii.invoiceitem_date_start, 
							ii.invoiceitem_date_end
						from 
							invoice i,
							invoiceitem ii,
							participant p,
							price pr
						where
							i.invoice_id = ii.invoice_id
							and i.invoice_type = 'BOOKING'
							and i.invoice_id = be.invoice_id
							and be.entity_id = {$this->_entity}
							and ii.price_id = pr.price_id
							and pr.product_id = $productid
							and i.invoice_id in(
							select 
								ii.invoice_id
							from
								invoiceitem ii,
								invoice i,
								participant p
							where
								ii.invoice_id = i.invoice_id
								and be.invoice_id = i.invoice_id
								and be.entity_id = {$this->_entity}
								and ((invoiceitem_date_start < '$startdate 00:00:00' and invoiceitem_date_end > '$enddate 23:59:59') OR
								(invoiceitem_date_start < '$enddate 23:59:59' and invoiceitem_date_end > '$startdate 00:00:00') OR
								(invoiceitem_date_start > '$startdate 00:00:00' and invoiceitem_date_end < '$enddate 23:59:59')))
							and pr.product_id != $productid";

			$result = $this->_db->fetchRow($sql);
		}

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
		if(preg_match('/^0[0-9]{9}$/', $this->onlyNumber(trim($string)))) {
			return $this->onlyNumber(trim($string));
		} else {
			return '';
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

	/**
	 * get domain by domain Entity Id
 	 * @param string domain id
     * @return object
	 */	
	function createCode($entitycode = '') {
		/* New code. */
		$code = ($entitycode == '' ? $this->_activeEntity['entity_code'] : $entitycode).'-';
		$Alphabet 	= "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		/* First two Alphabets. */
		$count = strlen($Alphabet) - 1;
		for($i=0;$i<6;$i++){
			$code .= $Alphabet[rand(0,$count)];
		}

        $codeData = $this->getCode($code);

        if(!$codeData) {
            return $code;
        } else {
            $this->createCode();
        }
	}

    function getCode($code) {
		$select = $this->_db->select()	
			->from(array('invoice' => 'invoice'))				
			->where('invoice.invoice_code = ?', $code);

	   $result = $this->_db->fetchRow($select);
       return ($result == false) ? false : $result = $result;
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
	
	public function createInvoice($id) {

		global $smarty;

		$invoiceData = $this->getById($id);

		if($invoiceData) {
            
			$smarty->assign('invoiceData', $invoiceData);
			$smarty->assign('invoiceitemData', $invoiceData['invoiceitems']);
            
			$html = $smarty->fetch($this->_path.$invoiceData['template_file']);
			$html = str_replace('[mediapath]', $this->_site.'/media/template/'.strtolower($invoiceData['template_id']).'/media/', $html);	
			/* Save file. */ 
			$directory	= $this->_path.'/media/invoice/'.$invoiceData['invoice_id'].'/';
			$filename	= $directory.$invoiceData['invoice_code'].'.html';
			$pdffile	= $directory.$invoiceData['invoice_code'].'.pdf';

			if(!is_dir($directory)) mkdir($directory, 0777, true);	
			
			if(file_put_contents($filename, $html)) {
				
				$pdfdata 	= $this->_PDFCROWD->_PDF->convertHtml($html);
				
				if(file_put_contents($pdffile, $pdfdata)) {
					$data = array();
					$data['invoice_file_html'] 	= '/media/invoice/'.$invoiceData['invoice_id'].'/'.$invoiceData['invoice_code'].".html";
					$data['invoice_file_pdf'] 	= '/media/invoice/'.$invoiceData['invoice_id'].'/'.$invoiceData['invoice_code'].".pdf";
					/*Update. */
					$where      = $this->getAdapter()->quoteInto('invoice_id = ?', $invoiceData['invoice_id']);
					$success    = $this->update($data, $where);	

					return $pdffile;
				} else {
                    return false;
                }
			} else { 
				return false;
			}
		} else {
			return false;
		}
	}
	
    function sanitize(&$string) { $string = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $string);}
    function sanitizeArray(&$array) { for($i = 0; $i < count($array); $i++) { $array[$i] = preg_replace("/[^a-zA-Z0-9_]+/", "", $array[$i]); }}
}
?>