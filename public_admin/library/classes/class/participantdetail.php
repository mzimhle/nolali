<?php

//custom account item class as account table abstraction
class class_participantdetail extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name	= 'participantdetail';
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data) {
        // add a timestamp
        $data['participantdetail_added'] = date('Y-m-d H:i:s');
		$data['participantdetail_code']	= $this->createReference();

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
        $data['participantdetail_updated'] = date('Y-m-d H:i:s');

        return parent::update($data, $where);
    }
	
	public function remove($code) {
		return $this->delete('participantdetail_code = ?', $code);		
	}
	
	/**
	 * get job by job participantdetail Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		
		$select = $this->_db->select()	
					->from(array('participantdetail' => 'participantdetail'))
					->joinLeft(array('participant' => 'participant'), 'participant.participant_code = participantdetail.participant_code')
					->where('participantdetail_code = ?', $code)
					->where('participantdetail_deleted = 0')
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	public function getByParticipantCode($code) {
		
		$select = $this->_db->select()	
					->from(array('participantdetail' => 'participantdetail'))
					->joinLeft(array('participant' => 'participant'), 'participant.participant_code = participantdetail.participant_code')
					->where('participantdetail.participant_code = ?', $code)
					->where('participantdetail_deleted = 0');

	   $result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;	
	}
	
	public function getAll($where = NULL, $order = NULL) {
		
		$select = $this->_db->select()	
					->from(array('participantdetail' => 'participantdetail'))
					->joinLeft(array('participant' => 'participant'), 'participant.participant_code = participantdetail.participant_code')
					->joinLeft(array('campaigntype' => 'campaigntype'), 'campaigntype.campaigntype_code = campaign.campaigntype_code')
					->where('participantdetail_deleted = 0')
					->where($where)
					->order($order);						
						
        $result = $this->_db->fetchAll($select);
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
						->from(array('participantdetail' => 'participantdetail'))
					   ->where('participantdetail_code = ?', $reference)
					   ->limit(1);

	   $result = $this->_db->fetchRow($select);	
        return ($result == false) ? false : $result = $result;					   
	}
	
	function createReference() {
		/* New reference. */
		$reference = "";
		$codeAlphabet = '123456789';
		
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