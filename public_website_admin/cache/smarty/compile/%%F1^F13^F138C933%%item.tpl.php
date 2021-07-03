<?php /* Smarty version 2.6.20, created on 2015-05-22 13:10:42
         compiled from catalogue/invoice/item.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'catalogue/invoice/item.tpl', 57, false),array('function', 'html_options', 'catalogue/invoice/item.tpl', 77, false),)), $this); ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title><?php echo $this->_tpl_vars['domainData']['campaign_name']; ?>
 Management System</title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</head>
<body>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<div class="container">
  <div class="content">
    <div class="content-container">
	<div class="content-header">
		<h2 class="content-header-title">Invoice</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="/catalogue/">Catalogue</a></li>
			<li><a href="/catalogue/invoice/">Invoice</a></li>
			<li><a href="#">REF#<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
 - <?php echo $this->_tpl_vars['invoiceData']['invoice_person_name']; ?>
</a></li>
			<li class="active">Items</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Items List
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/catalogue/invoice/item.php?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
" method="POST" data-validate="parsley" class="form parsley-form">			
				<p>Below is a list of items under this invoice.</p>
				<table class="table table-bordered">	
					<thead>
					  <tr>				
						<th valign="top">Name</th>
						<th valign="top">Description</th>
						<th valign="top">Quantity</th>
						<th valign="top">Unit Price</th>
						<th valign="top"></th>		
						<th valign="top"></th>	
					  </tr>
					</thead>
					<tbody>
					<?php $_from = $this->_tpl_vars['invoiceitemData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
					  <tr>	
						<td valign="top"><?php echo $this->_tpl_vars['item']['invoiceitem_name']; ?>
</td>
						<td valign="top"><?php echo $this->_tpl_vars['item']['invoiceitem_description']; ?>
</td>
						<td valign="top"><?php echo $this->_tpl_vars['item']['invoiceitem_quantity']; ?>
</td>
						<td valign="top">R <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['invoiceitem_amount'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>
						<td valign="top">
							<button value="Update" class="btn btn-notice" onclick="invoiceitemUpdateModal('<?php echo $this->_tpl_vars['item']['invoiceitem_code']; ?>
', '<?php echo $this->_tpl_vars['item']['invoiceitem_name']; ?>
', '<?php echo $this->_tpl_vars['item']['invoiceitem_description']; ?>
', '<?php echo $this->_tpl_vars['item']['invoiceitem_quantity']; ?>
','<?php echo $this->_tpl_vars['item']['invoiceitem_amount']; ?>
'); return false;">Update</button>
						</td>						
						<td valign="top">
							<button value="Delete" class="btn btn-danger" onclick="deleteModal('<?php echo $this->_tpl_vars['item']['invoiceitem_code']; ?>
', '<?php echo $this->_tpl_vars['item']['invoice_code']; ?>
', 'item'); return false;">Delete</button>
						</td>		
					  </tr>			     
					<?php endforeach; else: ?>
						<tr>
							<td align="center" colspan="6">There are currently no items</td>
						</tr>					
					<?php endif; unset($_from); ?>
					</tbody>					  
				</table>
				<p>Add new item below</p>
                <div class="form-group">
					<label for="_price_code">Product and Price</label>
					<select name="_price_code" id="_price_code" class="form-control" >
						<option value=""> --------------- </option>
						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['pricePairs']), $this);?>

					</select>
					<?php if (isset ( $this->_tpl_vars['errorArray']['_price_code'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['_price_code']; ?>
</span><?php endif; ?>					  
                </div>
                <div class="form-group">
					<label for="invoiceitem_quantity">Quantity in numbers</label>
					<input type="text" id="invoiceitem_quantity" name="invoiceitem_quantity" class="form-control" data-required="true" value="1" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['invoiceitem_quantity'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['invoiceitem_quantity']; ?>
</span><?php endif; ?>					  
                </div>			
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
              </form>
            </div> <!-- /.portlet-content --> 
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->	
		<div class="col-sm-3">
			<div class="list-group">  
				<a class="list-group-item" href="/catalogue/invoice/">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/catalogue/invoice/details.php?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a> 
				<a class="list-group-item" href="#">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Items
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/catalogue/invoice/payment.php?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Payments
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/catalogue/invoice/generate.php?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Generate PDF
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>					
			</div> <!-- /.list-group -->
		</div>			
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php echo '
<script type="text/javascript">

	function invoiceitemUpdateModal(code, name, description, quantity, price) {
		$(\'#invoiceitemcode\').val(code);
		$(\'#invoiceitemname\').val(name);
		$(\'#invoiceitemdescription\').val(description);
		$(\'#invoiceitemquantity\').val(quantity);
		$(\'#invoiceitemprice\').val(price);
		$(\'#invoiceitemUpdateModal\').modal(\'show\');
		return false;
	}
	
	function invoiceitemUpdate() {
		
		var code 			= $(\'#invoiceitemcode\').val();
		var name			= $(\'#invoiceitemname\').val();
		var description	= $(\'#invoiceitemdescription\').val();
		var quantity 		= $(\'#invoiceitemquantity\').val();
		var price 			= $(\'#invoiceitemprice\').val();
		
		$.ajax({
				type: "POST",
				url: "item.php?code='; ?>
<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
<?php echo '",
				data: "update_code="+code+"&name="+name+"&description="+description+"&quantity="+quantity+"&price="+price,
				dataType: "json",
				success: function(data){
					if(data.result == 1) {
						window.location.href = window.location.href;
					} else {
						$(\'#invoiceitemUpdateModal\').modal(\'hide\');
						$.howl ({
						  type: \'info\'
						  , title: \'Notification\'
						  , content: data.error
						  , sticky: $(this).data (\'sticky\')
						  , lifetime: 7500
						  , iconCls: $(this).data (\'icon\')
						});	
					}
				}
		});								

		return false;
	}	
</script>
'; ?>

<!-- Modal -->
<div class="modal fade" id="invoiceitemUpdateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Update Item</h4>
			</div>
			<div class="modal-body">
                <div class="form-group">
					<label for="invoiceitemname">Name</label>
					<input type="text" name="invoiceitemname" id="invoiceitemname" class="form-control" data-required="true" />  
                </div>
                <div class="form-group">
					<label for="invoiceitemdescription">Description</label>
					<textarea name="invoiceitemdescription" id="invoiceitemdescription" class="form-control" data-required="true"></textarea>  
                </div>
                <div class="form-group">
					<label for="invoiceitemquantity">Quantity in numbers</label>
					<input type="text" name="invoiceitemquantity" id="invoiceitemquantity" class="form-control" data-required="true" />  
                </div>				
                <div class="form-group">
					<label for="invoiceitemprice">Price (exl. vat)</label>
					<input type="text" name="invoiceitemprice" id="invoiceitemprice" class="form-control" data-required="true" />  
                </div>				
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
				<button class="btn btn-warning" type="button" onclick="javascript:invoiceitemUpdate();">Update</button>
				<input type="hidden" id="invoiceitemcode" name="invoiceitemcode" value=""/>
			</div>
		</div>
	</div>
</div>
<!-- modal -->
</html>