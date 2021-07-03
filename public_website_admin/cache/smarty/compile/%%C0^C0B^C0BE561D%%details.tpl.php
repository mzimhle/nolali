<?php /* Smarty version 2.6.20, created on 2015-05-17 01:22:18
         compiled from website/catalogue/item/details.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'website/catalogue/item/details.tpl', 53, false),)), $this); ?>
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
			<li><?php if (isset ( $this->_tpl_vars['productitemData'] )): ?>Edit item<?php else: ?>Add an item<?php endif; ?></li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2><?php if (isset ( $this->_tpl_vars['productitemData'] )): ?>Edit item<?php else: ?>Add a item<?php endif; ?></h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="<?php if (isset ( $this->_tpl_vars['productitemData'] )): ?>/website/catalogue/item/price.php?code=<?php echo $this->_tpl_vars['productitemData']['productitem_code']; ?>
<?php else: ?>#<?php endif; ?>" title="Price">Price</a></li>
			<li><a href="<?php if (isset ( $this->_tpl_vars['productitemData'] )): ?>/website/catalogue/item/image.php?code=<?php echo $this->_tpl_vars['productitemData']['productitem_code']; ?>
<?php else: ?>#<?php endif; ?>" title="Images">Images</a></li>
			<li><a href="<?php if (isset ( $this->_tpl_vars['productitemData'] )): ?>/website/catalogue/item/extra.php?code=<?php echo $this->_tpl_vars['productitemData']['productitem_code']; ?>
<?php else: ?>#<?php endif; ?>" title="Extras">Extras</a></li>			
        </ul>
    </div><!--tabs-->

	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/website/catalogue/item/details.php<?php if (isset ( $this->_tpl_vars['productitemData'] )): ?>?code=<?php echo $this->_tpl_vars['productitemData']['productitem_code']; ?>
<?php endif; ?>" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
           <tr>
            <td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="productitem_name" id="productitem_name" value="<?php echo $this->_tpl_vars['productitemData']['productitem_name']; ?>
" size="80"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['productitem_name'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['productitem_name']; ?>
</em><?php endif; ?>
			</td>	
          </tr>	
           <tr>
            <td>
				<h4 class="error">Product:</h4><br />
				<select id="product_code" name="product_code">
					<option value=""> ---------------------- </option>
					<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['productpairs'],'selected' => $this->_tpl_vars['productitemData']['product_code']), $this);?>

				</select>
				<?php if (isset ( $this->_tpl_vars['errorArray']['productitem_name'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['productitem_name']; ?>
</em><?php endif; ?>
			</td>	
          </tr>			  
          <tr>
            <td>
				<h4 class="error">Description:</h4><br />
				<textarea name="productitem_description" id="productitem_description" rows="3" cols="80"><?php echo $this->_tpl_vars['productitemData']['productitem_description']; ?>
</textarea>
				<?php if (isset ( $this->_tpl_vars['errorArray']['productitem_description'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['productitem_description']; ?>
</em><?php endif; ?>
			</td>	
          </tr>	
          <tr>
            <td>
				<h4>Page:</h4><br />
				<textarea name="productitem_page" id="productitem_page" rows="30" cols="120"><?php echo $this->_tpl_vars['productitemData']['productitem_page']; ?>
</textarea>
				<?php if (isset ( $this->_tpl_vars['errorArray']['productitem_page'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['productitem_page']; ?>
</em><?php endif; ?>
			</td>	
          </tr>		  
        </table>
		<input type="hidden" id="action" name="action" value="details" />
      </form>
        <div class="mrg_top_10">
          <a href="/website/catalogue/item/" class="button cancel mrg_left_147 fl"><span>Cancel</span></a>
          <a href="javascript:submitForm();" class="blue_button mrg_left_20 fl"><span>Save &amp; Complete</span></a>   
        </div>
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
$(document).ready(function() {		
	new nicEditor({
		iconsPath	: \'/library/javascript/nicedit/nicEditorIcons.gif\',
		buttonList 	: [\'bold\',\'italic\',\'underline\',\'left\',\'center\', \'ol\', \'ul\', \'xhtml\', \'fontFormat\', \'fontFamily\', \'fontSize\', \'unlink\', \'link\', \'strikethrough\', \'superscript\', \'subscript\'],
		maxHeight 	: \'800\'
	}).panelInstance(\'productitem_page\');	
});

function submitForm() {
	nicEditors.findEditor(\'productitem_page\').saveContent();
	document.forms.detailsForm.submit();					 
}
</script>
'; ?>

<!-- End Main Container -->
</body>
</html>