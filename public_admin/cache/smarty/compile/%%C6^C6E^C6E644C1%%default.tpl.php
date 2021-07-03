<?php /* Smarty version 2.6.20, created on 2015-06-18 20:58:52
         compiled from campaign/default.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'campaign/default.tpl', 46, false),array('modifier', 'default', 'campaign/default.tpl', 58, false),)), $this); ?>
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
			<li><a href="/campaign/" title="Campaign">Campaign</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage Campaign</h2>		
	<a href="/campaign/details.php" title="Click to Add a new Campaign" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new campaign</span></a> <br />
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">			
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
			  <tr>
				<th>Added</th>
				<th>Domain</th>
				<th>Company</th>
				<th>Contact</th>
				<th>Email</th>
				<th>Cellphone</th>
				<th>Area</th>
				<th></th>
			   </tr>
			   </thead>
			   <tbody>
			  <?php $_from = $this->_tpl_vars['campaignData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			  <tr>
				<td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['campaign_added'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
				<td>
					<a href="http://<?php echo $this->_tpl_vars['item']['campaign_domain']; ?>
" target="_blank">Website</a> | 
					<a href="http://<?php echo $this->_tpl_vars['item']['campaign_domain_admin']; ?>
" target="_blank">Admin</a>
				</td>
				<td align="left">
					<a href="/campaign/details.php?code=<?php echo $this->_tpl_vars['item']['campaign_code']; ?>
" class="<?php if ($this->_tpl_vars['item']['campaign_active'] == 1): ?>success<?php else: ?>error<?php endif; ?>">
						<?php echo $this->_tpl_vars['item']['campaign_company']; ?>

					</a>
				</td>	
				<td align="left"><?php echo $this->_tpl_vars['item']['campaign_contact_name']; ?>
 <?php echo $this->_tpl_vars['item']['campaign_contact_surname']; ?>
</td>
				<td align="left"><?php echo $this->_tpl_vars['item']['campaign_email']; ?>
</td>
				<td align="left"><?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['campaign_telephone'])) ? $this->_run_mod_handler('default', true, $_tmp, "N/A") : smarty_modifier_default($_tmp, "N/A")); ?>
 / <?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['campaign_cell'])) ? $this->_run_mod_handler('default', true, $_tmp, "N/A") : smarty_modifier_default($_tmp, "N/A")); ?>
</td>
				<td align="left"><?php echo $this->_tpl_vars['item']['areapost_name']; ?>
</td>
				<td align="left"><button onclick="changeStatus('<?php echo $this->_tpl_vars['item']['campaign_code']; ?>
', '<?php if ($this->_tpl_vars['item']['campaign_active'] == '1'): ?>0<?php else: ?>1<?php endif; ?>')"><?php if ($this->_tpl_vars['item']['campaign_active'] == '1'): ?>Deactivate<?php else: ?>Activate<?php endif; ?></button></td>
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