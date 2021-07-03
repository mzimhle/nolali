<?php /* Smarty version 2.6.20, created on 2015-05-17 01:22:00
         compiled from website/catalogue/default.tpl */ ?>
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
			<li><a href="/website/catalogue/" title="">Catalogue</a></li>
        </ul>
	</div><!--breadcrumb-->  	
  <div class="inner">  
   <h2>Nolali</h2>	

  <div class="clearer"><!-- --></div>
  <div class="section">
  	<a href="/website/catalogue/product/" title="Manage Product"><img src="/images/users.gif" alt="Manage Product" height="50" width="50" /></a>
  	<a href="/website/catalogue/product/" title="Manage Product" class="title">Manage Product</a>
  </div> 
  <div class="section mrg_left_50">
  	<a href="/website/catalogue/item/" title="Manage Item"><img src="/images/users.gif" alt="Manage Item" height="50" width="50" /></a>
  	<a href="/website/catalogue/item/" title="Manage Item" class="title">Manage Item</a>
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