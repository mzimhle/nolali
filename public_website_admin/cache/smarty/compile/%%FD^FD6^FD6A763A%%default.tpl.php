<?php /* Smarty version 2.6.20, created on 2015-05-14 23:45:36
         compiled from website/inquiry/default.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'website/inquiry/default.tpl', 44, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nolali - The Creative</title>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<script type="text/javascript" language="javascript" src="default.js"></script>
</head>

<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content Section -->
  <div id="content">
    <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

	<div id="breadcrumb">
        <ul>
            <li><a href="/" title="Home">Home</a></li>
            <li><a href="/website/" title="Website">Website</a></li>
			<li><a href="/website/inquiry/" title="Inquiries">Inquiries</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage <?php echo $this->_tpl_vars['domainData']['campaign_name']; ?>
 Inquiries</h2>
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">			
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
				<tr>
				<th>Added</th>
				<th>Name</th>
				<th>Email</th>
				<th>Number</th>
				<th>Subject</th>
				<th>Message</th>
				</tr>
			   </thead>
			   <tbody> 
			  <?php $_from = $this->_tpl_vars['inquiryData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			  <tr>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['inquiry_added'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
				<td align="left"><?php echo $this->_tpl_vars['item']['inquiry_name']; ?>
</td>
				<td align="left"><?php echo $this->_tpl_vars['item']['inquiry_email']; ?>
</td>	
				<td align="left"><?php echo $this->_tpl_vars['item']['inquiry_number']; ?>
</td>
				<td align="left"><?php echo $this->_tpl_vars['item']['inquiry_subject']; ?>
</td>
				<td align="left"><?php echo $this->_tpl_vars['item']['inquiry_comments']; ?>
</td>
			  </tr>
			  <?php endforeach; endif; unset($_from); ?>     
			  </tbody>
			</table>
		 </div>
		 <!-- End Content Table -->	
	</div>
    <div class="clearer"><!-- --></div>
    </div><!--inner-->
  </div><!-- End Content Section -->
 <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</div>
<!-- End Main Container -->
</body>
</html>