<?php

//custom account item class as account table abstraction
class class_price extends Zend_Db_Table_Abstract
{
   //declare table variables
    protected $_name	= 'price';
	protected $_primary	= 'price_id';	
	/**
	 * Insert the database record
	 * example: $table->insert($data);
	 * @param array $data
     * @return boolean
	 */ 
	public function insert(array $data) {
        // add a timestamp
        $data['price_added']		= date('Y-m-d H:i:s');
		$data['price_quantity']		= isset($data['price_quantity']) ? $data['price_quantity'] : 1;
		$data['price_discount']		= isset($data['price_discount']) ? $data['price_discount'] : 0;
		$data['price_amount']		= (int)$data['price_discount'] != 0 ? $data['price_original']-(((int)$data['price_discount']/100)*$data['price_original']): $data['price_original'];

		$priceData = $this->getPrice($data['product_id'], $data['price_quantity'], $data['price_discount']);

		if($priceData) {
			/* Increase id to the latest one. */
			$data['price_index'] = $priceData['price_index']+1;
			/* Update previous item. */
			$udata						= array();
			$udata['price_date_end']    = date('Y-m-d H:i:s');
			$udata['price_active'] 		= 0;
			$udata['price_primary']     = 0;
			/* Update the price */
			$where	= $this->getAdapter()->quoteInto('price_id = ?', $priceData['price_id']);
			$this->update($udata, $where);	
		}
		/* Check if there is a primary price already. */
		$primaryData = $this->getPrimary($data['product_id']);
		if(!$primaryData) $data['price_primary'] = 1;

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
		$data['price_updated'] = date('Y-m-d H:i:s');
        return parent::update($data, $where);
    }
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getPrice($product, $quantity, $discount) {
		$select = $this->_db->select()	
			->from(array('price' => 'price'))
			->where('price.product_id = ?', $product)		
			->where('price.price_quantity = ?', $quantity)
			->where('price.price_discount = ?', $discount)			
			->where('price.price_active = 1');

		$result = $this->_db->fetchRow($select);	   
		return ($result == false) ? false : $result = $result;
	}	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getPrimary($product) {
		$select = $this->_db->select()	
			->from(array('price' => 'price'))
			->where('product_id = ?', $product)			
			->where('price_primary = 1 and price_active = 1 and price_deleted = 0');

		$result = $this->_db->fetchRow($select);	   
		return ($result == false) ? false : $result = $result;
	}

	public function updatePrimary($product, $id) {

		$item = $this->getPrimary($product);

		if($item) {

			$data					= array();
			$where					= array();
			$data['price_primary']	= 0;

			$where[]	= $this->getAdapter()->quoteInto('product_id = ?', $product);
			$success	= $this->update($data, $where);				
		}

		$data					= array();
		$data['price_primary']	= 1;

		$where		= $this->getAdapter()->quoteInto('price_id = ?', $id);
		return $this->update($data, $where);
	}
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getByProduct($id) {
		$select = $this->_db->select()	
			->from(array('price' => 'price'))
			->joinInner(array('product' => 'product'), "product.product_id = price.product_id")					
			->where('price_deleted = 0 and price.product_id = ?', $id)	
			->where('product_deleted = 0 and price_active = 1')	
			->order('price.price_active asc');

		$result = $this->_db->fetchAll($select);	   
		return ($result == false) ? false : $result = $result;
	}
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getProductPrice($product, $price) {
		$select = $this->_db->select()	
			->from(array('price' => 'price'))
			->joinInner(array('product' => 'product'), "product.product_id = price.product_id")	
			->where('product_deleted = 0 and price.product_id = ?', $product)
			->where('price_deleted = 0 and price.price_id = ?', $price)				
			->order('price.price_active asc');

		$result = $this->_db->fetchRow($select);	   
		return ($result == false) ? false : $result = $result;
	}
	
	/**
	 * get domain by domain Account Id
 	 * @param string domain id
     * @return object
	 */
	public function getById($id) {
		$select = $this->_db->select()	
			->from(array('price' => 'price'))
			->joinInner(array('product' => 'product'), "product.product_id = price.product_id")
			->where('price.price_id = ? and price_deleted = 0', $id)
			->limit(1);

	   $result = $this->_db->fetchRow($select);	
       return ($result == false) ? false : $result = $result;					   
	}

	function validateAmount($amount) {
		if(preg_match("/^[0-9]+(?:\.[0-9]{0,2})?$/", $amount)) {
			return $amount;
		} else {
			return null;
		}	
	}
}
?>