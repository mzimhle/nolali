<?php

//custom account item class as account table abstraction
class class_invoiceitem extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name		= 'invoiceitem';
	protected $_primary	= 'invoiceitem_id';
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	public function insert(array $data) {
        // add a timestamp
        $data['invoiceitem_added']			= date('Y-m-d H:i:s');
		$data['invoiceitem_amount_total']	= $data['invoiceitem_amount_unit']*$data['invoiceitem_quantity'];	
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
		$data['invoiceitem_updated']		= date('Y-m-d H:i:s');
		if(isset($data['invoiceitem_amount_unit'])) $data['invoiceitem_amount_total']	= $data['invoiceitem_amount_unit']*$data['invoiceitem_quantity'];			
        return parent::update($data, $where);
    }
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByInvoice($id) {

		$select = $this->_db->select()	
			->from(array('invoiceitem' => 'invoiceitem'))
			->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_id = invoiceitem.invoice_id')
			->where('invoiceitem_deleted = 0 and invoice_deleted = 0')
			->where('invoiceitem.invoice_id = ?', $id)
			->order('invoiceitem_added asc');
							
		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;					   
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getForTemplate() {

		$itemtotal = $this->_db->select()
			->from(array('invoiceitem' => 'invoiceitem'), array('invoice_id', 'invoice_amount_total' => new Zend_Db_Expr('SUM(IFNULL(invoiceitem_amount_total, 0))')))
			->where('invoiceitem_deleted = 0')
			->group('invoiceitem.invoice_id');

		$paymenttotal = $this->_db->select()
			->from(array('statement' => 'statement'), array('invoice_id', 'invoice_amount_paid' =>new Zend_Db_Expr('SUM(IFNULL(statement.statement_amount, 0))')))
			->where('statement_deleted = 0')
			->group('invoice_id');

		$select = $this->_db->select()	
			->from(array('invoice' => 'invoice'))
			->joinInner(array('entity' => 'entity'), "entity.entity_id = invoice.entity_id and entity_deleted = 0", array('entity_name', 'entity_address_physical', 'entity_contact_email', 'entity_contact_cellphone', 'entity_address_postal'))
			->joinLeft(array('participant' => 'participant'), "participant.participant_id = invoice.participant_id", array('participant_name', 'participant_address', 'participant_email', 'participant_cellphone'))
			->joinLeft(array('template' => 'template'), "template.template_category = 'TEMPLATE' and template.template_code = invoice.template_code and template_deleted = 0 and template.entity_id = participant.entity_id", array('template_id', 'template_category', 'template_subject', 'template_file', 'template_message'))
			->joinLeft(array('itemtotal' => $itemtotal), 'itemtotal.invoice_id = invoice.invoice_id', array('invoice_amount_total'))
			->joinLeft(array('statement' => $paymenttotal), 'statement.invoice_id = invoice.invoice_id', array('invoice_amount_paid', 'invoice_amount_due' => new Zend_Db_Expr('IFNULL(invoice_amount_total, 0) - IFNULL(invoice_amount_paid, 0)')))
			->joinLeft(array('invoiceitem' => 'invoiceitem'), "invoiceitem.invoice_id = invoice.invoice_id and invoice.invoice_type = 'BOOKING' and invoiceitem_deleted = 0", array('invoiceitem_date_start', 'invoiceitem_date_end', 'invoiceitem_quantity', 'invoiceitem_amount_total', 'invoiceitem_amount_unit'))
			->joinLeft(array('price' => 'price'), "price.price_id = invoiceitem.price_id and price_deleted = 0", array('price_amount', 'price_quantity'))
			->joinLeft(array('product' => 'product'), "product.product_id = price.product_id and product_deleted = 0")
			->order('RAND()')
			->group('invoice.invoice_id')->limit(1);	
							
		$result = $this->_db->fetchRow($select);

		if($result) {

            if(trim($result['participant_id']) == '') {
                $result['recipient_id'] = $result['entity_id'];
                $result['recipient_name'] = $result['entity_name'];
                $result['recipient_email'] = $result['entity_contact_email'];
                $result['recipient_cellphone'] = $result['entity_contact_cellphone'];
                $result['recipient_address_physical'] = $result['entity_address_physical'];
            } else {
                $result['recipient_id'] = $result['participant_id'];
                $result['recipient_name'] = $result['participant_name'];
                $result['recipient_email'] = $result['participant_email'];
                $result['recipient_cellphone'] = $result['participant_cellphone'];
                $result['recipient_address_physical'] = $result['participant_physical'];
            }

			$select = $this->_db->select()	
				->from(array('invoiceitem' => 'invoiceitem'))
				->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_id = invoiceitem.invoice_id')
				->where('invoiceitem_deleted = 0 and invoice_deleted = 0')
				->where('invoiceitem.invoice_id = ?', $result['invoice_id'])
				->order('invoiceitem_added asc');
								
			$items = $this->_db->fetchAll($select);

			$result['items'] = $items == false ? [] : $items;	
		}	
		return ($result == false) ? false : $result = $result;	
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByMonthlyInvoice($id) {

		$select = $this->_db->select()	
			->from(array('invoiceitem' => 'invoiceitem'))
			->joinLeft(array('invoicemonthly' => 'invoicemonthly'), 'invoicemonthly.invoicemonthly_id = invoiceitem.invoicemonthly_id')
			->where('invoiceitem_deleted = 0 and invoicemonthly_deleted = 0')
			->where('invoiceitem.invoicemonthly_id = ?', $id)
			->order('invoiceitem_added asc');
							
		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;					   
	}	
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByPaidTemplate($code) {

		$select = $this->_db->select()	
			->from(array('invoiceitem' => 'invoiceitem'))
			->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_id = invoiceitem.invoice_id')
			->where('invoiceitem_deleted = 0 and invoice_deleted = 0')
			->where('invoice.invoice_reference = ?', $code)
			->limit(1);
							
		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;					   
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByCode($code) {
		$select = $this->_db->select()	
			->from(array('invoiceitem' => 'invoiceitem'))
			->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_id = invoiceitem.invoice_id')
			->where('invoiceitem_deleted = 0 and invoice_deleted = 0')
			->where('invoiceitem.invoiceitem_id = ?', $code)
			->limit(1);

	   $result = $this->_db->fetchRow($select);	
       return ($result == false) ? false : $result = $result;					   
	}

	public function dayDiff($start, $end) {
		$end = strtotime($end);
		$start = strtotime($start);
		$datediff = $end - $start;
		return floor($datediff/(60*60*24));
	}

	function checkBooking($startdate, $enddate, $type, $code) {
		
			$sql = "select 
						ci.invoice_id,
						ci.participant_code,
						ii.invoiceitem_date_start, 
						ii.invoiceitem_date_end 
					from 
						invoice ci,
						invoiceitem ii,
						price p,
						entity e
					where
						ci.invoice_id = ii.invoice_id and ii.invoiceitem_deleted = 0
						and ci.invoice_item_type = 'BOOKING'
						and ci.invoice_item_code = e.entity_code
						and p.price_id = ii.price_id and price_active = 1 and price_deleted = 0
						and p.price_item_type = ? and p.price_item_code = ?
						and ii.invoiceitem_id in(
						select 
							invoiceitem_id
						from
							invoiceitem
						where
							 invoiceitem_deleted = 0 and
							(invoiceitem_date_start < ? and invoiceitem_date_end > ?) OR
							(invoiceitem_date_start < ? and invoiceitem_date_end > ?) OR
							(invoiceitem_date_start > ? and invoiceitem_date_end < ?))";

		$result = $this->_db->fetchRow($sql, array($type, $code, $startdate, $enddate, $enddate, $startdate, $startdate, $enddate));
        return ($result == false) ? false : $result = $result;							
	}	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code) {
		$select = $this->_db->select()	
			->from(array('invoiceitem' => 'invoiceitem'))	
			->where('invoiceitem_id = ?', $code)
			->limit(1);

	   $result = $this->_db->fetchRow($select);	
       return ($result == false) ? false : $result = $result;					   
	}
	
	function createCode() {
		/* New code. */
		$code = date('Ymd').md5(date('Y-m-d h:i:s').rand(1, 10000000));	
		/* First check if it exists or not. */
		$contactCheck = $this->getCode($code);
		
		if($contactCheck) {
			/* It exists. check again. */
			$this->createCode();
		} else {
			return $code;
		}
	}
	function validateAmount($amount) {
		if(preg_match("/^[0-9]+(?:\.[0-9]{0,2})?$/", $amount)) {
			return $amount;
		} else {
			return null;
		}	
	}	
}
?>