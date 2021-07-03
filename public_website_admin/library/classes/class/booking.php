<?php

require_once 'campaign.php';
require_once '_priceitem.php';
require_once '_payment.php';

//custom account item class as account table abstraction
class class_booking extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 			= 'booking';
	public $_campaign			= null;
	public $_priceitem			= null;
	public $_payment				= null;
	
	function init()	{

		global $zfsession;

		$this->_campaign	= new class_campaign();			
		$this->_priceitem	= new class_priceitem();		
		$this->_payment	= new class_payment();		
	}
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	 public function insert(array $data)
    {
        // add a timestamp
        $data['booking_added'] 	= date('Y-m-d H:i:s');
		$data['booking_code'] 	= $this->createCode();
		$data['campaign_code']	= $this->_campaign->_campaign;
		
		return parent::insert($data);
		
    }
	
	/**
	 * Update the database record
	 * example: $table->update($data, $where);
	 * @param query string $where
	 * @param array $data
     * @return boolean
	 */
    public function update(array $data, $where)
    {
        // add a timestamp        
		$data['booking_updated'] = date('Y-m-d H:i:s');
		
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job booking Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		
		$selectitem = $this->_db->select()	
				->from(array('_priceitem' => '_priceitem'), array(
								'_priceitem_reference as booking_code',
								new Zend_Db_Expr("(SUM(_price_cost) * _priceitem_quantity) AS item_total_sub"),
								new Zend_Db_Expr("(SUM(_price_cost) * _priceitem_quantity) * (campaign.campaign_vat) AS item_vat"),
								new Zend_Db_Expr("(SUM(_price_cost) * _priceitem_quantity) + ((SUM(_price_cost) * _priceitem_quantity) * (campaign.campaign_vat)) AS item_total")
							))
				->joinLeft(array('_price' => '_price'), '_price._price_code = _priceitem._price_code', array())							
				->joinLeft(array('booking' => 'booking'), "booking.booking_code = _priceitem_reference and _priceitem_type = 'BOOKING'", array())	
				->joinLeft(array('campaign' => 'campaign'), "campaign.campaign_code = booking.campaign_code", array())	
				->where('_priceitem_deleted = 0 and _price_deleted = 0 and booking_deleted = 0')
				->where('_priceitem_active = 1 and _price_active = 1')
				->where('_priceitem._priceitem_reference = ?', $code)
				->where('_priceitem._priceitem_type = ?', 'BOOKING')
				->group('_priceitem._priceitem_reference');
				
		$selectpayment = $this->_db->select()	
				->from(array('_payment' => '_payment'), array('_payment_reference as booking_code', new Zend_Db_Expr("SUM(_payment_amount) AS payment_total")))
				->joinLeft(array('booking' => 'booking'), "booking.booking_code = _payment._payment_reference and _payment_type = 'BOOKING'", array())		
				->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = booking.campaign_code', array())								
				->where('_payment_deleted = 0 and campaign_deleted = 0 and booking_deleted = 0')
				->where($this->_campaign->_campaignsql)
				->group('_payment._payment_reference');
				
		$select = $this->_db->select()	
					->from(array('booking' => 'booking'))	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = booking.campaign_code', array())
					->joinLeft(array('areapost' => 'areapost'), 'areapost.areapost_code = booking.areapost_code', array('areapost_name'))
						->joinLeft(array('invoice' => 'invoice'), "invoice.invoice_type = 'BOOKING' and invoice.invoice_reference = booking.booking_code", array('invoice_code','participant_code','invoice_person_name','invoice_person_number','invoice_person_email','invoice_type','invoice_reference','invoice_make','invoice_html','invoice_pdf','invoice_notes','invoice_added','invoice_active'))
					->joinLeft(array('_priceitem' => $selectitem), '_priceitem.booking_code = booking.booking_code', array('item_total_sub', 'item_vat', 'item_total'))
					->joinLeft(array('_payment' => $selectpayment), '_payment.booking_code = booking.booking_code', array('payment_total'))
					->where('booking_deleted = 0 and campaign_deleted  = 0')
					->where($this->_campaign->_campaignsql)
					->where('booking.booking_code = ?', $code)
					->group('booking.booking_code')
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
	   
	   if($result) {
			$result['priceitem'] = $this->_priceitem->getByReference($result['booking_code'], 'BOOKING');		
			$result['payment'] = $this->_payment->getByType($result['booking_code'], 'BOOKING');	
	   }
	   
       return ($result == false) ? false : $result = $result;

	}	
	
	
	public function getAll($where = 'booking_deleted = 0', $order = 'booking_name desc')
	{
		
		$select = $this->_db->select()	
					->from(array('booking' => 'booking'))	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = booking.campaign_code')
					->joinLeft(array('areapost' => 'areapost'), 'areapost.areapost_code = booking.areapost_code')
					->where('booking_deleted = 0 and campaign_deleted  = 0')
					->where($this->_campaign->_campaignsql)
					->order('booking_added');						
						
		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
	}
	
	public function search($query, $limit = 20) {
		
		$select = $this->_db->select()	
				->from(array('booking' => 'booking'))
				->joinLeft('areapost', 'areapost.areapost_code = booking.areapost_code')
				->joinLeft('campaign', 'campaign.campaign_code = booking.campaign_code')					
				->where("concat(booking_person_name, booking_person_email, booking_person_number, ) like lower(?)", "%$query%")
				->where($this->_campaign->_campaignsql)	
				->where('booking_deleted = 0')
				->limit($limit)
				->group('booking.booking_code')
				->order("LOCATE('$query', booking.booking_person_name)");

		$result = $this->_db->fetchAll($select);	
        return ($result == false) ? false : $result = $result;					

	}
	
	public function getSearch($search, $start, $length)
	{	
		
		$selectitem = $this->_db->select()	
				->from(array('_priceitem' => '_priceitem'), array(
								'_priceitem_reference as booking_code',
								new Zend_Db_Expr("(SUM(_price_cost) * _priceitem_quantity) AS item_total_sub"),
								new Zend_Db_Expr("(SUM(_price_cost) * _priceitem_quantity) * (campaign.campaign_vat) AS item_vat"),
								new Zend_Db_Expr("(SUM(_price_cost) * _priceitem_quantity) + ((SUM(_price_cost) * _priceitem_quantity) * (campaign.campaign_vat)) AS item_total")
							))
				->joinLeft(array('_price' => '_price'), '_price._price_code = _priceitem._price_code', array())							
				->joinLeft(array('booking' => 'booking'), "booking.booking_code = _priceitem_reference and _priceitem_type = 'BOOKING'", array())	
				->joinLeft(array('campaign' => 'campaign'), "campaign.campaign_code = booking.campaign_code", array())	
				->where('_priceitem_deleted = 0 and _price_deleted = 0 and booking_deleted = 0')
				->where('_priceitem_active = 1 and _price_active = 1')
				->where('_priceitem._priceitem_type = ?', 'BOOKING')
				->group('_priceitem._priceitem_reference');
				
		$selectpayment = $this->_db->select()	
				->from(array('_payment' => '_payment'), array('_payment_reference as booking_code', new Zend_Db_Expr("SUM(_payment_amount) AS payment_total")))
				->joinLeft(array('booking' => 'booking'), "booking.booking_code = _payment._payment_reference and _payment_type = 'BOOKING'", array())		
				->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = booking.campaign_code', array())								
				->where('_payment_deleted = 0 and campaign_deleted = 0 and booking_deleted = 0')
				->where($this->_campaign->_campaignsql)
				->group('_payment._payment_reference');
       		
		if($search == '') {
			$select = $this->_db->select()	
						->from(array('booking' => 'booking'))	
						->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = booking.campaign_code', array())
						->joinLeft(array('areapost' => 'areapost'), 'areapost.areapost_code = booking.areapost_code', array('areapost_name'))
						->joinLeft(array('invoice' => 'invoice'), "invoice.invoice_type = 'BOOKING' and invoice.invoice_reference = booking.booking_code", array('invoice_code','participant_code','invoice_person_name','invoice_person_number','invoice_person_email','invoice_type','invoice_reference','invoice_make','invoice_html','invoice_pdf','invoice_notes','invoice_added','invoice_active'))
						->joinLeft(array('_priceitem' => $selectitem), '_priceitem.booking_code = booking.booking_code', array('item_total_sub', 'item_vat', 'item_total'))
						->joinLeft(array('_payment' => $selectpayment), '_payment.booking_code = booking.booking_code', array('payment_total'))
						->where('booking_deleted = 0 and campaign_deleted  = 0')
						->where($this->_campaign->_campaignsql)
						->group('booking.booking_code')						
						->order('booking_person_name desc');			
		} else {
			$select = $this->_db->select()	
						->from(array('booking' => 'booking'))	
						->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = booking.campaign_code', array())
						->joinLeft(array('areapost' => 'areapost'), 'areapost.areapost_code = booking.areapost_code', array('areapost_name'))
						->joinLeft(array('invoice' => 'invoice'), "invoice.invoice_type = 'BOOKING' and invoice.invoice_reference = booking.booking_code")
						->joinLeft(array('_priceitem' => $selectitem), '_priceitem.booking_code = booking.booking_code', array('item_total_sub', 'item_vat', 'item_total'))
						->joinLeft(array('_payment' => $selectpayment), '_payment.booking_code = booking.booking_code', array('payment_total'))
						->where('booking_deleted = 0 and campaign_deleted  = 0')
						->where("concat(booking_person_name, booking_person_email, booking_person_number, booking_code) like lower(?)", "%$search%")
						->where($this->_campaign->_campaignsql)
						->group('booking.booking_code')	
						->order("LOCATE('$query', booking.booking_person_name)");								
		}

		$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");

		if ($start == '' || $length == '') { 
			$result = $this->_db->fetchAll($select);
		} else { 
			$result = $this->_db->fetchAll($select . " limit $start, $length");
		}

		return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);	
	}
	
	function checkBooking($startdate, $enddate, $price, $code = null) {
		
		if($code == null) {
			$sql = "select 
							b.booking_code, 
							b.booking_startdate, 
							b.booking_enddate 
						from 
							booking b,
							_priceitem _pi,
							_price _p,
							campaign c
						where
							b.booking_code = _pi._priceitem_reference
							and _pi._priceitem_type = 'BOOKING'
							and _p._price_code = _pi.price_code
							and _p._price_code = ?
							and _p._price_deleted = 0 and _p._price_active = 1
							and b.booking_deleted = 0 and b.booking_status = 1 and _pi._priceitem_deleted = 0 and _p._price_deleted = 0
							and b.booking_code in(
							select 
								booking_code
							from
								booking
							where
								(booking_startdate <= ? and booking_enddate >= ?) OR
								(booking_startdate <= ? and booking_enddate >= ?) OR
								(booking_startdate >= ? and booking_enddate <= ?))
								and campaign.campaign_code = b.campaign_code								
								and ".$this->_campaign->_campaignsql;
								
			$result = $this->_db->fetchRow($sql, array($price, $startdate, $enddate, $enddate, $startdate, $startdate, $enddate));
			
		} else {
			$sql = "select 
							b.booking_code, 
							b.booking_startdate, 
							b.booking_enddate 
						from 
							booking b,
							_priceitem _pi,
							_price _p,
							campaign
						where
							b.booking_code = _pi._priceitem_reference
							and _pi._priceitem_type = 'BOOKING'
							and _p._price_code = _pi._price_code
							and _p._price_code = ?
							and _p._price_deleted = 0 and _p._price_active = 1
							and b.booking_deleted = 0 and b.booking_status = 1 and _pi._priceitem_deleted = 0 and _p._price_deleted = 0
							and b.booking_code in(
							select 
								booking_code
							from
								booking
							where
								(booking_startdate <= ? and booking_enddate >= ?) OR
								(booking_startdate <= ? and booking_enddate >= ?) OR
								(booking_startdate >= ? and booking_enddate <= ?))
								and campaign.campaign_code = b.campaign_code								
								and ".$this->_campaign->_campaignsql."
								and b.booking_code != ?";
							
			$result = $this->_db->fetchRow($sql, array($price, $startdate, $enddate, $enddate, $startdate, $startdate, $enddate, $code));
		}

        return ($result == false) ? false : $result = $result;							
	}	
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code)
	{
		$select = $this->_db->select()	
					->from(array('booking' => 'booking'))	
					   ->where('booking_code = ?', $code)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createCode() {
		/* New code. */
		$code = "";
		$codeAlphabet = "123456789";

		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<5;$i++){
			$code .= $codeAlphabet[rand(0,$count)];
		}
				
		$code = $code.time();
		
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($code);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createCode();
		} else {
			return $code;
		}
	}	
	
	public function validateEmail($string) {
		if(preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', trim($string))) {
			return trim($string);
		} else {
			return '';
		}
	}
}
?>