<?php /* Smarty version 2.6.20, created on 2015-05-15 17:40:18
         compiled from website/product/items.tpl */ ?>
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
			<li><a href="/campaign/" title="campaign">Campaign</a></li>
			<li><a href="/website/product/" title="Products">Products</a></li>
			<li><?php echo $this->_tpl_vars['productData']['product_name']; ?>
</li>
			<li>Items</li>
        </ul>
	</div><!--breadcrumb--> 
	<br />  
	<div class="inner"> 
      <h2><?php echo $this->_tpl_vars['productData']['product_name']; ?>
 Items / Features</h2>
	<br />
    <div id="sidetabs">
        <ul>             
            <li><a href="/website/product/details.php?code=<?php echo $this->_tpl_vars['productData']['product_code']; ?>
" title="Details">Details</a></li>
			<li class="active"><a href="#" title="Items">Items</a></li>
			<li><a href="/website/product/prices.php?code=<?php echo $this->_tpl_vars['productData']['product_code']; ?>
" title="Prices">Prices</a></li>
        </ul>
    </div><!--tabs-->	
	<div class="detail_box">
	
	<form id="submitForm" name="submitForm" action="/website/product/items.php?code=<?php echo $this->_tpl_vars['productData']['product_code']; ?>
" method="post" enctype="multipart/form-data">
	<table width="100%" class="innertable" border="0" cellspacing="0" cellpadding="0">
		<thead>
		<tr>		
			<th>Name</th>
			<th>Cost</th>
			<th>Description</th>
			<th></th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		<?php $_from = $this->_tpl_vars['productitemData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['food'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['food']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['food']['iteration']++;
?>
		<tr>	
			<td><input type="text" value="<?php echo $this->_tpl_vars['item']['productitem_name']; ?>
" size="20" id="productitem_name_<?php echo $this->_tpl_vars['item']['productitem_code']; ?>
" name="productitem_name_<?php echo $this->_tpl_vars['item']['productitem_code']; ?>
" /></td>
			<td><input type="text" value="<?php echo $this->_tpl_vars['item']['productitem_price']; ?>
" size="5" id="productitem_price_<?php echo $this->_tpl_vars['item']['productitem_code']; ?>
" name="productitem_price__<?php echo $this->_tpl_vars['item']['productitem_code']; ?>
" /></td>
			<td><textarea cols="30" rows="2" id="productitem_description_<?php echo $this->_tpl_vars['item']['productitem_code']; ?>
" name="productitem_description_<?php echo $this->_tpl_vars['item']['productitem_code']; ?>
"><?php echo $this->_tpl_vars['item']['productitem_description']; ?>
</textarea></td>
			<td><button onclick="updateitem('<?php echo $this->_tpl_vars['item']['productitem_code']; ?>
'); return false;">Update</button></td>
			<td><button onclick="deleteitem('<?php echo $this->_tpl_vars['item']['productitem_code']; ?>
'); return false;">Delete</button></td>
		</tr>
		<?php endforeach; endif; unset($_from); ?>	
		<tr>
			<td>
				<input type="text" id="productitem_name" name="productitem_name" value="" size="20" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['productitem_name'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['productitem_name']; ?>
</span><?php endif; ?>
			</td>
			<td>
				<input type="text" id="productitem_price" name="productitem_price" value="" size="20" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['productitem_price'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['productitem_price']; ?>
</span><?php endif; ?>
			</td>
			<td>
				<textarea id="productitem_description" name="productitem_description" cols="30" rows="2"></textarea>
				<?php if (isset ( $this->_tpl_vars['errorArray']['productitem_description'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['productitem_description']; ?>
</span><?php endif; ?>
			</td>
			<td colspan="2"><button onclick="additem();">Add Item</button></td>
		</tr>			
		</tbody>						
	</table>
	<input type="hidden" name="productitem_code_selected" id="productitem_code_selected" value="" />
	</form>
	</div>
	<div class="clearer"><!-- --></div>	

    </div><!--inner-->
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</div>
<?php echo '
<script type="text/javascript">
function additem() {
	document.forms.submitForm.submit();					 
}

function deleteitem(code) {
	if(confirm(\'Are you sure you want to delete this item?\')) {
		$.ajax({
			type: "GET",
			url: "items.php?code='; ?>
<?php echo $this->_tpl_vars['productData']['product_code']; ?>
<?php echo '",
			data: "deleteitem="+code,
			dataType: "json",
			success: function(data){
				if(data.result == 1) {
					alert(\'Deleted\');
					window.location.href = window.location.href;
				} else {
					alert(data.message);
				}
			}
		});		
	}
	return false;			

}

function updateitem(code) {
	if(confirm(\'Are you sure you want to update this file ?\')) {		
		
		$.ajax({ 
				type: "GET",
				url: "items.php",
				data: "code='; ?>
<?php echo $this->_tpl_vars['productData']['product_code']; ?>
<?php echo '&updateitem="+code+"&productitem_name="+$(\'#productitem_name_\'+code).val()+"&productitem_price="+$(\'#productitem_price_\'+code).val()+"&productitem_description="+$(\'#productitem_description_\'+code).val(),
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert(\'Updated\');
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