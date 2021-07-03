<?php /* Smarty version 2.6.20, created on 2015-05-16 20:26:17
         compiled from website/article/details.tpl */ ?>
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
			<li><a href="/website/article/" title="">Article</a></li>
			<li><a href="#" title=""><?php if (isset ( $this->_tpl_vars['articleData'] )): ?><?php echo $this->_tpl_vars['articleData']['article_name']; ?>
<?php else: ?>Add a Article<?php endif; ?></a></li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2><?php if (isset ( $this->_tpl_vars['articleData'] )): ?>Edit Article<?php else: ?>Add a Article<?php endif; ?></h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/website/article/details.php<?php if (isset ( $this->_tpl_vars['articleData'] )): ?>?code=<?php echo $this->_tpl_vars['articleData']['article_code']; ?>
<?php endif; ?>" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
          <tr>
			<td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="article_name" id="article_name" value="<?php echo $this->_tpl_vars['articleData']['article_name']; ?>
" size="60" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['article_name'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['article_name']; ?>
</span><?php else: ?><br /><em>As will be seen on the website</em><?php endif; ?>
			</td>					
          </tr>
          <tr>
			<td>
				<h4 class="error">Description:</h4><br />
				<textarea name="article_description" id="article_description" rows="3" cols="100"><?php echo $this->_tpl_vars['articleData']['article_description']; ?>
</textarea><br />
				<?php if (isset ( $this->_tpl_vars['errorArray']['article_description'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['article_description']; ?>
</span><?php else: ?><em>Short article description / introduction</em><?php endif; ?>
			</td>					
          </tr>	
          <tr>
			<td>
				<h4 class="error">Page:</h4><br />
				<textarea id="article_page" name="article_page" cols="100" rows="50"><?php echo $this->_tpl_vars['articleData']['article_page']; ?>
</textarea>
				<?php if (isset ( $this->_tpl_vars['errorArray']['article_page'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['article_page']; ?>
</span><?php endif; ?>
			</td>
          </tr>		  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
	<div class="mrg_top_10">
	  <a class="blue_button mrg_left_147 fl" href="javascript:submitForm();"><span>Save &amp; Complete</span></a>   
	</div>
    <div class="clearer"><!-- --></div>
	<br /><br />	
    </div><!--inner-->
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
		buttonList 	: [\'bold\',\'italic\',\'underline\',\'left\',\'center\', \'ol\', \'ul\', \'xhtml\', \'fontFormat\', \'fontFamily\', \'fontSize\', \'unlink\', \'link\', \'strikethrough\', \'superscript\', \'subscript\', \'upload\'],
		uploadURI : \'/library/javascript/nicedit/nicUpload.php\',
	}).panelInstance(\'article_page\');				
});

function submitForm() {
	nicEditors.findEditor(\'article_page\').saveContent();
	document.forms.detailsForm.submit();					 
}

</script>
'; ?>

<!-- End Main Container -->
</body>
</html>