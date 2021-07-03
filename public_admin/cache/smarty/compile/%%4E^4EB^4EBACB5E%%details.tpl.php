<?php /* Smarty version 2.6.20, created on 2015-05-14 20:50:24
         compiled from products/package/details.tpl */ ?>
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
			<li><?php if (isset ( $this->_tpl_vars['packageData'] )): ?>Edit a package<?php else: ?>Add a package<?php endif; ?></li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2><?php if (isset ( $this->_tpl_vars['packageData'] )): ?><?php echo $this->_tpl_vars['packageData']['_package_name']; ?>
<?php else: ?>Add a new package<?php endif; ?></h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="<?php if (isset ( $this->_tpl_vars['packageData'] )): ?>/products/package/price.php?code=<?php echo $this->_tpl_vars['packageData']['_package_code']; ?>
<?php else: ?>#<?php endif; ?>" title="Price">Price</a></li>
			<li><a href="<?php if (isset ( $this->_tpl_vars['packageData'] )): ?>/products/package/component.php?code=<?php echo $this->_tpl_vars['packageData']['_package_code']; ?>
<?php else: ?>#<?php endif; ?>" title="Component">Component</a></li>
        </ul>
    </div><!--tabs-->

	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/products/package/details.php<?php if (isset ( $this->_tpl_vars['packageData'] )): ?>?code=<?php echo $this->_tpl_vars['packageData']['_package_code']; ?>
<?php endif; ?>" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
			<tr>
				<td class="heading">Details</td>
			</tr>
          <tr>
            <td class="left_col error"><h4>Name:</h4><br />
				<input type="text" name="_package_name" id="_package_name" value="<?php echo $this->_tpl_vars['packageData']['_package_name']; ?>
" size="30"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['_package_name'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['_package_name']; ?>
</span><?php endif; ?>
			</td>	
          </tr> 		  
          <tr>
            <td class="left_col error">
				<h4>Description:</h4><br />
				<textarea type="text" name="_package_description" id="_package_description" rows="5" cols="100"><?php echo $this->_tpl_vars['packageData']['_package_description']; ?>
</textarea>
				<?php if (isset ( $this->_tpl_vars['errorArray']['_package_description'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['_package_description']; ?>
</span><?php endif; ?>
			</td>	
          </tr>	  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="/products/package/" class="button cancel mrg_left_147 fl"><span>Cancel</span></a>
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