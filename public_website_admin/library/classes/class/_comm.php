<?php

require_once 'campaign.php';
require_once '_productpriceitem.php';

//custom account item class as account table abstraction
class class_comm extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 		= '_comm';
	protected $_primary	= '_comm_code';
	
	public $_campaign			= null;
	public $_productpriceitem	= null;
	public $_SMS					= null;
	
	function init()	{
		
		global $zfsession;

		$this->_campaign				= new class_campaign();
		$this->_productpriceitem	= new class_productpriceitem();
		
		$this->_SMS						= $this->_productpriceitem->getBySinglePrice('SMS');
		
	}
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	public function insert(array $data) {
        // add a timestamp
        $data['_comm_added'] 	= date('Y-m-d H:i:s');
        $data['_comm_code'] 	= isset($data['_comm_code']) ? $data['_comm_code'] : $this->createReference();        		
		$data['campaign_code']	= $this->_campaign->_campaigncode;
		
		return parent::insert($data);		
    }
	
	/**
	 * get job by job _comm Id
 	 * @param string job id
     * @return object
	 */
	public function viewComm($code) {
		$select = $this->_db->select()	
					->from(array('_comm' => '_comm'))		
					->joinLeft('campaign', 'campaign.campaign_code = _comm.campaign_code and campaign_deleted = 0')						
					->joinLeft('participant', 'participant.participant_code = _comm.participant_code and participant_deleted = 0')		
					->where($this->_campaign->_campaignsql)
					->where('_comm_code = ?', $code)					
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}	
	
	/**
	 * get job by job _comm Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{		
		$select = $this->_db->select()	
					->from(array('_comm' => '_comm'))				
					->joinLeft('campaign', 'campaign.campaign_code = _comm.campaign_code and campaign_deleted = 0')	
					->joinLeft('participant', 'participant.participant_code = _comm.participant_code and participant_deleted = 0')	
					->where($this->_campaign->_campaignsql)					
					->where('_comm_code = ?', $code)					
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;

	}
	
	public function getByCategoryReference($category, $reference) {
	
		$select = $this->_db->select()	
					->from(array('_comm' => '_comm'))	
					->joinLeft('campaign', 'campaign.campaign_code = _comm.campaign_code and campaign_deleted = 0')	
					->joinLeft('participant', 'participant.participant_code = _comm.participant_code and participant_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where('_custom_reference = ?', $reference)
					->where('_custom_category = ?', $category);	

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;	
	}
	
	public function getAll($where = '_comm_added != \'\'', $order = '_comm_added asc') {		
	
		$select = $this->_db->select()	
					->from(array('_comm' => '_comm'))	
					->joinLeft('campaign', 'campaign.campaign_code = _comm.campaign_code and campaign_deleted = 0')	
					->joinLeft('participant', 'participant.participant_code = _comm.participant_code and participant_deleted = 0')
					->where($this->_campaign->_campaignsql)
					->where($where)
					->order($order);	

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;
	}
	
	public function sendSMS($message, $participant) {		
		
		$user 			= "willowvine"; 
		$password 	= "DUJbgGdNRXROaA"; 
		$api_id 			= "3420082"; 
		$baseurl 		="http://api.clickatell.com"; 
		$text 			= urlencode($message); 
		$to 				= $participant['participant_cellphone']; 
		
		$successCounter	= 0;
		$failCounter			= 0;
		
		$data								= array();
		$data['_comm_code']			= $this->createReference();
		$data['participant_code']	= $participant['participant_code'];
		$data['_comm_type']			= 'SMS';
		$data['_comm_name']		= $participant['participant_name'].' '.$participant['participant_surname'];
		$data['_comm_cell']			= $participant['participant_cellphone'];
		$data['_comm_email']		= $participant['participant_email'];
		$data['_comm_cost']			= $this->_SMS['_productpriceitem_price'];
		$data['_comm_message']	= trim($message);
		$data['_comm_sent']			= 0;		
		$data['_comm_reference']	= $participant['reference'];
					
		if( preg_match( "/^0[0-9]{9}$/", trim($participant['participant_cellphone']))) {
			
			$url = "$baseurl/http/auth?user=$user&password=$password&api_id=$api_id"; 

			// do auth call 
			$ret = file($url); 

			// split our response. return string is on first line of the data returned 

			$sess = explode(":",$ret[0]); 
			
			if ($sess[0] == "OK") {
			
				$sess_id = trim($sess[1]); // remove any whitespace 
				
				$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text"; 
				
				// do sendmsg call 
				$ret = file($url); 
				
				$send = explode(":",$ret[0]); 
				
				if ($send[0] == "ID") { 																						
					$data['_comm_output']	= 'Success! : '.$send[0].' : '.$send[1];
					$data['_comm_sent']		= 1;					
				} else  {
					$data['_comm_output']	= 'Send message failed : '.$send[0].' : '.$send[1];
					$data['_comm_sent']		= 0;	  
				}
			} else { 
				$data['_comm_output']	= "Authentication failure: ". $ret[0]; 
				$data['_comm_sent']		= 0;	  
			} 
		} else {
			$data['_comm_output']	=  "Invalid number ".$participant['participant_cellphone'];	
			$data['_comm_sent']		= 0;		  
		}
		
		$this->insert($data);
		$return = $data['_comm_sent'] == 1 ? $data['_comm_code'] : false;
		return $return;
		
	}
	
	public function sendEmail($participant, $message, $subject, $file = null, $content = null) {

		// require 'config/smarty.php';
		global $smarty;
		
		require_once('Zend/Mail.php');
		
		$mail = new Zend_Mail();
		
		$data						= array();
		$data['_comm_code']	= $this->createReference();
		
		$smarty->assign('tracking', $data['_comm_code']);
		$smarty->assign('participant', $participant);
		$smarty->assign('message', $message);
		$smarty->assign('domain', $_SERVER['HTTP_HOST']);
				
		$template = $file == null ? $content : $smarty->fetch($file);
		
		$template = str_replace('[email]', $participant['participant_email'], $template);
		$template = str_replace('[tracking]', $data['_comm_code'], $template);
		$template = str_replace('[fullname]', $participant['participant_name'].' '.$participant['participant_surname'], $template);
		$template = str_replace('[participantcode]', $participant['participant_code'], $template);
		
		$mail->setFrom($participant['campaign_email'], $participant['campaign_name']); //EDIT!!											
		$mail->addTo($participant['participant_email']);
		$mail->setSubject($subject);
		$mail->setBodyHtml($template);			

		/* Save data to the comm table. */
		$data['participant_code']		= $participant['participant_code'];
		$data['_comm_type']				= 'EMAIL';
		$data['_comm_name']			= $participant['participant_name'].' '.$participant['participant_surname'];
		$data['_comm_sent']				= null;
		$data['_comm_email']			= $participant['participant_email'];
		$data['_comm_cell']				= $participant['participant_cellphone'];
		$data['_comm_cost']				= isset($participant['participant_cost']) ? $participant['participant_cost'] : null;
		$data['_comm_html']				= $template;
		$data['_comm_reference']		= $participant['_comm_reference'];
		$data['_custom_category'] 		= isset($participant['_custom_category']) ? $participant['_custom_category'] : null;
		$data['_custom_reference'] 	= isset($participant['_custom_reference']) ? $participant['_custom_reference'] : null;
				
		$this->insert($data);

		try {
			$mail->send();
			$data['_comm_sent']	= 1;	
			$data['_comm_output']	= 'Email Sent!';
			
		} catch (Exception $e) {
			$data['_comm_sent']		= 0;	
			$data['_comm_output']	= $e->getMessage();
		}
		
		$where = $this->getAdapter()->quoteInto('_comm_code = ?', $data['_comm_code']);
		$success = $this->update($data, $where);
		
		$mail = null; unset($mail);
		$return = $data['_comm_sent'] == 1 ? $data['_comm_code'] : false;
		return $return;
	}
	
	public function sendEmailAdmin($administrator, $message, $subject, $file) {

		// require 'config/smarty.php';
		global $smarty;
		
		require_once('Zend/Mail.php');
		
		$mail = new Zend_Mail();
		
		$data						= array();
		$data['_comm_code']	= $this->createReference();
		
		$smarty->assign('tracking', $data['_comm_code']);
		$smarty->assign('administrator', $administrator);
		$smarty->assign('message', $message);
		$smarty->assign('domain', $_SERVER['HTTP_HOST']);
				
		$template = $smarty->fetch($file);
		
		$mail->setFrom($administrator['campaign_email'], $administrator['campaign_name']); //EDIT!!											
		$mail->addTo($administrator['administrator_email']);
		$mail->setSubject($subject);
		$mail->setBodyHtml($template);			

		/* Save data to the comm table. */
		$data['administrator_code']	= $administrator['administrator_code'];
		$data['_comm_type']				= 'EMAIL';
		$data['_comm_name']			= $administrator['administrator_name'].' '.$administrator['administrator_surname'];
		$data['_comm_sent']				= null;
		$data['_comm_email']			= $administrator['administrator_email'];
		$data['_comm_cell']				= $administrator['administrator_cellphone'];
		$data['_comm_html']				= $template;
		$data['_comm_reference']		= isset($administrator['_comm_reference']) ? $administrator['_comm_reference'] : null;
		$data['_custom_category'] 		= isset($administrator['_custom_category']) ? $administrator['_custom_category'] : null;
		$data['_custom_reference'] 	= isset($administrator['_custom_reference']) ? $administrator['_custom_reference'] : null;
				
		$this->insert($data);

		try {
			$mail->send();
			$data['_comm_sent']	= 1;	
			$data['_comm_output']	= 'Email Sent!';
			
		} catch (Exception $e) {
			$data['_comm_sent']		= 0;	
			$data['_comm_output']	= $e->getMessage();
		}
		
		$where = $this->getAdapter()->quoteInto('_comm_code = ?', $data['_comm_code']);
		$success = $this->update($data, $where);
		
		$mail = null; unset($mail);
		$return = $data['_comm_sent'] == 1 ? $data['_comm_code'] : false;
		return $return;
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($reference)
	{
		$select = $this->_db->select()	
						->from(array('_comm' => '_comm'))		
					   ->where('_comm_code = ?', $reference)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;				   		
	}
	
	public function getCampaignSMSDetails() {
		
		$select = "select 
							pci.campaign_code,	
							pci._productpriceitem_code,
							ppi._productprice_code,
							ifnull(_c.sms_count_sent, 0) sms_count_sent,
							(ifnull(_c.sms_count_sent, 0) * ppi._productpriceitem_price) sms_sent_cost,
							sum(pci._productcampaignitem_count) sms_count_total,
							(sum(pci._productcampaignitem_count) * ppi._productpriceitem_price) sms_total_cost,
							sum(pci._productcampaignitem_count) - ifnull(_c.sms_count_sent, 0) sms_count_remainding
						from 
							_productcampaignitem pci
								left join (select campaign_code,	count(_comm_code) sms_count_sent from _comm where campaign_code = ? and _comm_sent = 1 and _comm_type = 'SMS' group by campaign_code) _c on _c.campaign_code = pci.campaign_code,
							_productpriceitem ppi,
							_productprice pp
						where 
							pci.campaign_code = ?
							and ppi._productpriceitem_code = pci._productpriceitem_code
							and ppi._productprice_code = 'SMS'
							and pp._productprice_code = ppi._productprice_code
							and ppi._productpriceitem_active = 1 and ppi._productpriceitem_deleted = 0
							and pp._productprice_active = 1 and pp._productprice_deleted = 0
							and pci._productcampaignitem_active = 1 and pci._productcampaignitem_deleted = 0
						group by
							pci.campaign_code,	
							pci._productpriceitem_code,
							ppi._productprice_code;";
							
	   $result = $this->_db->fetchRow($select, array($this->_campaign->_campaigncode, $this->_campaign->_campaigncode));
       return ($result == false) ? false : $result = $result;
	   
	}
	
	public function getCampaignEmailDetails() {
		
		$select = "select 
							pci.campaign_code,	
							pci._productpriceitem_code,
							ppi._productprice_code,
							ifnull(_c.email_count_sent, 0) email_count_sent,
							(ifnull(_c.email_count_sent, 0) * ppi._productpriceitem_price) email_sent_cost,
							sum(pci._productcampaignitem_count) email_count_total,
							(sum(pci._productcampaignitem_count) * ppi._productpriceitem_price) email_total_cost,
							sum(pci._productcampaignitem_count) - ifnull(_c.email_count_sent, 0) email_count_remainding
						from 
							_productcampaignitem pci
								left join (select campaign_code,	count(_comm_code) email_count_sent from _comm where campaign_code = ? and _comm_sent = 1 group by campaign_code) _c on _c.campaign_code = pci.campaign_code,
							_productpriceitem ppi,
							_productprice pp
						where 
							pci.campaign_code = ?
							and ppi._productpriceitem_code = pci._productpriceitem_code
							and ppi._productprice_code = 'VJMU'
							and pp._productprice_code = ppi._productprice_code 
							and ppi._productpriceitem_active = 1 and ppi._productpriceitem_deleted = 0
							and pp._productprice_active = 1 and pp._productprice_deleted = 0
							and pci._productcampaignitem_active = 1 and pci._productcampaignitem_deleted = 0							
						group by
							pci.campaign_code,	
							pci._productpriceitem_code,
							ppi._productprice_code;";
							
	   $result = $this->_db->fetchRow($select, array($this->_campaign->_campaigncode, $this->_campaign->_campaigncode));
       return ($result == false) ? false : $result = $result;
	   
	}
	
	function createReference() {
		/* New reference. */
		$reference = "";
		$codeAlphabet = "123456789";

		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<15;$i++) {
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

	function reference() {
		return date('Y-m-d-H:i:s');
	}	
}
?>