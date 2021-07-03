<?php

require_once 'campaign.php';

//custom account item class as account table abstraction
class class_booking extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 			= 'booking';
	public $_campaign			= null;
	
	function init()	{
		
		global $zfsession;

		$this->_campaign			= new class_campaign();			
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
		$data['booking_code'] 		= $this->createCode();
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
		$select = $this->_db->select()	
					->from(array('booking' => 'booking'))	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = booking.campaign_code')
					->joinLeft(array('areapost' => 'areapost'), 'areapost.areapost_code = booking.areapost_code')
					->where('booking_deleted = 0 and campaign_deleted  = 0')
					->where($this->_campaign->_campaignsql)
					->where('booking_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
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