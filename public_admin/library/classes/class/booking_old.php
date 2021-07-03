<?php

require_once 'campaign.php';
require_once 'invoice.php';
require_once '_comm.php';
require_once 'invoiceitem.php';
require_once 'invoicepayment.php';
require_once 'productprice.php';
require_once 'participant.php';
require_once 'PDF.php';

//custom account item class as account table abstraction
class class_booking extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected	$_name 			= 'booking';
	protected	$_primary			= 'booking_code';
	
	public $_domainData		= null;
	public $_campaign			= null;
	public $_invoice				= null;
	public $_invoiceitem			= null;
	public $_invoicepayment	= null;
	public $_productprice		= null;
	public $_participant			= null;
	public $_comm					= null;
	public $_PDFCROWD			= null;
	
	function init()	{
		
		global $zfsession;
		
		$this->_invoice				= new class_invoice();
		$this->_invoiceitem		= new class_invoiceitem();
		$this->_invoicepayment	= new class_invoicepayment();
		$this->_campaign			= new class_campaign();	
		$this->_productprice		= new class_productprice();
		$this->_participant			= new class_participant();
		$this->_participant			= new class_participant();
		$this->_comm				= new class_comm();
		$this->_PDFCROWD		= new CLASS_PDFCROWD();
		
	}

	public function updateBooking($data, $where, $code) {
		
		$bdata 	= array();				
		$bdata['participant_code']				= trim($data['participant_code']);		
		$bdata['product_code']					= trim($data['product_code']);						
		$bdata['productprice_code']			= trim($data['productprice_code']);				
		$bdata['booking_startdate']			= trim($data['booking_startdate']);		
		$bdata['booking_enddate']				= trim($data['booking_enddate']);			
		$bdata['booking_number_adult']		= isset($data['booking_number_adult']) ? trim($data['booking_number_adult']) : null;		
		$bdata['booking_number_children']	= isset($data['booking_number_children']) ? trim($data['booking_number_children']) : null;		
		$bdata['booking_message']			= trim($data['booking_message']);	
		
		/* Update the booking. */
		$this->update($bdata, $where);
		
		$bookingData = $this->getByCode($code);

		if($bookingData) {
			/* update the invoice. */
			$idata['participant_code'] 	= $bookingData['participant_code'];	
			$idata['invoice_paid'] 		= isset($data['invoice_paid_date']) && trim($data['invoice_paid_date']) != '' ? 1 : 0;
			$idata['invoice_paid_date']	= isset($data['invoice_paid_date']) && trim($data['invoice_paid_date']) != null ? $data['invoice_paid_date'] : null;	

			$iwhere 	= array();
			$iwhere[]	= $this->_invoice->getAdapter()->quoteInto('invoice_code = ?', $bookingData['invoice_code']);		
			$iwhere[]	= $this->_invoice->getAdapter()->quoteInto('booking_code = ?', $bookingData['booking_code']);		
			
			$this->_invoice->update($idata, $iwhere);		
			
			/* Update invoice item. */
			$itemData['product_code']					= $bookingData['product_code'];
			$itemData['productprice_code']			= $bookingData['productprice_code'];
			$itemData['invoiceitem_quantity']		= $this->_invoiceitem->dayDiff($bookingData['booking_startdate'], $bookingData['booking_enddate'])+1;
			$itemData['invoiceitem_name']			= $bookingData['productprice_name'];
			$itemData['invoiceitem_description']	= $bookingData['productprice_description'];
			$itemData['invoiceitem_price']			= $bookingData['productprice_price'] * $itemData['invoiceitem_quantity'];
			
			$itwhere	= array();
			$itwhere[]	= $this->_invoice->getAdapter()->quoteInto('booking_code = ?', $bookingData['booking_code']);				
			$itwhere[]	= $this->_invoice->getAdapter()->quoteInto('invoice_code = ?', $bookingData['invoice_code']);		
			
			$this->_invoiceitem->update($itemData, $itwhere);		
			
			$this->createInvoice($bookingData['booking_code']);
			
			return $bookingData['booking_code'];
		} else {
			return false;
		}
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
        $data['booking_added']	= date('Y-m-d H:i:s');
        $data['booking_code']	= $this->createReference();		
		$data['campaign_code'] 	= $this->_campaign->_campaigncode;
		
		$success = parent::insert($data);	
		
		if($success) {
			
			$bookingData = $this->getByCode($success);
			
			if($bookingData) {
			
				/********************************************************************************************************************* Create Invoice Start*/
				/* Create Invoice. */
				$idata = array();
				$idata['invoice_code']					= $this->_invoice->createReference();
				$idata['participant_code'] 			= $bookingData['participant_code'];
				$idata['booking_code'] 				= $success;								
				$idata['campaign_code'] 			= $this->_campaign->_campaigncode;
				$idata['invoicetype_code']			= 'IN';
				$idata['invoice_payment_date']	= date('Y-m-d', strtotime("+3 day"));			
				
				$this->_invoice->insert($idata);
				/********************************************************************************************************************* Create Invoice End */		

				/********************************************************************************************************************* Create Invoice Item Start */
				$itemData = array();
				$itemData['invoiceitem_code']			= $this->_invoiceitem->createReference();
				$itemData['product_code']					= $bookingData['product_code'];
				$itemData['booking_code']					= $success;
				$itemData['invoice_code']					= $idata['invoice_code'];
				$itemData['productprice_code']			= $bookingData['productprice_code'];
				$itemData['invoiceitem_quantity']		= $this->_invoiceitem->dayDiff($bookingData['booking_startdate'], $bookingData['booking_enddate'])+1;
				$itemData['invoiceitem_name']			= $bookingData['productprice_name'];
				$itemData['invoiceitem_description']	= $bookingData['productprice_description'];
				$itemData['invoiceitem_price']			= $bookingData['productprice_price'] * $itemData['invoiceitem_quantity'];
				
				$this->_invoiceitem->insert($itemData);				
				/********************************************************************************************************************* Create Invoice Item End. */				
				
				$this->createInvoice($bookingData['booking_code']);
			}
		}
		
		return 	$success;	
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
	
	public function remove($code) {
		return $this->delete('booking_code = ?', $code);		
	}
	
	public function createInvoice($bookingcode) {
		
		global $smarty;
		
		$bookingData = $this->getByCode($bookingcode);
		
		if($bookingData) {
			
			$smarty->assign('bookingData', $bookingData);

			$html = $smarty->fetch('templates/'.$this->_campaign->_campaigncode.'/invoice/invoice.html');
			
			/* Save file. */
			$directory	= $_SERVER['DOCUMENT_ROOT'].$this->_campaign->_domainData['campaign_directory'].'/media/invoice/'.$bookingData['invoice_code'].'/';
			$filename	= $directory.$bookingData['invoice_code'].'.html';
			$pdffile		= $directory.$bookingData['invoice_code'].'.pdf';

			if(!is_dir($directory)) mkdir($directory, 0777, true);	
			
			if(file_put_contents($filename, $html)) {
					
				$pdfdata 	= $this->_PDFCROWD->_PDF->convertFile($filename);

				if(file_put_contents($pdffile, $pdfdata)) {
				
					$data = array();
					$data['invoice_html'] 	= $this->_campaign->_link."media/invoice/".$bookingData['invoice_code']."/".$bookingData['invoice_code'].".html";
					$data['invoice_pdf'] 	= $this->_campaign->_link."media/invoice/".$bookingData['invoice_code']."/".$bookingData['invoice_code'].".pdf";
					
					/* Make invoice to be paid. */
					if((int)trim($bookingData['invoice_paid']) == 1) {
						if($bookingData['due_amount'] == 0 || $bookingData['due_amount'] < 0) {
							$data['invoice_paid_date']	= date('Y-m-d H:i:s');
							$data['invoice_paid']			= 1;
						}
					}
					
					/*Update. */
					$where		= $this->_invoice->getAdapter()->quoteInto('invoice_code = ?', $bookingData['invoice_code']);
					$success	= $this->_invoice->update($data, $where);
					
					return $bookingData['invoice_code'];
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function sendBookingNotice($code) {
	
		$bookingData = $this->getByCode($code);
		
		if($bookingData) {
			
			return $this->_comm->sendEmail($bookingData, null, 'Online Booking Notice', 'template/'.$bookingData['booking_code'].'/booking/notice.html');
			
		} else {
			return false;
		}
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
					->joinLeft(array('product' => 'product'), 'product.product_code = booking.product_code')	
					->joinLeft(array('productprice' => 'productprice'), 'productprice.productprice_code = booking.productprice_code')
					->joinLeft(array('invoice' => 'invoice'), 'invoice.booking_code = booking.booking_code', array('invoice_code'))	
					->joinLeft(array('participant' => 'participant'), 'participant.participant_code = booking.participant_code')
					->where('booking_deleted = 0 and campaign_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('booking.booking_code = ?', $code)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
	   
	   if($result) {
			
			/* Get invoice data. */
			$invoiceData = $this->_invoice->getByBookingCode($result['booking_code']);
			
			if($invoiceData) {
				$result = array_merge($invoiceData, $result);			
				/* Get invoice item data. */
				$result['invoicepayments']	= $this->_invoicepayment->getByInvoiceCode($result['invoice_code']);
				/* Get invoice item data. */
				$result['invoiceitems']		= $this->_invoiceitem->getByInvoiceCode($result['invoice_code']);
			}
	   }

       return ($result == false) ? false : $result = $result;

	}	
	
	/**
	 * get job by job bookingtype Id
 	 * @param string job id
     * @return object
	 */
	public function getAll($where = 'booking_deleted = 0', $order = 'booking_added desc')
	{
		$select = $this->_db->select()	
					->from(array('booking' => 'booking'))	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = booking.campaign_code')	
					->joinLeft(array('product' => 'product'), 'product.product_code = booking.product_code')
					->joinLeft(array('productprice' => 'productprice'), 'productprice.productprice_code = booking.productprice_code')
					->joinLeft(array('participant' => 'participant'), 'participant.participant_code = booking.participant_code')
					->joinLeft(array('invoice' => 'invoice'), 'invoice.booking_code = booking.booking_code')	
					->where('booking_deleted = 0 and campaign_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where($where)
					->order($order);
					
	   $result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}	
	
	
	/**
	 * get job by job bookingtype Id
 	 * @param string job id
     * @return object
	 */
	public function getBooked($where = NULL, $order = NULL)
	{
		$select = $this->_db->select()	
					->from(array('booking' => 'booking'))	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = booking.campaign_code')	
					->joinLeft(array('product' => 'product'), 'product.product_code = booking.product_code')
					->joinLeft(array('productprice' => 'productprice'), 'productprice.productprice_code = booking.productprice_code')
					->joinLeft(array('participant' => 'participant'), 'participant.participant_code = booking.participant_code')
					->joinLeft(array('invoice' => 'invoice'), 'invoice.booking_code = booking.booking_code')	
					->where('booking_deleted = 0 and campaign_deleted = 0')
					->where('invoicetype_code = ?', 'IN')
					->where($this->_campaign->_campaignsql)
					->where($where)
					->order($order);
					
	   $result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}	
	
	function checkBookingByProduct($productcode, $startdate, $enddate, $code = null) {
		
		if($code == null) {
			$sql = "select 
							cb.booking_code, 
							ci.invoice_code,
							cb.participant_code,
							cb.productprice_code,
							cb.product_code,
							cb.booking_startdate, 
							cb.booking_enddate 
						from 
							booking cb,
							invoice ci,
							campaign
						where
							cb.booking_code = ci.booking_code
							and ci.invoicetype_code = 'IN'
							and cb.product_code = ?
							and cb.booking_code in(
							select 
								booking_code
							from
								booking
							where
								(booking_startdate <= ? and booking_enddate >= ?) OR
								(booking_startdate <= ? and booking_enddate >= ?) OR
								(booking_startdate >= ? and booking_enddate <= ?))
								and campaign.campaign_code = cb.campaign_code
								and ".$this->_campaign->_campaignsql;
								
			$result = $this->_db->fetchRow($sql, array($productcode, $startdate, $enddate, $enddate, $startdate, $startdate, $enddate));
			
		} else {
			$sql = "select 
							cb.booking_code, 
							ci.invoice_code,
							cb.participant_code,
							cb.productprice_code,
							cb.product_code,
							cb.booking_startdate, 
							cb.booking_enddate 
						from 
							booking cb,
							invoice ci,
							campaign
						where
							cb.booking_code = ci.booking_code
							and ci.invoicetype_code = 'IN'
							and cb.product_code = ?
							and cb.booking_code in(
							select 
								booking_code
							from
								booking
							where
								(booking_startdate <= ? and booking_enddate >= ?) OR
								(booking_startdate <= ? and booking_enddate >= ?) OR
								(booking_startdate >= ? and booking_enddate <= ?))
								and campaign.campaign_code = cb.campaign_code
								and ".$this->_campaign->_campaignsql."
							and cb.booking_code != ?;";
							
			$result = $this->_db->fetchRow($sql, array($productcode, $startdate, $enddate, $enddate, $startdate, $startdate, $enddate, $code));
		}

        return ($result == false) ? false : $result = $result;							
	}	
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($reference)
	{
		$select = $this->_db->select()	
					->from(array('booking' => 'booking'))	
					   ->where('booking_code = ?', $reference)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
       return ($result == false) ? false : $result = $result;					   
	}
	
	function createReference() {
		/* New reference. */
		$reference = "";
		//$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet = "123456789";

		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<10;$i++){
			$reference .= $codeAlphabet[rand(0,$count)];
		}
		
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($reference);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createReference();
		} else {
			return $reference;
		}
	}		
}
?>