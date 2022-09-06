<?php
//custom recruiter item class as recruiter table abstraction
class class_product extends Zend_Db_Table_Abstract {
   //declare table variables
    protected $_name 		= 'product';
	protected $_primary 	= 'product_id';

	public $_entity    = null;
    public $_activeentity    = null;
	
	function init()	{
		global $zfsession;
		$this->_entity	= isset($zfsession->entity) ? $zfsession->entity : 0;
		$this->_account	= isset($zfsession->entity) ? $zfsession->activeEntity['account_id'] : $zfsession->account;        
	}

	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	 public function insert(array $data) {
        // add a timestamp
        $data['product_added']	= date('Y-m-d H:i:s');
        $data['entity_id']		= $this->_entity;
        $data['account_id']		= $this->_account;        
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
        $data['product_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	/**
	 * get job by job product Id
 	 * @param string job id
     * @return object
	 */
	public function getById($id) {

		$items = $this->_db->select()
			->from(array('price' => 'price'), array('price.product_id'))
			->joinInner(array('invoiceitem' => 'invoiceitem'), "invoiceitem.price_id = price.price_id", array('ifnull(sum(invoiceitem_quantity),0) as product_quantity'))
			->where('price_deleted = 0 and invoiceitem_deleted = 0 and product_id = ?', $id)
			->group('price.product_id');

		$select = $this->_db->select()
			->from(array('product' => 'product'))
			->joinLeft(array('inventory' => 'inventory'), "inventory_deleted = 0 and inventory.product_id = product.product_id and product_deleted = 0 and product_type = 'ITEM'", array('ifnull(sum(inventory_quantity), 0) as inventory_quantity'))
			->joinLeft(array('items' => $items), 'items.product_id = product.product_id', array('ifnull(product_quantity,0) as product_quantity', 'ifnull(sum(inventory_quantity)-ifnull(product_quantity,0), 0) as product_left'))
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and product.product_id = media.media_item_id and media.media_item_type = 'PRODUCT' and media.media_primary = 1", array('media_code', 'media_path', 'media_ext'))
			->where('product_deleted = 0 and product.entity_id = ?', $this->_entity)
            ->where('product_deleted = 0 and product.account_id = ?', $this->_account)
			->where('product.product_id = ?', $id)
			->group('product.product_id')
			->limit(1);		

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;
	}
	/**
	 * get job by job product Id
 	 * @param string job id
     * @return object
	 */
	public function getAll() {

		$items = $this->_db->select()
			->from(array('price' => 'price'), array('price.product_id'))
			->joinInner(array('invoiceitem' => 'invoiceitem'), "invoiceitem.price_id = price.price_id", array('ifnull(sum(invoiceitem_quantity),0) as product_quantity'))
			->where('price_deleted = 0 and invoiceitem_deleted = 0')
			->group('price.product_id');

		$select = $this->_db->select()
			->from(array('product' => 'product'))	
			->joinLeft(array('price' => 'price'), "price.product_id = product.product_id and price_deleted = 0 and price_primary = 1 and price_active = 1", array('price_amount'))            
			->joinLeft(array('inventory' => 'inventory'), "inventory.product_id = product.product_id and product_deleted = 0 and product_type = 'ITEM'", array('ifnull(sum(inventory_quantity), 0) as inventory_quantity'))
			->joinLeft(array('items' => $items), 'items.product_id = product.product_id', array('ifnull(product_quantity,0) as product_quantity', 'ifnull(sum(inventory_quantity)-ifnull(product_quantity,0), 0) as product_left'))
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and product.product_id = media.media_item_id and media.media_item_type = 'PRODUCT' and media.media_primary = 1", array('media_code', 'media_path', 'media_ext'))			
			->where('product_deleted = 0 and product.entity_id = ?', $this->_entity)
            ->where('product.account_id = ?', $this->_account)            
			->group('product.product_id');

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;		
	}	
	/**
	 * get job by job template Id
 	 * @param string job id
     * @return object
	 */
	public function paginate($start, $length, $filter = array()) {
	
		$where	= 'product_deleted = 0';

		if(count($filter) > 0) {
			for($i = 0; $i < count($filter); $i++) {
				if(isset($filter[$i]['filter_search']) && trim($filter[$i]['filter_search']) != '') {
					$array = explode(" ",trim($filter[$i]['filter_search']));					
					if(count($array) > 0) {
						$where .= " and (";
						for($s = 0; $s < count($array); $s++) {
							$text = $array[$s];
							$this->sanitize($text);
							$where .= "lower(product_name) like lower('%$text%')";
							if(($s+1) != count($array)) {
								$where .= ' or ';
							}
						}
					}
					$where .= ")";
				} else if(isset($filter[$i]['filter_type']) && trim($filter[$i]['filter_type']) != '') {
                    $text = trim($filter[$i]['filter_type']);
                    $this->sanitize($text);
                    $text = "'".str_replace(',', "','", $text)."'";
                    $where .= " and product_type in($text)";
				} else if(isset($filter[$i]['filter_account']) && trim($filter[$i]['filter_account']) != '') {
                    $text = trim($filter[$i]['filter_account']);
                    $this->sanitize($text);
                    $where .= " and account_id = $text";
				} else if(isset($filter[$i]['filter_entity']) && trim($filter[$i]['filter_entity']) != '') {
                    $text = trim($filter[$i]['filter_entity']);
                    $this->sanitize($text);
                    $where .= " and entity_id = $text";
				}
			}
		}

		$items = $this->_db->select()
			->from(array('price' => 'price'), array('price.product_id'))
			->joinInner(array('invoiceitem' => 'invoiceitem'), "invoiceitem.price_id = price.price_id", array('ifnull(sum(invoiceitem_quantity),0) as product_quantity'))
			->joinInner(array('invoice' => 'invoice'), "invoice.invoice_id = invoiceitem.invoice_id", array())
			->where('price_deleted = 0 and invoiceitem_deleted = 0 and invoice_deleted = 0 and invoice.entity_id = ?', $this->_entity)
			->group('price.product_id');

		$select = $this->_db->select()
			->from(array('product' => 'product'))		
			->joinLeft(array('inventory' => 'inventory'), "inventory.product_id = product.product_id and inventory_deleted = 0 and product_type = 'ITEM'", array('ifnull(sum(inventory_quantity), 0) as inventory_quantity'))
			->joinLeft(array('items' => $items), 'items.product_id = product.product_id', array('ifnull(product_quantity,0) as product_quantity', 'ifnull(sum(inventory_quantity)-ifnull(product_quantity,0), 0) as product_left'))
			->joinLeft(array('price' => 'price'), "price.product_id = product.product_id and price_deleted = 0 and price_primary = 1 and price_active = 1", array('price_amount'))
			->joinLeft(array('media' => 'media'), "media.media_category = 'IMAGE' and product.product_id = media.media_item_id and media.media_item_type = 'PRODUCT' and media.media_primary = 1", array('media_code', 'media_path', 'media_ext'))			
            ->where('product_deleted = 0')            
			->where($where)
			->group('product.product_id')
			->order('product_name desc');

		$result_count = $this->_db->fetchRow("select count(*) as query_count from ($select) as query");
		$result = $this->_db->fetchAll($select . " limit $start, $length");
		return ($result === false) ? false : $result = array('count'=>$result_count['query_count'],'displayrecords'=>count($result),'records'=>$result);

	}	

	/**
	 * get job by job participant Id
 	 * @param string job id
     * @return object
	 */	
	public function search($type, $query, $limit = 20) {

		$items = $this->_db->select()
			->from(array('price' => 'price'), array('price.product_id'))
			->joinInner(array('invoiceitem' => 'invoiceitem'), "invoiceitem.price_id = price.price_id", array('ifnull(sum(invoiceitem_quantity),0) as product_quantity'))
			->joinInner(array('invoice' => 'invoice'), "invoice.invoice_id = invoiceitem.invoice_id", array())
			->where('price_deleted = 0 and invoiceitem_deleted = 0 and invoice_deleted = 0 and invoice.entity_id = ?', $this->_entity)
			->group('price.product_id');

		$select = $this->_db->select()
			->from(array('product' => 'product'))
			->joinLeft(array('inventory' => 'inventory'), "inventory.product_id = product.product_id and inventory_deleted = 0 and product_type = 'ITEM'", array('ifnull(sum(inventory_quantity), 0) as inventory_quantity'))
			->joinLeft(array('items' => $items), 'items.product_id = product.product_id', array('ifnull(product_quantity,0) as product_quantity', 'ifnull(sum(inventory_quantity)-ifnull(product_quantity,0), 0) as product_left'))
			->joinLeft(array('price' => 'price'), "price.product_id = product.product_id and price_deleted = 0 and price_primary = 1 and price_active = 1", array('price_amount', 'price_id'))            
			->where('product_deleted = 0 and product.entity_id = ?', $this->_entity)
            ->where('product_type = ?', $type)
            ->where('product_deleted = 0 and product.account_id = ?', $this->_account)            
			->where("lower(concat(product_name)) like lower(?)", "%$query%")
			->limit($limit)
			->group('product.product_id')			
			->order("LOCATE('$query', product_name)");

		$result = $this->_db->fetchAll($select);	
        return ($result == false) ? false : $result = $result;					
	}

	/**
	 * get job by job participant Id
 	 * @param string job id
     * @return object
	 */	
	public function rooms($query, $limit = 20) {

		$select = $this->_db->select()
			->from(array('product' => 'product'))
			->joinInner(array('price' => 'price'), "price.product_id = product.product_id and price_deleted = 0")
			->where("product_type = 'ROOM' and product.entity_id = ?", $this->_entity)
            ->where('product_deleted = 0 and product.account_id = ?', $this->_account)            
			->where("lower(concat(product_name)) like lower(?)", "%$query%")
			->limit($limit)
			->order("LOCATE('$query', product_name)");

		$result = $this->_db->fetchAll($select);	
        return ($result == false) ? false : $result = $result;					
	}
	
    function sanitize(&$string) { $string = preg_replace("/[^a-zA-Z0-9_,]+/", "", $string);}
    function sanitizeArray(&$array) { for($i = 0; $i < count($array); $i++) { $array[$i] = preg_replace("/[^a-zA-Z0-9_]+/", "", $array[$i]); } }	
}
?>