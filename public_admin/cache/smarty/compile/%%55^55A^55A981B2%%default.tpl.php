<?php /* Smarty version 2.6.20, created on 2015-06-18 22:20:02
         compiled from website/default.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'website/default.tpl', 28, false),)), $this); ?>
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
        </ul>
	</div><!--breadcrumb-->  
  <div class="inner">  
   <h2>Campaign</h2>	

	<div class="section">
		Select campaign:
		<select id="campaign_code" name="campaign_code">
			<option value=""> ---- </option>
			<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['campaignPairs'],'selected' => $this->_tpl_vars['domainData']['campaign_code']), $this);?>

		</select>
	</div>
	<?php if (isset ( $this->_tpl_vars['domainData'] )): ?>	   
  <div class="clearer"><!-- --></div>
  <h2>Campaign Administrators</h2>	
  <div class="clearer"><!-- --></div>
  <div class="section">
  	<a href="/website/administrator/" title="Manage Administrators"><img src="/images/users.gif" alt="Manage Administrators" height="50" width="50" /></a>
  	<a href="/website/administrator/" title="Manage Administrators" class="title">Manage Administrators</a>
  </div>
  <div class="section mrg_left_50">
  	<a href="/website/templates/" title="Manage Templates"><img src="/images/users.gif" alt="Manage Templates" height="50" width="50" /></a>
  	<a href="/website/templates/" title="Manage Templates" class="title">Manage Templates</a>
  </div>   
  <div class="clearer"><!-- --></div>
  <h2>Campaign Pages</h2>
  <?php if (isset ( $this->_tpl_vars['level1'] )): ?>
  <?php $_from = $this->_tpl_vars['level1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['level1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['level1']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['level1']['iteration']++;
?>
  <div class="section<?php if (($this->_foreach['level1']['iteration']-1) != '0'): ?> mrg_left_50<?php endif; ?>">
  	<a href="/website/<?php echo $this->_tpl_vars['item']['_product_page_link']; ?>
/" title="<?php echo $this->_tpl_vars['item']['_product_name']; ?>
"><img src="/images/users.gif" alt="<?php echo $this->_tpl_vars['item']['_product_name']; ?>
" height="50" width="50" /></a>
  	<a href="/website/<?php echo $this->_tpl_vars['item']['_product_page_link']; ?>
/" title="Manage <?php echo $this->_tpl_vars['item']['_product_page_link']; ?>
" class="title"><?php echo $this->_tpl_vars['item']['_product_name']; ?>
</a>
  </div> 
  <?php endforeach; endif; unset($_from); ?>
  <?php endif; ?>
    <div class="clearer"><!-- --></div>   
  <?php if (isset ( $this->_tpl_vars['level2'] )): ?>
  <?php $_from = $this->_tpl_vars['level2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['level2'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['level2']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['level2']['iteration']++;
?>
  <div class="section<?php if (($this->_foreach['level2']['iteration']-1) != '0'): ?> mrg_left_50<?php endif; ?>">
  	<a href="/website/<?php echo $this->_tpl_vars['item']['_product_page_link']; ?>
/" title="<?php echo $this->_tpl_vars['item']['_product_name']; ?>
"><img src="/images/users.gif" alt="<?php echo $this->_tpl_vars['item']['_product_name']; ?>
" height="50" width="50" /></a>
  	<a href="/website/<?php echo $this->_tpl_vars['item']['_product_page_link']; ?>
/" title="Manage <?php echo $this->_tpl_vars['item']['_product_page_link']; ?>
" class="title"><?php echo $this->_tpl_vars['item']['_product_name']; ?>
</a>
  </div> 
  <?php endforeach; endif; unset($_from); ?>
  <?php endif; ?>
  <div class="clearer"><!-- --></div>   
  <?php if (isset ( $this->_tpl_vars['level3'] )): ?>
  <?php $_from = $this->_tpl_vars['level3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['level3'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['level3']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['level3']['iteration']++;
?>
  <div class="section<?php if (($this->_foreach['level3']['iteration']-1) != '0'): ?> mrg_left_50<?php endif; ?>">
  	<a href="/website/<?php echo $this->_tpl_vars['item']['_product_page_link']; ?>
/" title="<?php echo $this->_tpl_vars['item']['_product_name']; ?>
"><img src="/images/users.gif" alt="<?php echo $this->_tpl_vars['item']['_product_name']; ?>
" height="50" width="50" /></a>
  	<a href="/website/<?php echo $this->_tpl_vars['item']['_product_page_link']; ?>
/" title="Manage <?php echo $this->_tpl_vars['item']['_product_page_link']; ?>
" class="title"><?php echo $this->_tpl_vars['item']['_product_name']; ?>
</a>
  </div> 
  <?php endforeach; endif; unset($_from); ?>
  <?php endif; ?>  
  <div class="clearer"><!-- --></div> 
  <?php if (isset ( $this->_tpl_vars['level4'] )): ?>
  <?php $_from = $this->_tpl_vars['level4']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['level4'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['level4']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['level4']['iteration']++;
?>
  <div class="section<?php if (($this->_foreach['level4']['iteration']-1) != '0'): ?> mrg_left_50<?php endif; ?>">
  	<a href="/website/<?php echo $this->_tpl_vars['item']['_product_page_link']; ?>
/" title="<?php echo $this->_tpl_vars['item']['_product_name']; ?>
"><img src="/images/users.gif" alt="<?php echo $this->_tpl_vars['item']['_product_name']; ?>
" height="50" width="50" /></a>
  	<a href="/website/<?php echo $this->_tpl_vars['item']['_product_page_link']; ?>
/" title="Manage <?php echo $this->_tpl_vars['item']['_product_page_link']; ?>
" class="title"><?php echo $this->_tpl_vars['item']['_product_name']; ?>
</a>
  </div> 
  <?php endforeach; endif; unset($_from); ?>
  <?php endif; ?>    
    </div><!--inner-->
	<?php endif; ?>
  </div><!-- End Content Section -->
	
 <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>


<?php echo '
<script type="text/javascript">

$( document ).ready(function() {

	$(\'#campaign_code\').change(function() {
	
		var campaigncode	= $(\'#campaign_code :selected\').val();
		
		$.ajax({
			type: "GET",
			url: "default.php",
			data: "campaigncode="+campaigncode,
			dataType: "html",
			success: function(items){
				window.location.href = window.location.href;
			}
		});
		
	});
	
});

</script>
'; ?>

</div>
<!-- End Main Container -->
</body>
</html>