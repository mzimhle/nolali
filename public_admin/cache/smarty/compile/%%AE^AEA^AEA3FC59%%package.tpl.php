<?php /* Smarty version 2.6.20, created on 2015-06-11 10:15:45
         compiled from campaign/package.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'campaign/package.tpl', 55, false),)), $this); ?>
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
			<li><a href="/campaign/" title="">Campaign</a></li>
			<li><?php echo $this->_tpl_vars['campaignData']['campaign_name']; ?>
</li>
			<li>Components</li>
        </ul>
	</div><!--breadcrumb--> 
	<div class="inner">
		<div class="clearer"><!-- --></div>
		<br /><h2>Manage Price</h2><br />
		<div id="sidetabs">
		<ul> 
            <li><a href="/campaign/details.php?code=<?php echo $this->_tpl_vars['campaignData']['campaign_code']; ?>
" title="Details">Details</a></li>
			<li class="active"><a href="#" title="Component">Component</a></li>
		</ul>
		</div><!--tabs-->	
		  <div class="detail_box">  
		  <form name="campaignpackageForm" id="campaignpackageForm" action="/campaign/package.php?code=<?php echo $this->_tpl_vars['campaignData']['campaign_code']; ?>
" method="post">
			  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="innertable"> 
			  <thead>
			  <tr>
				<th valign="top">Package</th>
				<th valign="top">Description</th>
				<th valign="top"></th>	
			  </tr>
			  </thead>
			  <tbody>
			  <?php $_from = $this->_tpl_vars['campaignpackageData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			  <tr>	
				<td valign="top"><?php echo $this->_tpl_vars['item']['_package_name']; ?>
</td>
				<td valign="top"><?php echo $this->_tpl_vars['item']['_package_description']; ?>
</td>	
				<td valign="top"><?php if ($this->_tpl_vars['item']['_campaignpackage_active'] == 1): ?><span class="success">Active Package</span><?php else: ?><span class="error">Inactive Package</span><?php endif; ?></td>	
			  </tr>
			  <?php endforeach; endif; unset($_from); ?>			
			  <tr>
				<td valign="top" colspan="2">
					<select id="_package_code" name="_package_code">
						<option value=""> -------- </option>
						<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['packagePairs']), $this);?>

					</select>
					<?php if (isset ( $this->_tpl_vars['errorArray']['_package_code'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['_package_code']; ?>
</em><?php endif; ?>
				</td>	
				<td valign="top">
					<button type="submit" onclick="submitForm();">Add</button>	
				</td>			
			  </tr>
			  </tbody>
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
</script>
'; ?>
	
<!-- End Main Container -->
</body>
</html>