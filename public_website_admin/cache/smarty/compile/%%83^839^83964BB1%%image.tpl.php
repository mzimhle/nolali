<?php /* Smarty version 2.6.20, created on 2015-05-16 21:20:32
         compiled from website/catalogue/item/image.tpl */ ?>
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
			<li><a href="/website/catalogue/" title="">Catalogue</a></li>
			<li><a href="/website/catalogue/item/" title="">Items</a></li>
			<li><?php echo $this->_tpl_vars['productitemData']['productitem_name']; ?>
</li>
			<li>Image</li>
        </ul>
	</div><!--breadcrumb-->
	<div class="inner">
		<div class="clearer"><!-- --></div>
		<br /><h2>Manage <span class="success"><?php echo $this->_tpl_vars['domainData']['campaign_name']; ?>
</span> Product Item Images</h2><br />
		<div id="sidetabs">
		<ul> 
            <li><a href="/website/catalogue/item/details.php?code=<?php echo $this->_tpl_vars['productitemData']['productitem_code']; ?>
" title="Details">Details</a></li>
			<li class="active"><a href="#" title="Images">Images</a></li>
		</ul>
		</div><!--tabs-->	
		  <div class="detail_box">  
		  <form name="imageForm" id="imageForm" action="/website/catalogue/item/image.php?code=<?php echo $this->_tpl_vars['productitemData']['productitem_code']; ?>
" method="post"  enctype="multipart/form-data">
			  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="innertable"> 
			  <thead>
			  <tr>				
				<th valign="top" colspan="2" <?php if (isset ( $this->_tpl_vars['errorArray']['category_code'] )): ?>class="error"<?php endif; ?>>Updaload</th>
				<th valign="top">Delete Image</th>
				<th valign="top">Make Primary</th>
			  </tr>
			  </thead>
			  <?php $_from = $this->_tpl_vars['productitemimageData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			  <tr>	
				<td valign="top"<?php if ($this->_tpl_vars['item']['productitemimage_primary'] == '1'): ?>class="success"<?php endif; ?>><?php echo $this->_tpl_vars['item']['productitemimage_description']; ?>
</td>	
				<td valign="top">
					<a href="http://<?php echo $this->_tpl_vars['domainData']['campaign_domain']; ?>
/<?php echo $this->_tpl_vars['item']['productitemimage_path']; ?>
/big_<?php echo $this->_tpl_vars['item']['productitemimage_code']; ?>
<?php echo $this->_tpl_vars['item']['productitemimage_extension']; ?>
" target="_blank">
						<img src="http://<?php echo $this->_tpl_vars['item']['campaign_domain']; ?>
/<?php echo $this->_tpl_vars['item']['productitemimage_path']; ?>
/tny_<?php echo $this->_tpl_vars['item']['productitemimage_code']; ?>
<?php echo $this->_tpl_vars['item']['productitemimage_extension']; ?>
" />
					</a>
				</td>			
				<td valign="top"><?php if ($this->_tpl_vars['item']['productitemimage_primary'] == '0'): ?><button type="button" onclick="deleteitem('<?php echo $this->_tpl_vars['item']['productitemimage_code']; ?>
'); return false;">Delete</button><?php else: ?><b>Primary</b><?php endif; ?></td>	
				<td valign="top"><?php if ($this->_tpl_vars['item']['productitemimage_primary'] == '0'): ?><button type="button" onclick="makeprimary('<?php echo $this->_tpl_vars['item']['productitemimage_code']; ?>
'); return false;">Primary</button><?php else: ?><b>Primary</b><?php endif; ?></td>	
			  </tr>
			  <?php endforeach; endif; unset($_from); ?>			
			  <tr>
				<td valign="top" colspan="3">
					<input type="file" name="imagefiles[]" id="imagefiles[]" multiple />
					<?php if (isset ( $this->_tpl_vars['errorArray']['imagefiles'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['imagefiles']; ?>
</em><?php endif; ?>
				</td>		
				<td valign="top">
					<button type="submit" onclick="submitForm();">Upload Image</button>	
				</td>			
			  </tr>
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

function makeprimary(code) {
	if(confirm(\'Are you sure you want to make this item primary?\')) {
		$.ajax({
				type: "GET",
				url: "image.php?code='; ?>
<?php echo $this->_tpl_vars['productitemData']['productitem_code']; ?>
<?php echo '",
				data: "primarycode="+code,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert(\'Changed\');
							window.location.href = \'/website/catalogue/item/image.php?code='; ?>
<?php echo $this->_tpl_vars['productitemData']['productitem_code']; ?>
<?php echo '\';
						} else {
							alert(data.message);
						}
				}
		});		
	}
	return false;			
}

function deleteitem(code) {
	if(confirm(\'Are you sure you want to delete this item?\')) {
		$.ajax({
				type: "GET",
				url: "image.php?code='; ?>
<?php echo $this->_tpl_vars['productitemData']['productitem_code']; ?>
<?php echo '",
				data: "deletecode="+code,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert(\'Deleted\');
							window.location.href = \'/website/catalogue/item/image.php?code='; ?>
<?php echo $this->_tpl_vars['productitemData']['productitem_code']; ?>
<?php echo '\';
						} else {
							alert(data.message);
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