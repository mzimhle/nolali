<?php /* Smarty version 2.6.20, created on 2015-05-17 01:25:39
         compiled from products/product/details.tpl */ ?>
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
			<li><a href="/products/product/" title="">Product</a></li>
			<li><?php if (isset ( $this->_tpl_vars['productData'] )): ?>Edit a product<?php else: ?>Add a product<?php endif; ?></li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2><?php if (isset ( $this->_tpl_vars['productData'] )): ?><?php echo $this->_tpl_vars['productData']['_product_name']; ?>
<?php else: ?>Add a new product<?php endif; ?></h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
        </ul>
    </div><!--tabs-->

	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/products/product/details.php<?php if (isset ( $this->_tpl_vars['productData'] )): ?>?code=<?php echo $this->_tpl_vars['productData']['_product_code']; ?>
<?php endif; ?>" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
				<tr>
					<td class="heading" colspan="3">Product Type</td>
				</tr>
				<tr>
					<td colspan="3">
					<?php if (! isset ( $this->_tpl_vars['productData'] )): ?>
						<select id="_product_type" name="_product_type">
							<option value=""> -------- </option>
							<option value="SERVICE"> Service </option>
							<option value="PAGE"> Page</option>
						</select>
						<?php if (isset ( $this->_tpl_vars['errorArray']['_product_type'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['_product_type']; ?>
</span><?php endif; ?>						
					<?php else: ?>
					<h3 class="success"><?php echo $this->_tpl_vars['productData']['_product_type']; ?>
</h3>
					<input type="hidden" id="_product_type" name="_product_type" value="<?php echo $this->_tpl_vars['productData']['_product_type']; ?>
" />
					<?php endif; ?>
					</td>					
				</tr>
				<tr>
					<td class="left_col error" valign="top"><h4>Name:</h4><br />
						<input type="text" name="_product_name" id="_product_name" value="<?php echo $this->_tpl_vars['productData']['_product_name']; ?>
" size="30"/>
						<?php if (isset ( $this->_tpl_vars['errorArray']['_product_name'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['_product_name']; ?>
</span><?php endif; ?>
					</td>
					<td class="left_col" colspan="2">
						<h4 class="error">Description:</h4><br />
						<textarea type="text" name="_product_description" id="_product_description" rows="3" cols="100"><?php echo $this->_tpl_vars['productData']['_product_description']; ?>
</textarea>
						<?php if (isset ( $this->_tpl_vars['errorArray']['_product_description'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['_product_description']; ?>
</span><?php endif; ?>
					</td>						
				</tr> 		  
				<tr class="service" <?php if ($this->_tpl_vars['productData']['_product_type'] == 'PAGE'): ?>style="display: none;"<?php endif; ?>>
					<td class="left_col error" colspan="3"><h4>Quantity:</h4><br />
						<input type="text" name="_product_service_quantity" id="_product_service_quantity" value="<?php echo $this->_tpl_vars['productData']['_product_service_quantity']; ?>
" size="30"/>
						<?php if (isset ( $this->_tpl_vars['errorArray']['_product_service_quantity'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['_product_service_quantity']; ?>
</span><?php endif; ?>
					</td>
				</tr>
				<tr class="page" <?php if ($this->_tpl_vars['productData']['_product_type'] == 'SERVICE'): ?>style="display: none;"<?php endif; ?>>
					<td class="left_col error" colspan="3"><h4>Page Url:</h4><br />
						<input type="text" name="_product_page_link" id="_product_page_link" value="<?php echo $this->_tpl_vars['productData']['_product_page_link']; ?>
" size="60"/>
						<?php if (isset ( $this->_tpl_vars['errorArray']['_product_page_link'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['_product_page_link']; ?>
</span><?php endif; ?>
					</td>
				</tr>				
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="/products/product/" class="button cancel mrg_left_147 fl"><span>Cancel</span></a>
          <a href="javascript:submitForm();" class="blue_button mrg_left_20 fl"><span>Save &amp; Complete</span></a>   
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
<script type="text/javascript" language="javascript">
function submitForm() {
	document.forms.detailsForm.submit();					 
}
</script>
'; ?>

<!-- End Main Container -->
</body>
</html>