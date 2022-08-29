<?php
//custom recruiter item class as recruiter table abstraction
class class_report extends Zend_Db_Table_Abstract {

	function init()	{
		global $zfsession;
		$this->_entity	= $zfsession->entity;
	}
	
	/**
	 * The formula for Gross Sales is:  Gross Profit = Revenue – Cost of Goods Sold
	 * The formula for Net Sales is:  Gross Profit = Revenue – Cost of Goods Sold	 
     * @return object
	 */
	public function getIncomeStatement() {

		$revenue = $this->_db->select()
			->from(array('statement' => 'statement'), array('entity_id', 'revenue' => new Zend_Db_Expr('SUM(statement_amount)')))
			->joinInner(array('section' => 'section'), "section.section_id = statement.section_id", array())
			->joinInner(array('category' => 'category'), "category.category_id = section.category_id", array())
            ->where("YEAR(statement_added) = YEAR(CURDATE()) and statement.entity_id = ?", $this->_entity)
			->where("category_code = 'REVENUE' and statement_deleted = 0 and section_deleted = 0 and category_deleted = 0")
			->group(array('entity_id'));

		$operatingexpenses = $this->_db->select()
			->from(array('statement' => 'statement'), array('entity_id', 'operating_expenses' => new Zend_Db_Expr('SUM(statement_amount)')))
			->joinInner(array('section' => 'section'), "section.section_id = statement.section_id", array())
			->joinInner(array('category' => 'category'), "category.category_id = section.category_id", array())
            ->where("YEAR(statement_added) = YEAR(CURDATE()) and statement.entity_id = ?", $this->_entity)
			->where("category_code = 'OPERATING_EXPENSES' and statement_deleted = 0 and section_deleted = 0 and category_deleted = 0")
			->group(array('entity_id'));

		// Ending Inventory, goods sold previous years - cost of goods sold
		$cost_of_goods_sold = $this->_db->select()
			->from(array('statement' => 'statement'), array('sum(statement_amount) as cost_of_goods_sold', 'entity_id'))
			->joinInner(array('invoice' => 'invoice'), "invoice.invoice_id = statement.invoice_id", array())
            ->where("YEAR(statement_added) = YEAR(CURDATE()) and statement_deleted = 0 and invoice_deleted = 0 and statement.entity_id = ?", $this->_entity)
			->group(array('entity_id'));

		$goodssold_previous_years = $this->_db->select()
			->from(array('statement' => 'statement'), array('sum(statement_amount) as goodssold_previous_years', 'entity_id'))
			->joinInner(array('invoice' => 'invoice'), "invoice.invoice_id = statement.invoice_id", array())
            ->where("YEAR(statement_added) != YEAR(CURDATE()) and statement_deleted = 0 and invoice_deleted = 0 and statement.entity_id = ?", $this->_entity)
			->group(array('entity_id'));

		// Purchases
		$purchases = $this->_db->select()
			->from(array('inventory' => 'inventory'), array('sum(inventory_amount) as purchases'))
			->joinInner(array('product' => 'product'), "product.product_id = inventory.product_id", array('entity_id'))
            ->where("YEAR(inventory_added) = YEAR(CURDATE()) and inventory_deleted = 0 and product_deleted = 0 and product.entity_id = ?", $this->_entity)
			->group(array('entity_id'));

		$items = $this->_db->select()
			->from(array('price' => 'price'), array('price.product_id'))
			->joinInner(array('invoiceitem' => 'invoiceitem'), "invoiceitem.price_id = price.price_id", array('ifnull(sum(invoiceitem_quantity),0) as product_quantity', 'ifnull(sum(invoiceitem_amount),0) as product_amount'))
			->where('price_deleted = 0 and invoiceitem_deleted = 0')
			->group('price.product_id');

		$select = $this->_db->select()
			->from(array('product' => 'product'))
			->joinLeft(array('inventory' => 'inventory'), "inventory.product_id = product.product_id and product_deleted = 0 and product_type = 'ITEM'", array('ifnull(sum(inventory_quantity), 0) as inventory_quantity'))
			->joinLeft(array('items' => $items), 'items.product_id = product.product_id', array('ifnull(product_quantity,0) as product_quantity', 'ifnull(sum(inventory_quantity)-ifnull(product_quantity,0), 0) as product_left'))
			->where('product_deleted = 0 and product.entity_id = ?', $this->_entity)
			->group('product.product_id');
			
		$available_goods_cost = $this->_db->select()
			->from(array('inventory' => 'inventory'), array('sum(inventory_amount) as purchases'))
			->joinInner(array('product' => 'product'), "product.product_id = inventory.product_id and product_deleted = 0", array('entity_id'))
			->joinInner(array('price' => 'price'), "price.product_id = product.product_id and price_deleted = 0 and price_active = 1 amd price_quantity = 1", array())
            ->where("YEAR(inventory_added) = YEAR(CURDATE()) and inventory_deleted = 0 and product.entity_id = ?", $this->_entity)
			->group(array('product.entity_id'));

		$select = $this->_db->select()
			->from(array('entity' => 'entity'), array('entity_id', 'entity_name', 
				'(ifnull(revenue, 0) + ifnull(operating_expenses, 0)) as net_sales', 
				'(ifnull(goodssold_previous_years, 0) - ifnull(cost_of_goods_sold, 0)) as ending_inventory', '((ifnull(cost_of_goods_sold,0) + (ifnull(goodssold_previous_years, 0) - ifnull(cost_of_goods_sold, 0))) - ifnull(purchases, 0)) as begining_inventory'))
			->joinLeft(array('revenue' => $revenue), 'revenue.entity_id = entity.entity_id', array('ifnull(revenue, 0) as gross_sales'))
			->joinLeft(array('operatingexpenses' => $operatingexpenses), 'operatingexpenses.entity_id = entity.entity_id', array('ifnull(operating_expenses, 0) as operating_expenses'))

			->joinLeft(array('cost_of_goods_sold' => $cost_of_goods_sold), 'cost_of_goods_sold.entity_id = entity.entity_id', array('ifnull(cost_of_goods_sold, 0) as cost_of_goods_sold'))
			->joinLeft(array('goodssold_previous_years' => $goodssold_previous_years), 'goodssold_previous_years.entity_id = entity.entity_id', array('ifnull(goodssold_previous_years, 0) as goodssold_previous_years'))

			->joinLeft(array('purchases' => $purchases), 'purchases.entity_id = entity.entity_id', array('ifnull(purchases, 0) as purchases'))

			->where("entity.entity_id = ?", $this->_entity);

		$result = $this->_db->fetchRow($select);
		return ($result == false) ? false : $result = $result;				
	}
	/**
	 *
	 * Get the Operating Expenses
	 *
     * @return object
	 */
	public function getOperatingExpenses() {

		$select = $this->_db->select()
			->from(array('statement' => 'statement'), array('entity_id', 'section_id', 'amount' => new Zend_Db_Expr('SUM(statement_amount)')))
			->joinInner(array('section' => 'section'), "section.section_id = statement.section_id and section_deleted = 0", array('section_name'))
			->joinInner(array('category' => 'category'), "category.category_id = section.category_id and category_deleted = 0", array())
            ->where("YEAR(statement_added) = YEAR(CURDATE()) and statement_deleted = 0 and statement.entity_id = ?", $this->_entity)
			->where("category_code = 'OPERATING_EXPENSES'")
			->group(array('entity_id', 'section_id', 'section_name'));

		$result = $this->_db->fetchAll($select);
		return ($result == false) ? false : $result = $result;				
	}
}
?>