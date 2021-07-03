<?php
/**
 * This class uses the Zend Framework :
 * @package    Zend_Db
 * This class is used for all standard enquirys functions, both singleton and collection
 * Created: 05 May 2009
 * Author: Rafeeqah Mollagee
 */


//custom enquiry item class as enquiry table abstraction
class class_enquiry extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name = 'enquiry';
	protected $_primary = 'enquiry_code';
	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 

	 public function insert(array $data)
    {
        // add a timestamp
        $data['enquiry_added'] = date('Y-m-d H:i:s');
        $data['enquiry_code'] = $this->createReference();

		$success = parent::insert($data);
		
		if($success) {
			
			$enquiryData = $this->getByCode($success);
			
			$this->mailbok($enquiryData, 'add');
		}
		
		return $success;
    }

	public function mailbok(array $data, $type = 'add') {
		
		$url = "http://www.mailbok.co.za/webservice/paticipant";
		$content = '';
		$data = array(
			'username' => 'info@nolali.co.za',
			'password' => 'fcslva',
			'client' => '81768825', 
			'subscriber_name' => $data['enquiry_name'],
			'subscriber_surname' => '',
			'subscriber_email' => $data['enquiry_email'],
			'subscriber_cellphone' => '',
			'subscriber_reference' => $data['enquiry_code'],
			'type' => $type
		);

		foreach($data as $key=>$value) { $content .= $key.'='.$value.'&'; }

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

		$json_response = curl_exec($curl);

		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		curl_close($curl);

		return json_decode($json_response, true);			
			
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
        $data['enquiry_updated'] = date('Y-m-d H:i:s');

        return parent::update($data, $where);
    }
	
	public function remove($id) {
		return $this->delete('enquiry_code = '.$id);		
	}
	
	/**
	 * get enquiry by enquiry Account Id
 	 * @param string enquiry id
     * @return object
	 */
	public function getByCode($code)
	{		   				
			$select = $this->_db->select()	
							->from(array('enquiry' => 'enquiry'))
							->where('enquiry_code = ?', $code)
							->where('enquiry_deleted = 0')
							->limit(1);								
	   $result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;
	}
	
	function getCode($code) {
	
		$select = $this->_db->select()	
						->from(array('enquiry' => 'enquiry'))
						->where('enquiry_code = ?', $code)
						->limit(1);				
							
		$result = $this->_db->fetchRow($select);
        return ($result == false) ? false : $result = $result;	
	}
	
	function createReference() {
		/* New reference. */
		$reference = "";
		$codeAlphabet = "0123456789";
		$count = strlen($codeAlphabet) - 1;
		
		for($i=0;$i<3;$i++){
			$reference .= $codeAlphabet[rand(0,$count)];
		}

		$reference .= time();

		/* First check if it exists or not. */
		$itemCheck = $this->getCode($reference);
		
		if($itemCheck) {
			/* It exists. check again. */
			$this->createReference();
		} else {
			return $reference;
		}
	}	
	
	public function getAll($where = NULL, $order = NULL)
	{
			if($where == '') $where = 'enquiry_reference != ""';
			
			$select = $this->_db->select()
							->from(array('enquiry' => 'enquiry'))
							->joinLeft('areamap', 'areamap.fkAreaId = enquiry.fk_area_id')	
							->where($where)
							->order($order);
	   $result = $this->_db->fetchAll($select);
        return ($result == false) ? false : $result = $result;
	}	
}
?>