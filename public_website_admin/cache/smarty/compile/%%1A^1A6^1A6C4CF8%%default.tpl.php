<?php /* Smarty version 2.6.20, created on 2015-05-17 12:21:35
         compiled from website/invoice/default.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'website/invoice/default.tpl', 49, false),array('modifier', 'default', 'website/invoice/default.tpl', 52, false),array('modifier', 'number_format', 'website/invoice/default.tpl', 53, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nolali - The Creative</title>
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
			<li><a href="/website/" title="Website">Website</a></li>
			<li><a href="#" title="Website"><span class="success"><?php echo $this->_tpl_vars['domainData']['campaign_name']; ?>
</span></a></li>
			<li><a href="/website/invoice/" title="">Invoice</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage <span class="success"><?php echo $this->_tpl_vars['domainData']['campaign_name']; ?>
</span> Invoice</h2>		
	<a href="/website/invoice/details.php" title="Click to Add a new Invoice" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new Invoice</span></a> <br />
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">			
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
				<tr>
					<th>Added</th>
					<th>Reference</th>
					<th>Person Name</th>
					<th>Person Contact</th>
					<th>Total Item Amount</th>
					<th>Paid Amount</th>				
					<th>Remainder</th>				
					<th>Type</th>
					<th></th>			
				</tr>
			   </thead>
			   <tbody>
			  <?php $_from = $this->_tpl_vars['invoiceData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			  <tr>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['invoice_added'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
				<td align="left"><a href="/website/invoice/details.php?code=<?php echo $this->_tpl_vars['item']['invoice_code']; ?>
">REF#<?php echo $this->_tpl_vars['item']['invoice_code']; ?>
</a></td>
				<td align="left"><?php echo $this->_tpl_vars['item']['invoice_person_name']; ?>
</td>
				<td align="left"><?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['invoice_person_number'])) ? $this->_run_mod_handler('default', true, $_tmp, 'N/A') : smarty_modifier_default($_tmp, 'N/A')); ?>
 / <?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['invoice_person_email'])) ? $this->_run_mod_handler('default', true, $_tmp, 'N/A') : smarty_modifier_default($_tmp, 'N/A')); ?>
</td>				
				<td align="left">R <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['item_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>				
				<td align="left">R <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['payment_total'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>
				<td align="left">R <?php echo ((is_array($_tmp=$this->_tpl_vars['item']['payment_remainder'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 0, ".", ",") : number_format($_tmp, 0, ".", ",")); ?>
</td>
				<td align="left">
					<?php if ($this->_tpl_vars['item']['invoice_pdf'] != ''): ?>
						<a href="http://<?php echo $this->_tpl_vars['item']['campaign_domain']; ?>
<?php echo $this->_tpl_vars['item']['invoice_pdf']; ?>
" target="_blank"><?php echo $this->_tpl_vars['item']['invoice_make']; ?>
</a>
					<?php else: ?>
						<?php echo $this->_tpl_vars['item']['invoice_make']; ?>

					<?php endif; ?>
				</td>				
				<td align="left"><button onclick="deleteitem('<?php echo $this->_tpl_vars['item']['invoice_code']; ?>
'); return false;">Delete</button></td>
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

</div>
<!-- End Main Container -->
<?php echo '
<script type="text/javascript" language="javascript">
function deleteitem(code) {					
	if(confirm(\'Are you sure you want to delete this item?\')) {
		$.ajax({ 
				type: "GET",
				url: "default.php",
				data: "delete_code="+code,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert(\'Item deleted!\');
							window.location.href = window.location.href;
						} else {
							alert(data.error);
						}
				}
		});							
	}
	return false;
}

</script>
'; ?>

</body>
</html>