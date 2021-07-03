<?php /* Smarty version 2.6.20, created on 2015-06-11 10:16:35
         compiled from website/administrator/default.tpl */ ?>
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
			<li><a href="#" title="Website"><span class="success"><?php echo $this->_tpl_vars['domainData']['campaign_name']; ?>
</span></a></li>
			<li><a href="/website/administrator/" title="">Administrator</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage <span class="success"><?php echo $this->_tpl_vars['domainData']['campaign_name']; ?>
</span> Administrators</h2>			
	<a href="/website/administrator/details.php" title="Click to Add a new Administrator" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new Administrator</span></a> <br />
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
			<thead>
			  <tr>	
				<th>Full Name</th>
				<th>Cellphone</th>
				<th>Email</th>
				<th>Password</th>
				<th>Last Login</th>
				<th></th>
			   </tr>
			   </thead>
			   <tbody>
			  <?php $_from = $this->_tpl_vars['administratorData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			  <tr>
				<td align="left"><a href="/website/administrator/details.php?code=<?php echo $this->_tpl_vars['item']['administrator_code']; ?>
"><?php echo $this->_tpl_vars['item']['administrator_name']; ?>
 <?php echo $this->_tpl_vars['item']['administrator_surname']; ?>
</a></td>	
				<td align="left"><?php echo $this->_tpl_vars['item']['administrator_cellphone']; ?>
</td>
				<td align="left"><?php echo $this->_tpl_vars['item']['administrator_email']; ?>
</td>	
				<td align="left"><?php echo $this->_tpl_vars['item']['administrator_password']; ?>
</td>		
				<td align="left"><?php echo $this->_tpl_vars['item']['administrator_last_login']; ?>
</td>		
				<td align="left"><button onclick="deleteitem('<?php echo $this->_tpl_vars['item']['administrator_code']; ?>
')">Delete</button></td>	
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