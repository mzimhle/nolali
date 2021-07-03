<?php /* Smarty version 2.6.20, created on 2015-05-14 07:55:14
         compiled from products/components/default.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'products/components/default.tpl', 49, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>E-Manager</title>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<script type="text/javascript" language="javascript" src="default.js"></script>
</head>

<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content Section -->
  <div id="content">
    <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

	<div id="breadcrumb">
        <ul>
            <li><a href="/" title="Home">Home</a></li>
			<li><a href="/products/" title="Home">Products</a></li>
			<li><a href="/products/components/" title="">Components</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage Components</h2>		
	<a href="/products/components/details.php" title="Click to Add a new product" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new product item</span></a> <br />
    <div class="clearer"><!-- --></div>
     <!-- Start Search Form -->
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">			
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
			  <tr>
				<th>Product</th>
				<th>Item</th>
				<th>Price</th>				
				<th>Active</th>
				<th>Description</th>
				<th></th>			
			   </tr>
			   </thead>
			   <tbody>
			  <?php $_from = $this->_tpl_vars['productpriceitemData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			  <tr>
				<td align="left"><?php echo $this->_tpl_vars['item']['_productprice_name']; ?>
</td>
				<td align="left"><a href="/products/components/details.php?code=<?php echo $this->_tpl_vars['item']['_productpriceitem_code']; ?>
"><?php echo $this->_tpl_vars['item']['_productpriceitem_name']; ?>
</a></td>				
				<td align="left" width="10%">R <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['_productpriceitem_price'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ".", ",") : number_format($_tmp, 2, ".", ",")); ?>
</td>
				<td align="left"><?php if ($this->_tpl_vars['item']['_productpriceitem_active'] == 1): ?><span class="success">Active</span><?php else: ?><span class="error">Inctive</span><?php endif; ?></td>
				<td align="left"><?php echo $this->_tpl_vars['item']['_productpriceitem_description']; ?>
</td>	
				<td align="left"><button onclick="javascript:deleteForm('<?php echo $this->_tpl_vars['item']['_productpriceitem_code']; ?>
');">delete</button></td>				
			  </tr>
			  <?php endforeach; endif; unset($_from); ?>     
			  </tbody>
			</table>
		 </div>
		 <!-- End Content Table -->	
	</div>
    <div class="clearer"><!-- --></div>
    </div><!--inner-->
  </div><!-- End Content Section -->
 <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

 <?php echo '
<script type="text/javascript">
function deleteForm(id) {	
	if(confirm(\'Are you sure you want to delete this item?\')) {

			$.ajax({ 
					type: "GET",
					url: "default.php",
					data: "productpriceitem_code_delete="+id,
					dataType: "json",
					success: function(data){
							if(data.result == 1) {
								alert(\'Deleted\');
								window.location.href = window.location.href;
							} else {
								alert(data.error);
							}
					}
			});								
		}
}					
</script>
'; ?>

</div>
<!-- End Main Container -->
</body>
</html>