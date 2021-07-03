<?php

require_once 'campaign.php';
require_once 'galleryimage.php';

//custom account item class as account table abstraction
class class_gallery extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name 			= 'gallery';
	protected $_primary		= 'gallery_code';
		
	public $_campaign			= null;
	public $_galleryimage		= null;
	
	function init()	{
		
		global $zfsession;

		$this->_campaign			= new class_campaign();	
		$this->_galleryimage		= new class_galleryimage();
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
        $data['gallery_added']	= date('Y-m-d H:i:s');
		$data['gallery_code']		= $this->createCode();
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
        $data['gallery_updated'] = date('Y-m-d H:i:s');
        
        return parent::update($data, $where);
    }
	
	/**
	 * get job by job gallery Id
 	 * @param string job id
     * @return object
	 */
	public function getByCode($code)
	{
		
		$select = $this->_db->select()	
					->from(array('gallery' => 'gallery'))	
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = gallery.campaign_code')
					->joinLeft(array('galleryimage' => 'galleryimage'), 'galleryimage.gallery_code = gallery.gallery_code and galleryimage_primary = 1 and galleryimage_deleted = 0', array('galleryimage_filename', 'galleryimage_primary', 'galleryimage_extension', 'galleryimage_path', 'galleryimage_code'))
					->where('gallery_deleted = 0')
					->where('gallery.gallery_code = ?', $code)
					->where($this->_campaign->_campaignsql)
					->limit(1);
       
	   $result = $this->_db->fetchRow($select);
	   
		if($result) {
			$result['images']	= $this->_galleryimage->getByGallery($result['gallery_code']);
		}
		
        return ($result == false) ? false : $result = $result;

	}	
	
	public function getAll()
	{
		$select = $this->_db->select()	
					->from(array('gallery' => 'gallery'))
					->joinLeft(array('campaign' => 'campaign'), 'campaign.campaign_code = gallery.campaign_code')	
					->joinLeft(array('galleryimage' => 'galleryimage'), 'galleryimage.gallery_code = gallery.gallery_code and galleryimage_primary = 1 and galleryimage_deleted = 0', array('galleryimage_filename', 'galleryimage_primary', 'galleryimage_extension', 'galleryimage_path', 'galleryimage_code'))
					->where('gallery_deleted = 0')				
					->where($this->_campaign->_campaignsql)
					->order('gallery_name desc');
						
		$result = $this->_db->fetchAll($select);
	   
		if($result) {
			for($i = 0; $i < count($result); $i++) {
				$result[$i]['images']	= $this->_galleryimage->getByGallery($result[$i]['gallery_code']);
			}
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
					->from(array('gallery' => 'gallery'))	
					   ->where('gallery_code = ?', $code)
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
}
?>