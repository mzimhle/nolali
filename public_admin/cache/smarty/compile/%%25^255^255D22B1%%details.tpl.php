<?php /* Smarty version 2.6.20, created on 2015-05-23 12:10:49
         compiled from website/templates/details.tpl */ ?>
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
			<li><a href="/website/templates/" title="">Templates</a></li>
			<li><a href="#" title=""><?php if (isset ( $this->_tpl_vars['templateData'] )): ?><?php echo $this->_tpl_vars['templateData']['template_name']; ?>
<?php else: ?>Add a template<?php endif; ?></a></li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2><?php if (isset ( $this->_tpl_vars['templateData'] )): ?><?php echo $this->_tpl_vars['templateData']['template_name']; ?>
<?php else: ?>Details<?php endif; ?></h2>
    <div id="sidetabs">
        <ul>  
            <li class="active"><a href="#" title="Details">Details</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/website/templates/details.php<?php if (isset ( $this->_tpl_vars['templateData'] )): ?>?code=<?php echo $this->_tpl_vars['templateData']['template_code']; ?>
<?php endif; ?>" method="post" enctype="multipart/form-data">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
          <tr>
			<td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="template_name" id="template_name" value="<?php echo $this->_tpl_vars['templateData']['template_name']; ?>
" size="60" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['template_name'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['template_name']; ?>
</span><?php endif; ?>
			</td>		
          </tr>
		  <tr>
			<td>
				<h4 class="error">Template Type:</h4><br />
				<select id="template_type" name="template_type" >
					<option value=""> ----- </option>
					<option value="INVOICE" <?php if ($this->_tpl_vars['templateData']['template_type'] == 'INVOICE'): ?>selected<?php endif; ?>> INVOICE </option>
					<option value="INQUIRY" <?php if ($this->_tpl_vars['templateData']['template_type'] == 'INQUIRY'): ?>selected<?php endif; ?>> INQUIRY </option>
					<option value="ESTIMATE" <?php if ($this->_tpl_vars['templateData']['template_type'] == 'ESTIMATE'): ?>selected<?php endif; ?>> COST ESTIMATE </option>
					<option value="QUOTATION" <?php if ($this->_tpl_vars['templateData']['template_type'] == 'QUOTATION'): ?>selected<?php endif; ?>> QUOTATION </option>
				</select>
				<?php if (isset ( $this->_tpl_vars['errorArray']['template_type'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['template_type']; ?>
</span><?php endif; ?>			
			</td>		  
		  </tr>
          <tr>
			<td>
				<h4>Note:</h4><br />
				To add peoples names on the mailer please add the following variables on the mailer: <br /><br />
					<table>					
						<tr><td>[fullname]</td><td>=</td><td>Member Name and Surname</td></tr>
						<tr><td>[name]</td><td>=</td><td>Member Name</td></tr>
						<tr><td>[surname]</td><td>=</td><td>Member Surname</td></tr>
						<tr><td>[cellphone]</td><td>=</td><td>Member Cellphone</td></tr>
						<tr><td>[address]</td><td>=</td><td>Member Address</td></tr>
						<tr><td>[email]</td><td>=</td><td>Client email</td></tr>
						<tr><td>[message]</td><td>=</td><td>Message to be sent</td></tr>
						<tr><td>[tracking]</td><td>=</td><td>Code for tracking email opened by client</td></tr>
						<tr><td>[date]</td><td>=</td><td>Date sent out to client</td></tr>
						<?php if (isset ( $this->_tpl_vars['templateData'] )): ?>
							<tr><td>Image paths</td><td>=</td><td>http://<?php echo $this->_tpl_vars['templateData']['campaign_domain']; ?>
/media/templates/<?php echo $this->_tpl_vars['templateData']['template_code']; ?>
/images/imagename.jpg</td></tr>
						<?php endif; ?>
						<?php if (isset ( $this->_tpl_vars['templateData'] ) && $this->_tpl_vars['templateData']['template_file'] != ''): ?><tr><td>View file</td><td>=</td><td>
							<a href="http://<?php echo $this->_tpl_vars['templateData']['campaign_domain']; ?>
/media/templates/<?php echo $this->_tpl_vars['templateData']['template_code']; ?>
/<?php echo $this->_tpl_vars['templateData']['template_code']; ?>
.html" target="_blank" >
								http://<?php echo $this->_tpl_vars['templateData']['campaign_domain']; ?>
/media/templates/<?php echo $this->_tpl_vars['templateData']['template_code']; ?>
/<?php echo $this->_tpl_vars['templateData']['template_code']; ?>
.html
							</a>
						</td></tr>
					<?php endif; ?>						
					</table><br />					
				<h4>Upload HTML File:</h4><br />
				<input type="file" name="htmlfile" id="htmlfile" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['htmlfile'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['htmlfile']; ?>
</span><?php else: ?><br /><em>Only .html and .htm allowed</em><?php endif; ?>					
			</td>
          </tr>
          <tr> 
			<td>			
				<h4>Upload CSS File:</h4><br />
				<input type="file" name="cssfile" id="cssfile" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['cssfile'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['cssfile']; ?>
</span><?php else: ?><br /><em>Only .css allowed</em><?php endif; ?>					
			</td>
          </tr>	 		  
          <tr> 
			<td>			
				<h4>Upload image files:</h4><br />
				<input type="file" name="imagefiles[]" id="imagefiles[]" multiple />
				<?php if (isset ( $this->_tpl_vars['errorArray']['imagefiles'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['imagefiles']; ?>
</span><?php else: ?><br /><em>Only .png, .jpeg, .gif and .jpg allowed</em><?php endif; ?>					
			</td>
          </tr>	  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
	<div class="mrg_top_10">
	  <a class="button cancel mrg_left_147 fl" href="/website/templates/"><span>Cancel</span></a>
	  <a class="blue_button mrg_left_20 fl" href="javascript:submitForm();"><span>Save &amp; Complete</span></a>   
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