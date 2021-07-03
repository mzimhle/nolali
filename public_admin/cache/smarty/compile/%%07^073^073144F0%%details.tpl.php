<?php /* Smarty version 2.6.20, created on 2015-05-13 17:12:26
         compiled from products/items/details.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>E-Manager</title>
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
			<li><a href="/products/items/" title="">Items</a></li>
			<li><?php if (isset ( $this->_tpl_vars['productpriceData'] )): ?>Edit a product<?php else: ?>Add a product<?php endif; ?></li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2><?php if (isset ( $this->_tpl_vars['productpriceData'] )): ?>Edit product: <?php echo $this->_tpl_vars['productpriceData']['_productprice_name']; ?>
<?php else: ?>Add a new product<?php endif; ?></h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
        </ul>
    </div><!--tabs-->

	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/products/items/details.php<?php if (isset ( $this->_tpl_vars['productpriceData'] )): ?>?code=<?php echo $this->_tpl_vars['productpriceData']['_productprice_code']; ?>
<?php endif; ?>" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
			<tr>
				<td colspan="2" class="heading">Details</td>
			</tr>
           <tr>
            <td class="left_col"><h4>Active</h4></td>
            <td><input type="checkbox" name="_productprice_active" id="_productprice_active" value="1" <?php if ($this->_tpl_vars['productpriceData']['_productprice_active'] == 1): ?> checked="checked" <?php endif; ?> /></td>
          </tr>	
          <tr>
            <td class="left_col" <?php if (isset ( $this->_tpl_vars['errorArray']['_productprice_name'] )): ?>style="color: red"<?php endif; ?>><h4>Name:</h4></td>
			<td><input type="text" name="_productprice_name" id="_productprice_name" value="<?php echo $this->_tpl_vars['productpriceData']['_productprice_name']; ?>
" size="30"/></td>	
          </tr> 		  
          <tr>
            <td class="left_col" <?php if (isset ( $this->_tpl_vars['errorArray']['_productprice_description'] )): ?>style="color: red"<?php endif; ?>><h4>Description:</h4></td>
			<td><textarea type="text" name="_productprice_description" id="_productprice_description" rows="5" cols="50"><?php echo $this->_tpl_vars['productpriceData']['_productprice_description']; ?>
</textarea></td>	
          </tr>	  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="/products/items/" class="button cancel mrg_left_147 fl"><span>Cancel</span></a>
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