<?php

require_once 'campaign.php';
require_once 'PDF.php';
require_once 'invoiceitem.php';
require_once 'invoicepayment.php';
require_once 'template.php';

//custom account item class as account table abstraction
class class_invoice extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected	$_name		= 'invoice';
	protected	$_primary		= 'invoice_code';
	
	public $_campaign			= null;
	public $_invoiceitem			= null;
	public $_invoicepayment	= null;
	public $_template				= null;
	public $_PDFCROWD			= null;
	
	function init()	{
		
		global $zfsession;

		$this->_campaign			= new class_campaign();	
		$this->_invoiceitem		= new class_invoiceitem();	
		$this->_invoicepayment	= new class_invoicepayment();	
		$this->_template			= new class_template();	
		$this->_PDFCROWD		= new CLASS_PDFCROWD();
		
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
        $data['invoice_added'] 	= date('Y-m-d H:i:s');
        $data['invoice_code']  	= isset($data['invoice_code']) ? $data['invoice_code'] : $this->createCode();
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
        $data['invoice_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job invoice Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		$selectpayment = $this->_db->select()	
				->from(array('invoicepayment' => 'invoicepayment'), array('invoice_code', new Zend_Db_Expr("SUM(invoicepayment_amount) AS payment_total")))
				->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_code = invoicepayment.invoice_code', array())		
				->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code', array())								
				->where('invoice_deleted = 0 and campaign_deleted = 0 and invoicepayment_deleted = 0')
				->where($this->_campaign->_campaignsql)
				->group('invoicepayment.invoice_code');
		
		$selectitem = $this->_db->select()	
				->from(array('invoiceitem' => 'invoiceitem'), array(
								'invoice_code',
								new Zend_Db_Expr("(SUM(invoiceitem_amount) * invoiceitem_quantity) AS item_total_sub"),
								new Zend_Db_Expr("(SUM(invoiceitem_amount) * invoiceitem_quantity) * (campaign.campaign_vat) AS item_vat"),
								new Zend_Db_Expr("(SUM(invoiceitem_amount) * invoiceitem_quantity) + ((SUM(invoiceitem_amount) * invoiceitem_quantity) * (campaign.campaign_vat)) AS item_total")
							))
				->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_code = invoiceitem.invoice_code', array())		
				->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code', array())								
				->where('invoice_deleted = 0 and campaign_deleted = 0 and invoiceitem_deleted = 0')
				->where($this->_campaign->_campaignsql)
				->group('invoiceitem.invoice_code');
							
			$select = $this->_db->select()
					->from(array('invoice' => 'invoice'), array('invoice_code', 'participant_code','invoice_person_name','invoice_person_number','invoice_person_email','invoice_type','invoice_reference','invoice_make','invoice_pdf','invoice_notes', 'invoice_added',
					new Zend_Db_Expr("(invoiceitem.item_total - invoicepayment.payment_total) as payment_remainder")))
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code', array())
					->joinLeft(array('invoiceitem' => $selectitem), 'invoiceitem.invoice_code = invoice.invoice_code', array('item_total_sub', 'item_vat', 'item_total'))
					->joinLeft(array('invoicepayment' => $selectpayment), 'invoicepayment.invoice_code = invoice.invoice_code', array('payment_total'))
					->where('invoice_deleted = 0 and campaign_deleted = 0')						
					->where($this->_campaign->_campaignsql)
					->where('invoice.invoice_code = ?', $code)		
					->group('invoice.invoice_code');
							
		$result = $this->_db->fetchRow($select);

		if($result) {
			$result['invoicepayment']	= $this->_invoicepayment->getByInvoice($result['invoice_code']);
			$result['invoiceitem'] 			= $this->_invoiceitem->getByInvoice($result['invoice_code']);		
		}
		
		return ($result == false) ? false : $result = $result;

	}	

	public function search($query, $limit = 20) {
		
		$selectpayment = $this->_db->select()	
				->from(array('invoicepayment' => 'invoicepayment'), array('invoice_code', new Zend_Db_Expr("SUM(invoicepayment_amount) AS payment_total")))
				->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_code = invoicepayment.invoice_code', array())		
				->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code', array())								
				->where('invoice_deleted = 0 and campaign_deleted = 0 and invoicepayment_deleted = 0')
				->where($this->_campaign->_campaignsql)
				->group('invoicepayment.invoice_code');
		
		$selectitem = $this->_db->select()	
				->from(array('invoiceitem' => 'invoiceitem'), array(
								'invoice_code',
								new Zend_Db_Expr("(SUM(invoiceitem_amount) * invoiceitem_quantity) AS item_total_sub"),
								new Zend_Db_Expr("(SUM(invoiceitem_amount) * invoiceitem_quantity) * (campaign.campaign_vat) AS item_vat"),
								new Zend_Db_Expr("(SUM(invoiceitem_amount) * invoiceitem_quantity) + ((SUM(invoiceitem_amount) * invoiceitem_quantity) * (campaign.campaign_vat)) AS item_total")
							))
				->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_code = invoiceitem.invoice_code', array())		
				->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code', array())								
				->where('invoice_deleted = 0 and campaign_deleted = 0 and invoiceitem_deleted = 0')
				->where($this->_campaign->_campaignsql)
				->group('invoiceitem.invoice_code');
							
		$select = $this->_db->select()
				->from(array('invoice' => 'invoice'), array('participant_code','invoice_person_name','invoice_person_number','invoice_person_email','invoice_type','invoice_reference','invoice_make','invoice_pdf','invoice_notes', 'invoice_added',
				new Zend_Db_Expr("(invoiceitem.item_total - invoicepayment.payment_total) as payment_remainder")))
				->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code')
				->joinLeft(array('invoiceitem' => $selectitem), 'invoiceitem.invoice_code = invoice.invoice_code')
				->joinLeft(array('invoicepayment' => $selectpayment), 'invoicepayment.invoice_code = invoice.invoice_code')
				->where('invoice_deleted = 0 and campaign_deleted = 0')						
				->where($this->_campaign->_campaignsql)
				->where("concat(invoice_person_name, 	invoice_person_email, invoice_person_number, invoice.invoice_code) like lower(?)", "%$query%")
				->limit($limit)				
				->group('invoiceitem.invoice_code')
				->order("LOCATE('$query', booking.invoice_person_name)");

		$result = $this->_db->fetchAll($select);	
        return ($result == false) ? false : $result = $result;					

	}
	
	public function getSearch($search, $start, $length)
	{	
	
		$selectpayment = $this->_db->select()	
				->from(array('invoicepayment' => 'invoicepayment'), array('invoice_code', new Zend_Db_Expr("SUM(invoicepayment_amount) AS payment_total")))
				->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_code = invoicepayment.invoice_code', array())		
				->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code', array())								
				->where('invoice_deleted = 0 and campaign_deleted = 0 and invoicepayment_deleted = 0')
				->where($this->_campaign->_campaignsql)
				->group('invoicepayment.invoice_code');
		
		$selectitem = $this->_db->select()	
				->from(array('invoiceitem' => 'invoiceitem'), array(
								'invoice_code',
								new Zend_Db_Expr("(SUM(invoiceitem_amount) * invoiceitem_quantity) AS item_total_sub"),
								new Zend_Db_Expr("(SUM(invoiceitem_amount) * invoiceitem_quantity) * (campaign.campaign_vat) AS item_vat"),
								new Zend_Db_Expr("(SUM(invoiceitem_amount) * invoiceitem_quantity) + ((SUM(invoiceitem_amount) * invoiceitem_quantity) * (campaign.campaign_vat)) AS item_total")
							))
				->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_code = invoiceitem.invoice_code', array())		
				->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code', array())								
				->where('invoice_deleted = 0 and campaign_deleted = 0 and invoiceitem_deleted = 0')
				->where($this->_campaign->_campaignsql)
				->group('invoiceitem.invoice_code');
							
		if($search == '') {
			$select = $this->_db->select()
					->from(array('invoice' => 'invoice'), array('invoice_code', 'participant_code','invoice_person_name','invoice_person_number','invoice_person_email','invoice_type','invoice_reference','invoice_make','invoice_pdf','invoice_notes', 'invoice_added',
					new Zend_Db_Expr("(invoiceitem.item_total - invoicepayment.payment_total) as payment_remainder")))
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code', array())
					->joinLeft(array('invoiceitem' => $selectitem), 'invoiceitem.invoice_code = invoice.invoice_code', array('item_total_sub', 'item_vat', 'item_total'))
					->joinLeft(array('invoicepayment' => $selectpayment), 'invoicepayment.invoice_code = invoice.invoice_code', array('payment_total'))
					->where('invoice_deleted = 0 and campaign_deleted = 0')						
					->where($this->_campaign->_campaignsql)	
					->group('invoice.invoice_code');

		} else {
			$select = $this->_db->select()
					->from(array('invoice' => 'invoice'), array('invoice_code', 'participant_code','invoice_person_name','invoice_person_number','invoice_person_email','invoice_type','invoice_reference','invoice_make','invoice_pdf','invoice_notes', 'invoice_added',
					new Zend_Db_Expr("(invoiceitem.item_total - invoicepayment.payment_total) as payment_remainder")))
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code', array())
					->joinLeft(array('invoiceitem' => $selectitem), 'invoiceitem.invoice_code = invoice.invoice_code', array('item_total_sub', 'item_vat', 'item_total'))
					->joinLeft(array('invoicepayment' => $selectpayment), 'invoicepayment.invoice_code = invoice.invoice_code', array('payment_total'))
					->where('invoice_deleted = 0 and campaign_deleted = 0')						
					->where($this->_campaign->_campaignsql)
					->where("concat(invoice_person_name, 	invoice_person_email, invoice_person_number) like lower(?)", "%$search%")				
					->group('invoice.invoice_code')
					->order("LOCATE('$search', invoice.invoice_person_name)");					
		
		}

		$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");

		if ($start == '' || $length == '') { 
			$result = $this->_db->fetchAll($select);
		} else { 
			$result = $this->_db->fetchAll($select . " limit $start, $length");
		}

		return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);	
	}
	
	/**
	 * get job by job invoice Id
 	 * @param string job id
     * @return object
	 */
	public function getAll()
	{
		$selectpayment = $this->_db->select()	
							->from(array('invoicepayment' => 'invoicepayment'), array('invoice_code', new Zend_Db_Expr("SUM(invoicepayment_amount) AS payment_total")))
							->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_code = invoicepayment.invoice_code', array())		
							->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code', array())								
							->where('invoice_deleted = 0 and campaign_deleted = 0 and invoicepayment_deleted = 0')
							->where($this->_campaign->_campaignsql)
							->group('invoicepayment.invoice_code');
		
		$selectitem = $this->_db->select()	
							->from(array('invoiceitem' => 'invoiceitem'), array(
											'invoice_code',
											new Zend_Db_Expr("(SUM(invoiceitem_amount) * invoiceitem_quantity) AS item_total_sub"),
											new Zend_Db_Expr("(SUM(invoiceitem_amount) * invoiceitem_quantity) * (campaign.campaign_vat) AS item_vat"),
											new Zend_Db_Expr("(SUM(invoiceitem_amount) * invoiceitem_quantity) + ((SUM(invoiceitem_amount) * invoiceitem_quantity) * (campaign.campaign_vat)) AS item_total")
										))
							->joinLeft(array('invoice' => 'invoice'), 'invoice.invoice_code = invoiceitem.invoice_code', array())		
							->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code', array())								
							->where('invoice_deleted = 0 and campaign_deleted = 0 and invoiceitem_deleted = 0')
							->where($this->_campaign->_campaignsql)
							->group('invoiceitem.invoice_code');
							
		$select = $this->_db->select()
							->from(array('invoice' => 'invoice'), array('participant_code','invoice_person_name','invoice_person_number','invoice_person_email','invoice_type','invoice_reference','invoice_make','invoice_pdf','invoice_notes', 'invoice_added',
							new Zend_Db_Expr("(invoiceitem.item_total - invoicepayment.payment_total) as payment_remainder")))
							->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = invoice.campaign_code')
							->joinLeft(array('invoiceitem' => $selectitem), 'invoiceitem.invoice_code = invoice.invoice_code')
							->joinLeft(array('invoicepayment' => $selectpayment), 'invoicepayment.invoice_code = invoice.invoice_code')
							->where('invoice_deleted = 0 and campaign_deleted = 0')						
							->where($this->_campaign->_campaignsql)				
							->group('invoiceitem.invoice_code');

		$result = $this->_db->fetchAll($select);	
		return ($result == false) ? false : $result = $result;

	}

	public function validateEmail($string) {
		if (!filter_var($string, FILTER_VALIDATE_EMAIL)) {
		  return '';
		} else {
		  return $string;
		}
	}
	
	public function createInvoice($invoicecode) {

		global $smarty;

		$invoiceData = $this->getByCode($invoicecode);

		if($invoiceData) {
			
			$smarty->assign('invoiceData', $invoiceData);

			/* Get template by type. */
			$templateData = $this->_template->getByType($invoiceData['invoice_make']);

			$html = $smarty->fetch(realpath(__DIR__.'/../../../../').$this->_campaign->_campaignData['campaign_directory'].$templateData['template_file']);

			/* Save file. */ 
			$directory	= realpath(__DIR__.'/../../../../').$this->_campaign->_campaignData['campaign_directory'].'/media/invoice/'.$invoiceData['invoice_code'].'/';

			$filename	= $directory.$invoiceData['invoice_code'].'.html';
			$pdffile		= $directory.$invoiceData['invoice_code'].'.pdf';

			if(!is_dir($directory)) mkdir($directory, 0777, true);	
			
			if(file_put_contents($filename, $html)) {
					
				$pdfdata 	= $this->_PDFCROWD->_PDF->convertFile($filename);

				if(file_put_contents($pdffile, $pdfdata)) {
				
					$data = array();
					$data['invoice_html'] 	= '/media/invoice/'.$invoiceData['invoice_code'].'/'.$invoiceData['invoice_code'].".html";
					$data['invoice_pdf'] 	= '/media/invoice/'.$invoiceData['invoice_code'].'/'.$invoiceData['invoice_code'].".pdf";
					
					/*Update. */
					$where		= array();
					$where[]	= $this->getAdapter()->quoteInto('campaign_code = ?', $this->_campaign->_campaign);
					$where[]	= $this->getAdapter()->quoteInto('invoice_code = ?', $invoiceData['invoice_code']);
					$success	= $this->update($data, $where);

					return true;
				}
			} else { 
				return false;
			}
		} else {
			return false;
		}
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code)
	{
		$select = $this->_db->select()	
						->from(array('invoice' => 'invoice'))	
					   ->where('invoice_code = ?', $code)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;
	}
	
	function createCode() {
		/* New code. */
		$code = "";
		$codeAlphabet = "123456789";
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<7;$i++){
			$code .= $codeAlphabet[rand(0,$count)];
		}
		
		$alpha = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<3;$i++){
			$alpha .= $codeAlphabet[rand(0,$count)];
		}
		
		$code = $alpha.$code;
		
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($code);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createCode();
		} else {
			return $code;
		}
	}
	
}
?>