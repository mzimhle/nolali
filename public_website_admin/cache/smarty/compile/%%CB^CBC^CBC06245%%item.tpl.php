<?php /* Smarty version 2.6.20, created on 2015-05-17 12:22:01
         compiled from website/invoice/item.tpl */ ?>
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
			<li><a href="/website/" title="Website">Website</a></li>
			<li><a href="#" title="Website"><span class="success"><?php echo $this->_tpl_vars['domainData']['campaign_name']; ?>
</span></a></li>
			<li><a href="/website/invoice/" title="">Invoice</a></li>
			<li>REF#<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
</li>
			<li>Items</li>
        </ul>
	</div><!--breadcrumb-->
	<div class="inner">
		<div class="clearer"><!-- --></div>
		<br /><h2>Manage <span class="success"><?php echo $this->_tpl_vars['domainData']['campaign_name']; ?>
</span> Items</h2><br />
		<div id="sidetabs">
		<ul> 
            <li><a href="/website/invoice/details.php?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
" title="Details">Details</a></li>
			<li class="active"><a href="#" title="Items">Items</a></li>
			<li><a href="/website/invoice/payment.php?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
" title="Payment">Payment</a></li>			
		</ul>
		</div><!--tabs-->	
		  <div class="detail_box">  
		  <form name="invoiceitemForm" id="invoiceitemForm" action="/website/invoice/item.php?code=<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
" method="post">
			  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="innertable"> 
			  <thead>
			  <tr>				
				<th valign="top">Name</th>
				<th valign="top">Description</th>
				<th valign="top">Quantity</th>
				<th valign="top">Amount</th>
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
				<td valign="top"><?php echo $this->_tpl_vars['item']['invoiceitem_amount']; ?>
</td>
				<td valign="top"><button onclick="deleteitem('<?php echo $this->_tpl_vars['item']['invoiceitem_code']; ?>
'); return false;">Delete</button></td>
			  </tr>
			  <?php endforeach; endif; unset($_from); ?>			
			  <tr>	  
				<td valign="top">
					<input type="text" id="invoiceitem_name" name="invoiceitem_name"  size="30" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['invoiceitem_name'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['invoiceitem_name']; ?>
</em><?php endif; ?>
				</td>				  			  
				<td valign="top">
					<textarea id="invoiceitem_description" name="invoiceitem_description" cols="50"></textarea>
					<?php if (isset ( $this->_tpl_vars['errorArray']['invoiceitem_description'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['invoiceitem_description']; ?>
</em><?php endif; ?>
				</td>
				<td valign="top">
					<input type="text" id="invoiceitem_quantity" name="invoiceitem_quantity"  size="5" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['invoiceitem_quantity'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['invoiceitem_quantity']; ?>
</em><?php endif; ?>
				</td>
				<td valign="top">
					<input type="text" id="invoiceitem_amount" name="invoiceitem_amount"  size="10" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['invoiceitem_amount'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['invoiceitem_amount']; ?>
</em><?php endif; ?>
				</td>					
				<td valign="top">
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

function deleteitem(code) {
	if(confirm(\'Are you sure you want to delete this item?\')) {
		$.ajax({ 
				type: "GET",
				url: "item.php?code='; ?>
<?php echo $this->_tpl_vars['invoiceData']['invoice_code']; ?>
<?php echo '",
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
	
<!-- End Main Container -->
</body>
</html>