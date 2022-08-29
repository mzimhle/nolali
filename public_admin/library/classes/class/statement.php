<?php
//custom recruiter item class as recruiter table abstraction
class class_statement extends Zend_Db_Table_Abstract {
   //declare table variables
    protected $_name 		= 'statement';
	protected $_primary 	= 'statement_id';

	public	$_comm		    = null;
	public	$_config        = null;
    public	$_entity       	= null;
    public  $_file          = null;
    public  $_bankentity	= null;

	function init()	{
		global $zfsession;
		$this->_config      = $zfsession->config;
        $this->_entity     	= $zfsession->entity;
        $this->_file        = new File(array('csv', 'ofx', 'xls'));
	}
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	public function insert(array $data) {
        // add a timestamp
        $data['statement_added']	= date('Y-m-d H:i:s');
        $data['entity_id']			= $this->_entity;

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
        $data['statement_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	/**
	 * get job by job statement Id
 	 * @param string job id
     * @return object
	 */
	public function getById($id) {

		$select = $this->_db->select()
			->from(array('statement' => 'statement'))
            ->joinInner(array('entity' => 'entity'), 'entity.entity_id = statement.entity_id')
            ->joinInner(array('bankentity' => 'bankentity'), 'bankentity.bankentity_id = statement.bankentity_id')
            ->joinLeft(array('section' => 'section'), 'section_deleted = 0 and section.section_id = statement.section_id')
            ->joinLeft(array('invoice' => 'invoice'), 'invoice_deleted = 0 and invoice.invoice_id = statement.invoice_id')
			->joinLeft(array('inventory' => 'inventory'), 'inventory_deleted = 0 and inventory.inventory_id = statement.inventory_id', array('product_id', 'inventory_amount', 'inventory_quantity', 'inventory_file_name', 'inventory_file_path', 'inventory_added'))
			->joinLeft(array('product' => 'product'), 'product_deleted = 0 and product.product_id = inventory.product_id', array('product_name'))
			->joinLeft(array('participant' => 'participant'), 'participant_deleted = 0 and invoice.participant_id = participant.participant_id', array('participant_name', 'participant_address', 'participant_cellphone'))
			->where('statement_deleted = 0 and entity_deleted = 0 and bankentity_deleted = 0 and statement.entity_id = ?', $this->_entity)
            ->where('statement.statement_id = ?', $id)
			->limit(1);		

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;		
	}

	/**
	 * get job by job statement Id
 	 * @param string job id
     * @return object
	 */
	public function getByInvoice($id) {

		$select = $this->_db->select()
			->from(array('statement' => 'statement'))
			->joinInner(array('invoice' => 'invoice'), 'invoice_deleted = 0 and invoice.invoice_id = statement.invoice_id')
			->joinInner(array('participant' => 'participant'), 'participant_deleted = 0 and invoice.participant_id = participant.participant_id', array('participant_name', 'participant_address', 'participant_cellphone'))				
            ->joinInner(array('entity' => 'entity'), 'entity.entity_id = statement.entity_id')
            ->joinInner(array('bankentity' => 'bankentity'), 'bankentity.bankentity_id = statement.bankentity_id')
            ->joinLeft(array('section' => 'section'), 'section_deleted = 0 and section.section_id = statement.section_id')            
			->where('statement_deleted = 0 and entity_deleted = 0 and bankentity_deleted = 0 and statement.entity_id = ?', $this->_entity)
            ->where('statement.invoice_id = ?', $id);		

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;		
	}

    public function checkDuplicate($bankentityid, $date, $amount, $balance, $reference, $text) {
		$select = $this->_db->select()
			->from(array('statement' => 'statement'))
			->where('statement_deleted = 0 and statement.entity_id = ?', $this->_entity)
            ->where('statement.statement_date = ?', $date)
            ->where('statement.bankentity_id = ?', $bankentityid)
            ->where('statement.statement_amount = ?', $amount)            
            ->where('statement.statement_reference = ?', $reference)
            ->where('statement.statement_text = ?', $text)            
			->limit(1);		

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;	
    }
	
    public function getBatches() {
		$select = $this->_db->select()
			->from(array('statement' => 'statement'), array('statement_batch'))->distinct()
			->where('statement_deleted = 0 and statement.entity_id = ?', $this->_entity);	

		$result = $this->_db->fetchCol($select);
		return ($result == false) ? false : $result = $result;	
    }
	
    public function getBatchesPairs() {
		$select = $this->_db->select()
			->from(array('statement' => 'statement'), array('statement_batch', 'statement_batch'))->distinct()
			->where('statement_deleted = 0 and statement.entity_id = ?', $this->_entity);	

		$result = $this->_db->fetchPairs($select);
		return ($result == false) ? false : $result = $result;	
    }
	
    /**
	 * get job by job template Id
 	 * @param string job id
     * @return object
	 */
	public function paginate($start, $length, $filter = array()) {
	
		$where	= 'statement_deleted = 0';
		$csv	= 0;

		if(count($filter) > 0) {
			for($i = 0; $i < count($filter); $i++) {
				if(isset($filter[$i]['filter_search']) && trim($filter[$i]['filter_search']) != '') {
					$array = explode(" ",trim($filter[$i]['filter_search']));					
					if(count($array) > 0) {
						$where .= " and (";
						for($s = 0; $s < count($array); $s++) {
							$text = $array[$s];
							$this->sanitize($text);
							$where .= "lower(statement_text) like lower('%$text%')";
							if(($s+1) != count($array)) {
								$where .= ' or ';
							}
						}
					}
					$where .= ")";
				} else if(isset($filter[$i]['filter_entity']) && trim($filter[$i]['filter_entity']) != '') {
					$text = trim($filter[$i]['filter_entity']);
					$this->sanitize($text);
					$where .= " and bankentity.bankentity_id = $text";
				} else if(isset($filter[$i]['filter_batch']) && trim($filter[$i]['filter_batch']) != '') {
					$text = trim($filter[$i]['filter_batch']);
					$where .= " and statement.statement_batch = '$text'";
				} else if(isset($filter[$i]['filter_date_start']) && trim($filter[$i]['filter_date_start']) != '') {
					$text = trim($filter[$i]['filter_date_start']);
					$where .= " and statement.statement_date >= '$text'";
				} else if(isset($filter[$i]['filter_date_end']) && trim($filter[$i]['filter_date_end']) != '') {
					$text = trim($filter[$i]['filter_date_end']);
					$where .= " and statement.statement_date <= '$text'";						
				} else if(isset($filter[$i]['filter_categorised']) && trim($filter[$i]['filter_categorised']) != '') {
					$text = trim($filter[$i]['filter_categorised']);
					$this->sanitize($text);
					if((int)$text == 0) {
						$where .= " and (statement.section_id = '' or statement.section_id = null or statement.section_id is null)";	
					} else if((int)$text == 1) {
						$where .= " and (statement.section_id != '' or statement.section_id != null or statement.section_id is not null)";	
					}
				}
			}
		}

		$select = $this->_db->select()
			->from(array('statement' => 'statement'))
            ->joinInner(array('entity' => 'entity'), 'entity.entity_id = statement.entity_id', array())
            ->joinInner(array('bankentity' => 'bankentity'), 'bankentity.bankentity_id = statement.bankentity_id', array('bankentity_name'))
            ->joinLeft(array('section' => 'section'), 'section_deleted = 0 and section.section_id = statement.section_id', array('section_name', 'section_code'))
			->joinLeft(array('invoice' => 'invoice'), 'invoice_deleted = 0 and invoice.invoice_id = statement.invoice_id', array('invoice_code'))
			->joinLeft(array('inventory' => 'inventory'), 'inventory_deleted = 0 and inventory.inventory_id = statement.inventory_id', array('product_id', 'inventory_amount', 'inventory_quantity', 'inventory_file_name', 'inventory_file_path', 'inventory_added'))
			->joinLeft(array('product' => 'product'), 'product_deleted = 0 and product.product_id = inventory.product_id', array('product_name'))
			->joinLeft(array('participant' => 'participant'), 'participant_deleted = 0 and invoice.participant_id = participant.participant_id', array('participant_name', 'participant_address', 'participant_cellphone'))
			->where('statement_deleted = 0 and entity_deleted = 0 and bankentity_deleted = 0 and statement.entity_id = ?', $this->_entity)
			->where($where)
			->order('statement_id asc');

		if($csv) {
			$result = $this->_db->fetchAll($select);
			return ($result == false) ? false : $result = $result;	
		} else {
			$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");
			$result = $this->_db->fetchAll($select . " limit $start, $length");
			return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);
		}
	}	

	public function validateDate($string) {
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$string)) {
            return $string;
        } else {
            return '';
        }
	}
    
    function isDate($value) {
        if (!$value) {
            return false;
        }

        try {
            new \DateTime($value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    
	public function uploadStatement($file, $bankentityid) {

        $errors = array();
        $format = explode(",", $bankentityData['bank_format']);
        
        $batch  = date('Y-m-d H:i:s');
        if(isset($file['name']) && trim($file['name']) != '') {
            /* Check validity of the file. */
            if((int)$file['size'] != 0 && trim($file['name']) != '') {
                /* Check if its the right file. */
                $ext = $this->_file->file_extention($file['name']); 

                if($ext != '') {
                    $checkExt = $this->_file->getValidateExtention('uploadfile', $ext);
                    if(!$checkExt) {
                        $errors[] = 'Invalid file type something funny with the file format';
                    }
                } else {
                    $errors[] = 'Invalid file type';								
                }
            } else {
                switch((int)$file['error']) {
                    case 1 : $errors[]= 'The uploaded file exceeds the maximum upload file size, should be less than 1M'; break;
                    case 2 : $errors[]= 'File size exceeds the maximum file size'; break;
                    case 3 : $errors[]= 'File was only partically uploaded, please try again'; break;
                    case 4 : $errors[]= 'No file was uploaded'; break;
                    case 6 : $errors[]= 'Missing a temporary folder'; break;
                    case 7 : $errors[]= 'Faild to write file to disk'; break;
                }
            }

            if(count($errors) == 0) {
                
                $duplicate = 0;
                
                switch($ext) {
                    case 'csv':
                    case 'xls':
                    $handle = fopen($file['tmp_name'],"r");					
                    while($line = fgetcsv($handle)) {

                        $continue = true;
                        for($f = 0; $f < count($format); $f++) {
                            if(isset($format[$f]) && isset($line[$f])) {
                                if($format[$f] == 'DATE') {
                                    if(!$this->isDate(trim($line[$f]))) {
                                        $continue = false;
                                    }
                                } else if($format[$f] == 'AMOUNT') {
                                    if(!is_numeric(trim($line[$f]))) {
                                        $continue = false;
                                    }
                                } else if($format[$f] == 'REFERENCE') {
                                    if(!is_string(trim($line[$f]))) {
                                        $continue = false;
                                    }
                                } else if($format[$f] == 'BALANCE') {
                                    if(!is_numeric(trim($line[$f]))) {
                                        $continue = false;
                                    }
                                } else if($format[$f] == 'TEXT') {
                                    if(!is_string(trim($line[$f]))) {
                                        $continue = false;
                                    }
                                }
                            } else {
                                $errors[] = '<p>Something wrong: '.json_encode($line).'</p>';	
                            }
                        }

                        if($continue) {

                            $data						= array();
                            $data['bankentity_id']		= $bankentityid;
                            $data['statement_batch']	= $batch;		
                            $data['statement_date']		= null;	
                            $data['statement_amount']	= 0;	
                            $data['statement_type']		= null;	
                            $data['statement_reference']= '';	
                            $data['statement_balance']	= 0;	
                            $data['statement_text']		= '';	
                            
                            for($f = 0; $f < count($format); $f++) {
                                if($format[$f] == 'DATE' && $this->isDate(trim($line[$f]))) {
                                    $data['statement_date'] = date('Y-m-d', strtotime(trim($line[$f])));
                                } else if($format[$f] == 'AMOUNT') {
                                    $data['statement_amount']	= (float)$line[$f];
                                    $data['statement_type']		= 0 > (float)$line[$f] ? 0 : 1;
                                } else if($format[$f] == 'REFERENCE') {
                                    $data['statement_reference']	= $line[$f];
                                } else if($format[$f] == 'BALANCE') {
                                    $data['statement_balance']   = (float)$line[$f];
                                } else if($format[$f] == 'TEXT') {
                                    $data['statement_text']  = $line[$f];
                                }
                            }
                            // Check duplicates
                            if(!$this->checkDuplicate($data['bankentity_id'], $data['statement_date'], $data['statement_amount'], $data['statement_balance'], $data['statement_reference'], $data['statement_text'])) {
                                // Insert
                                if(!$this->insert($data)) {
                                    $errors[] = '<p>Not inserted: '.json_encode($data).'</p>';									
                                }
                            } else {
                                $duplicate++;
                                $errors[] = '<p>Duplicate: '.json_encode($data).'</p>';	
                            }
                        } else {
                            $errors[] = '<p>Something wrong: '.json_encode($line).'</p>';	
                        }				
                    }
                    // Close the file
                    fclose($handle);
                    break;
                    case 'ofx':
                        $statement = file_get_contents($file['tmp_name']);
                        if($statement !== '') {
                            $statement = str_replace('&', ' and ', $statement);
                            require_once 'library/classes/OfxParser/Parser.php';
                            require_once 'library/classes/OfxParser/Ofx.php';
                            require_once 'library/classes/OfxParser/Entities/SignOn.php';
                            require_once 'library/classes/OfxParser/Entities/AbstractEntity.php';
                            $ofxParseObject = new \OfxParser\Parser();
                            $ofx = $ofxParseObject->loadFromString($statement);

                            $bankentity = reset($ofx->bankAccounts);
                            
                            foreach($bankentity->statement->transactions as $item) {
                                // Error recording
                                $currentError					= '';
                                // Get data
                                $data 							= array();
                                $data['bankentity_id']     		= $bankentityid;
                                $data['statement_batch']		= $batch;
                                $data['statement_date']			= $item->date->format('Y-m-d');
                                $data['statement_amount']   	= (float)$item->amount;
                                $data['statement_type']     	= 0 > (float)$item->amount ? 0 : 1;
                                $data['statement_text']			= $item->name;
                                $data['statement_reference']	= $item->uniqueId;
                                $data['statement_balance']		= 0;

                                // Check for duplicates.
                                if(!$this->checkDuplicate($data['bankentity_id'], $data['statement_date'], $data['statement_amount'], $data['statement_balance'], $data['statement_reference'], $data['statement_text'])) {
                                    // Insert
                                    if(!$this->insert($data)) {
                                        $currentError = 'Not inserted: '.json_encode($data);									
                                    }
                                } else {
                                    $duplicate++;
                                }
                            }
                            if($currentError != '') $errors[] = $currentError;
                        } else {
                            $errors[] = 'File is empty';
                        }
                    break;
                    default: $errors[] = 'Extension not found';
                }
                // Check if there are duplicates
                if($duplicate) $errors[] = 'There are '.$duplicate.' duplicate records';					
            }
        } else {
            $errors[] = 'Please upload a file';
        }

        return $errors;
    }

    function sanitize(&$string) { $string = preg_replace("/[^a-zA-Z0-9_]+/", "", $string);}
	function sanitizeArray(&$array) { for($i = 0; $i < count($array); $i++) { $array[$i] = preg_replace("/[^a-zA-Z0-9_]+/", "", $array[$i]); } }	
}
?>