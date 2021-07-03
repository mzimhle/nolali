<?php /* Smarty version 2.6.20, created on 2015-05-14 20:50:47
         compiled from products/package/price.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'products/package/price.tpl', 53, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nolali - The Creative</title>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</head>
<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content recruiter -->
  <div id="content">
    <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

  	<br />
	<div id="breadcrumb">
        <ul>
            <li><a href="/" title="Home">Home</a></li>
			<li><a href="/products/" title="">Products</a></li>
			<li><a href="/products/package/" title="">Package</a></li>
			<li>
				<a href="/products/package/details.php?code=<?php echo $this->_tpl_vars['packageData']['_package_code']; ?>
" title="<?php echo $this->_tpl_vars['packageData']['_package_name']; ?>
"><?php echo $this->_tpl_vars['packageData']['_package_name']; ?>
</a>
			</li>
			<li>Price</li>
        </ul>
	</div><!--breadcrumb-->
	<div class="inner">
		<div class="clearer"><!-- --></div>
		<br /><h2>Manage Price</h2><br />
		<div id="sidetabs">
		<ul> 
            <li><a href="/products/package/details.php?code=<?php echo $this->_tpl_vars['packageData']['_package_code']; ?>
" title="Details">Details</a></li>
			<li class="active"><a href="#" title="Price">Price</a></li>
			<li><a href="<?php if (isset ( $this->_tpl_vars['packageData'] )): ?>/products/package/component.php?code=<?php echo $this->_tpl_vars['packageData']['_package_code']; ?>
<?php else: ?>#<?php endif; ?>" title="Component">Component</a></li>			
		</ul>
		</div><!--tabs-->	
		  <div class="detail_box">  
		  <form name="priceForm" id="priceForm" action="/products/package/price.php?code=<?php echo $this->_tpl_vars['packageData']['_package_code']; ?>
" method="post">
			  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="innertable"> 
			  <thead>
			  <tr>				
				<th valign="top">ID</th>
				<th valign="top">Price</th>
				<th valign="top">Type</th>
				<th valign="top">Start Date</th>
				<th valign="top">End Date</th>			
			  </tr>
			  </thead>
			  <tbody>
			  <?php $_from = $this->_tpl_vars['priceData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			  <tr>	
				<td valign="top" <?php if ($this->_tpl_vars['item']['_price_active'] == '1'): ?>class="success"<?php else: ?>class="error"<?php endif; ?>><?php echo $this->_tpl_vars['item']['_price_id']; ?>
</td>
				<td valign="top" <?php if ($this->_tpl_vars['item']['_price_active'] == '1'): ?>class="success"<?php else: ?>class="error"<?php endif; ?>>R <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['_price_cost'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>				
				<td valign="top" <?php if ($this->_tpl_vars['item']['_price_active'] == '1'): ?>class="success"<?php else: ?>class="error"<?php endif; ?>><?php echo $this->_tpl_vars['item']['_price_type']; ?>
</td>	
				<td valign="top" <?php if ($this->_tpl_vars['item']['_price_active'] == '1'): ?>class="success"<?php else: ?>class="error"<?php endif; ?>><?php echo $this->_tpl_vars['item']['_price_startdate']; ?>
</td>
				<td valign="top" <?php if ($this->_tpl_vars['item']['_price_active'] == '1'): ?>class="success"<?php else: ?>class="error"<?php endif; ?>><?php echo $this->_tpl_vars['item']['_price_enddate']; ?>
</td>
			  </tr>
			  <?php endforeach; endif; unset($_from); ?>			
			  <tr>
				<td valign="top"></td>			  
				<td valign="top">
					<input type="text" id="_price_cost" name="_price_cost"  size="20" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['_price_cost'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['_price_cost']; ?>
</em><?php endif; ?>
				</td>
				<td valign="top">
					<select id="_price_type" name="_price_type">
						<option value=""> -------- </option>
						<option value="INITIAL"> Initial Cost </option>
						<option value="MONTHLY"> Monthly Cost </option>
					</select>
					<?php if (isset ( $this->_tpl_vars['errorArray']['_price_type'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['_price_type']; ?>
</em><?php endif; ?>
				</td>	
				<td valign="top" colspan="2">
					<button type="submit" onclick="submitForm();">Add</button>	
				</td>			
			  </tr>
			  </tbody>
			</table>
			<?php if (isset ( $this->_tpl_vars['errorArray']['error'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['error']; ?>
</span><?php endif; ?>
			</form>
		</div>		
	<div class="clearer"><!-- --></div>
    </div><!--inner-->
 </div> 	
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</div>
<?php echo '
<script type="text/javascript">
function submitForm() {
	document.forms.imageForm.submit();					 
}		
</script>
'; ?>
	
<!-- End Main Container -->
</body>
</html>