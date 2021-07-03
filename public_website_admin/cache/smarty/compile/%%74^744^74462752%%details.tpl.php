<?php /* Smarty version 2.6.20, created on 2015-05-16 13:36:08
         compiled from website/gallery/details.tpl */ ?>
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
			<li><a href="/website/" title="Home">Campaign</a></li>
			<li><a href="/website/gallery/" title="">Gallery</a></li>
			<li><?php if (isset ( $this->_tpl_vars['galleryData'] )): ?>Edit Gallery<?php else: ?>Add a Gallery<?php endif; ?></li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2><?php if (isset ( $this->_tpl_vars['galleryData'] )): ?>Edit Gallery<?php else: ?>Add a Gallery<?php endif; ?></h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="<?php if (isset ( $this->_tpl_vars['galleryData'] )): ?>/website/gallery/image.php?code=<?php echo $this->_tpl_vars['galleryData']['gallery_code']; ?>
<?php else: ?>#<?php endif; ?>" title="Images">Images</a></li>
        </ul>
    </div><!--tabs-->

	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/website/gallery/details.php<?php if (isset ( $this->_tpl_vars['galleryData'] )): ?>?code=<?php echo $this->_tpl_vars['galleryData']['gallery_code']; ?>
<?php endif; ?>" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
           <tr>
            <td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="gallery_name" id="gallery_name" value="<?php echo $this->_tpl_vars['galleryData']['gallery_name']; ?>
" size="60"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['gallery_name'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['gallery_name']; ?>
</em><?php endif; ?>
			</td>	
          </tr>							  
          <tr>
            <td>
				<h4 class="error">Description:</h4><br />
				<textarea name="gallery_description" id="gallery_description" rows="10" cols="120"><?php echo $this->_tpl_vars['galleryData']['gallery_description']; ?>
</textarea>
				<?php if (isset ( $this->_tpl_vars['errorArray']['gallery_description'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['gallery_description']; ?>
</em><?php endif; ?>
			</td>	
          </tr>			  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="/website/gallery/" class="button cancel mrg_left_147 fl"><span>Cancel</span></a>
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
	$(document).ready(function() {
		
		new nicEditor({
			iconsPath	: \'/library/javascript/nicedit/nicEditorIcons.gif\',
			buttonList 	: [\'bold\',\'italic\',\'underline\',\'left\',\'center\', \'ol\', \'ul\', \'xhtml\', \'fontFormat\', \'fontFamily\', \'fontSize\', \'unlink\', \'link\', \'strikethrough\', \'superscript\', \'subscript\'],
			maxHeight 	: \'800\'
		}).panelInstance(\'gallery_description\');
			
	});
	
	function submitForm() {
		nicEditors.findEditor(\'gallery_description\').saveContent();
		document.forms.detailsForm.submit();					 
	}	
</script>
'; ?>

<!-- End Main Container -->
</body>
</html>