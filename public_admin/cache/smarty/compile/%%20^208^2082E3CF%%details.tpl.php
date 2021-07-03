<?php /* Smarty version 2.6.20, created on 2015-06-18 22:55:24
         compiled from website/people/type/details.tpl */ ?>
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
			<li><a href="/website/people/" title="">People</a></li>
			<li><a href="/website/people/type/" title="">Type</a></li>
			<li><a href="#" title=""><?php if (isset ( $this->_tpl_vars['participantcategoryData'] )): ?><?php echo $this->_tpl_vars['participantcategoryData']['participantcategory_name']; ?>
<?php else: ?>Add a Type<?php endif; ?></a></li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2><?php if (isset ( $this->_tpl_vars['participantcategoryData'] )): ?>Edit Type<?php else: ?>Add a Type<?php endif; ?></h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/website/people/type/details.php<?php if (isset ( $this->_tpl_vars['participantcategoryData'] )): ?>?code=<?php echo $this->_tpl_vars['participantcategoryData']['participantcategory_code']; ?>
<?php endif; ?>" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
		<?php if (! isset ( $this->_tpl_vars['participantcategoryData'] )): ?>
          <tr>
			<td>
				<h4 class="error">Code:</h4><br />
				<input type="text" name="participantcategory_code" id="participantcategory_code" value="<?php echo $this->_tpl_vars['participantcategoryData']['participantcategory_code']; ?>
" size="60" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['participantcategory_code'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['participantcategory_code']; ?>
</span><?php else: ?><br /><em>Less than or equal to 4 characters</em><?php endif; ?>
			</td>					
          </tr>	 		
		  <?php else: ?>
          <tr>
			<td>
				<h4 class="error">Code:</h4><br />
				<span class="success"><?php echo $this->_tpl_vars['participantcategoryData']['participantcategory_code']; ?>
</span>
			</td>					
          </tr>	 		  
		  <?php endif; ?>
          <tr>
			<td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="participantcategory_name" id="participantcategory_name" value="<?php echo $this->_tpl_vars['participantcategoryData']['participantcategory_name']; ?>
" size="60" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['participantcategory_name'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['participantcategory_name']; ?>
</span><?php else: ?><br /><em>Name of the website gallery type</em><?php endif; ?>
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
function submitForm() {
	document.forms.detailsForm.submit();					 
}
</script>
'; ?>

<!-- End Main Container -->
</body>
</html>