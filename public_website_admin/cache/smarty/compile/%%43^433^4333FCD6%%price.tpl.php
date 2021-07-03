<?php /* Smarty version 2.6.20, created on 2015-05-23 17:29:46
         compiled from catalogue/item/price.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'catalogue/item/price.tpl', 54, false),array('modifier', 'default', 'catalogue/item/price.tpl', 56, false),)), $this); ?>
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
		<h2 class="content-header-title">Items</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="/catalogue/item/">Items</a></li>
			<li><a href="#"><?php echo $this->_tpl_vars['productitemData']['productitem_name']; ?>
</a></li>
			<li class="active">Price</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Price List
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/catalogue/item/price.php?code=<?php echo $this->_tpl_vars['productitemData']['productitem_code']; ?>
" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">			
				<p>Below is a list of images under this productitem.</p>
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td>ID</td>
							<td>Number of Items</td>
							<td>Price</td>
							<td>Start Date</td>
							<td>End Date</td>
						</tr>
					</thead>
					<tbody>
					<?php $_from = $this->_tpl_vars['priceData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
					  <tr>	
						<td valign="top" <?php if ($this->_tpl_vars['item']['_price_active'] == '1'): ?>class="success"<?php else: ?>class="error"<?php endif; ?>><?php echo $this->_tpl_vars['item']['_price_id']; ?>
</td>
						<td valign="top" <?php if ($this->_tpl_vars['item']['_price_active'] == '1'): ?>class="success"<?php else: ?>class="error"<?php endif; ?>><?php echo $this->_tpl_vars['item']['_price_number']; ?>
 item(s)</td>
						<td valign="top" <?php if ($this->_tpl_vars['item']['_price_active'] == '1'): ?>class="success"<?php else: ?>class="error"<?php endif; ?>>R <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['_price_cost'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>
						<td valign="top" <?php if ($this->_tpl_vars['item']['_price_active'] == '1'): ?>class="success"<?php else: ?>class="error"<?php endif; ?>><?php echo $this->_tpl_vars['item']['_price_startdate']; ?>
</td>
						<td valign="top" <?php if ($this->_tpl_vars['item']['_price_active'] == '1'): ?>class="success"<?php else: ?>class="error"<?php endif; ?> colspan="2"><?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['_price_enddate'])) ? $this->_run_mod_handler('default', true, $_tmp, 'N/A') : smarty_modifier_default($_tmp, 'N/A')); ?>
</td>
					  </tr>			     
					<?php endforeach; else: ?>
						<tr>
							<td align="center" colspan="5">There are currently no items</td>
						</tr>					
					<?php endif; unset($_from); ?>
					</tbody>					  
				</table>
				<p>Add new price below</p>
                <div class="form-group">
					<label for="_price_number">Number of items</label>
					<input type="text" id="_price_number" name="_price_number" class="form-control" value="1"/>
					<?php if (isset ( $this->_tpl_vars['errorArray']['_price_number'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['_price_number']; ?>
</span><?php endif; ?>					  
                </div>					
                <div class="form-group">
					<label for="_price_cost">Price amount</label>
					<input type="text" id="_price_cost" name="_price_cost" class="form-control" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['_price_cost'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['_price_cost']; ?>
</span><?php endif; ?>					  
                </div>				
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
				<br />	
				<input type="hidden" value="1" name="image" id="image" />
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->	
		<div class="col-sm-3">
			<div class="list-group">  
				<a class="list-group-item" href="/catalogue/item/">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/catalogue/item/details.php?code=<?php echo $this->_tpl_vars['productitemData']['productitem_code']; ?>
">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="#">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Price
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a> 				
				<a class="list-group-item" href="/catalogue/item/image.php?code=<?php echo $this->_tpl_vars['productitemData']['productitem_code']; ?>
">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Add Images
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/catalogue/item/extra.php?code=<?php echo $this->_tpl_vars['productitemData']['productitem_code']; ?>
">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Add Extras
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