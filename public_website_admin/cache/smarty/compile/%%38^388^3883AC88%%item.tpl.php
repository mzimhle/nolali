<?php /* Smarty version 2.6.20, created on 2015-05-27 14:41:40
         compiled from booking/item.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'booking/item.tpl', 52, false),array('function', 'html_options', 'booking/item.tpl', 70, false),)), $this); ?>
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
		<h2 class="content-header-title">Booking</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="/booking/item/">Booking</a></li>
			<li><a href="#"><?php echo $this->_tpl_vars['bookingData']['booking_person_name']; ?>
 - <?php echo $this->_tpl_vars['bookingData']['booking_person_email']; ?>
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
              <form id="validate-basic" action="/booking/item.php?code=<?php echo $this->_tpl_vars['bookingData']['booking_code']; ?>
" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">			
				<p>Below is a list of items under this booking.</p>
				<table class="table table-bordered">	
					<thead>
					  <tr>				
						<th valign="top">Product Booked</th>
						<th valign="top">Price</th>
						<th valign="top">Quantity</th>
						<th valign="top"></th>			
					  </tr>
					</thead>
					<tbody>
					<?php $_from = $this->_tpl_vars['priceitemData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
					  <tr>	
						<td valign="top"><?php echo $this->_tpl_vars['item']['productitem_name']; ?>
</td>
						<td valign="top">R <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['_price_cost'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>
						<td valign="top"><?php echo $this->_tpl_vars['item']['_priceitem_quantity']; ?>
</td>
						<td valign="top">
							<button value="Delete" class="btn btn-danger" onclick="deleteModal('<?php echo $this->_tpl_vars['item']['_priceitem_code']; ?>
', '<?php echo $this->_tpl_vars['item']['booking_code']; ?>
', 'item'); return false;">Delete</button>
						</td>						
					  </tr>			     
					<?php endforeach; else: ?>
						<tr>
							<td align="center" colspan="4">There are currently no items</td>
						</tr>					
					<?php endif; unset($_from); ?>
					</tbody>					  
				</table>
				<p>Add new price below</p>
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
					<label for="_priceitem_quantity">Quantity</label>
					<input type="text" id="_priceitem_quantity" name="_priceitem_quantity" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['bookingData']['_priceitem_quantity']; ?>
" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['_priceitem_quantity'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['_priceitem_quantity']; ?>
</span><?php endif; ?>					  
                </div>				
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
              </form>
            </div> <!-- /.portlet-content --> 
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->	
		<div class="col-sm-3">
			<div class="list-group">  
				<a class="list-group-item" href="/booking/">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/booking/details.php?code=<?php echo $this->_tpl_vars['bookingData']['booking_code']; ?>
">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a> 
				<a class="list-group-item" href="#">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Items
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/booking/payment.php?code=<?php echo $this->_tpl_vars['bookingData']['booking_code']; ?>
">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Payments
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>				
				<a class="list-group-item" href="/booking/generate.php?code=<?php echo $this->_tpl_vars['bookingData']['booking_code']; ?>
">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Generate PDF Invoice
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

</html>