<?php

//custom account item class as account table abstraction
class class_campaignpackage extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name		= '_campaignpackage';
	protected $_primary	= '_campaignpackage_code';
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	public function insert(array $data) {
        // add a timestamp
        $data['_campaignpackage_added']		= date('Y-m-d H:i:s');
        $data['_campaignpackage_code']		= $this->createCode();
		
		if((isset($data['campaign_code']) && trim($data['campaign_code']) != '') && 
				(isset($data['_package_code']) && trim($data['_package_code']) != '')) {
			
			$campaignpackageData = $this->getByCampaignPackage($data['campaign_code'], $data['_package_code']);

			if($campaignpackageData) {
				
				/* Increase id to the latest one. */
				$data['_campaignpackage_id'] = $campaignpackageData['_campaignpackage_id']+1;
				
				/* Update previous item. */
				$udata = array();
				$udata['_campaignpackage_active'] = 0;
				
				$where	= $this->getAdapter()->quoteInto('_campaignpackage_code = ?', $campaignpackageData['_campaignpackage_code']);
				$this->update($udata, $where);	
			
			}
		} else {
			return false;
		}
		
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
         $data['_campaignpackage_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByCampaignPackage($campaign, $package) {
	
		$select = $this->_db->select()	
							->from(array('_campaignpackage' => '_campaignpackage'), array('_campaignpackage_code', 'campaign_code', '_package_code', '_campaignpackage_added', '_campaignpackage_updated', '_campaignpackage_active', '_campaignpackage_deleted', new Zend_Db_Expr("MAX(_campaignpackage_id) AS _campaignpackage_id")))
							->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = _campaignpackage.campaign_code')	
							->joinLeft(array('_package' => '_package'), '_package._package_code = _campaignpackage._package_code')		
							->where('_campaignpackage_deleted = 0 and campaign_deleted = 0 and _package_deleted = 0')							
							->where('_campaignpackage_active = 1')
							->where('_campaignpackage.campaign_code = ?', $campaign)
							->where('_campaignpackage._package_code = ?', $package)
							->group('_campaignpackage.campaign_code')
							->limit(1);
							
		$result = $this->_db->fetchRow($select);	   
		return ($result == false) ? false : $result = $result;
		
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByCampaign($campaign) {
		
		$select = $this->_db->select()	
					->from(array('_campaignpackage' => '_campaignpackage'))
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = _campaignpackage.campaign_code')	
					->joinLeft(array('_package' => '_package'), '_package._package_code = _campaignpackage._package_code')	
					->where('_campaignpackage_deleted = 0 and campaign_deleted = 0 and _package_deleted = 0')
					->where('_campaignpackage.campaign_code = ?', $campaign);

		$result = $this->_db->fetchAll($select);	   
		return ($result == false) ? false : $result = $result;
		
	}
	
	public function getCampaignComponents($campaign, $producttype) {
		
		$select = $this->_db->select()	
							->from(array('_campaignpackage' => '_campaignpackage'))
							->joinLeft(array('_component' => '_component'), '_component._package_code = _campaignpackage._package_code')
							->joinLeft(array('_product' => '_product'), '_product._product_code = _component._product_code')
							->where('_campaignpackage_deleted = 0 and _component_deleted = 0 and _product_deleted = 0')							
							->where('_campaignpackage_active = 1 and _component_active = 1 and _product_active = 1')		
							->where('_campaignpackage.campaign_code = ?', $campaign)
							->where('_product._product_type = ?', $producttype);

		$result = $this->_db->fetchAll($select);	   
		return ($result == false) ? false : $result = $result;		
		
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByCode($code) {
		$select = $this->_db->select()	
						->from(array('_campaignpackage' => '_campaignpackage'))
						->where('_campaignpackage_deleted = 0')
					   ->where('_campaignpackage._campaignpackage_code = ?', $code)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
       return ($result == false) ? false : $result = $result;					   
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getCode($code) {
		$select = $this->_db->select()	
						->from(array('_campaignpackage' => '_campaignpackage'))	
					   ->where('_campaignpackage_code = ?', $code)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
       return ($result == false) ? false : $result = $result;					   
	}
	
	function createCode() {
		/* New reference. 
		$reference = "";
		$codeAlphabet = '123456789';
		
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<5;$i++){
			$reference .= $codeAlphabet[rand(0,$count)];
		}
		*/
		
		$reference = time();
		
		/* First check if it exists or not. */
		$itemCheck = $this->getCode($reference);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createCode();
		} else {
			return $reference;
		}
	}

}
?>