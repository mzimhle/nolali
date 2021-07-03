<?php /* Smarty version 2.6.20, created on 2015-06-04 18:32:04
         compiled from facility/default.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'facility/default.tpl', 62, false),)), $this); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datuma Guest House - Facilities / Guest Houses</title>
	<meta name="keywords" content="our suits, suits, rooms, guest house, south africa, thornton cape town, bed and breakfast, western cape, accomodation">
	<meta name="description" content="<?php echo $this->_tpl_vars['campaign']['campaign_name']; ?>
 has a range of available rooms and suits of your choice, you can choose from here as to which one you would like to book.">          
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="21 days">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta property="og:title" content="<?php echo $this->_tpl_vars['campaign']['campaign_name']; ?>
"> 
	<meta property="og:image" content="http://<?php echo $this->_tpl_vars['campaign']['campaign_domain']; ?>
/images/logo.png"> 
	<meta property="og:url" content="http://<?php echo $this->_tpl_vars['campaign']['campaign_domain']; ?>
">
	<meta property="og:site_name" content="<?php echo $this->_tpl_vars['campaign']['campaign_name']; ?>
">
	<meta property="og:type" content="website">
	<meta property="og:description" content="<?php echo $this->_tpl_vars['campaign']['campaign_name']; ?>
 has a range of available rooms and suits of your choice, you can choose from here as to which one you would like to book.">
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/css.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/javascript.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

	<?php echo '
	<script type="text/javascript">
		$(document).ready(function() {
			
			'; ?>
<?php $_from = $this->_tpl_vars['productitemData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['gallery'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['gallery']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['gallery']['iteration']++;
?><?php echo '
			
			$(".fancybox_'; ?>
<?php echo $this->_tpl_vars['item']['productitem_code']; ?>
<?php echo '_click").click(function() {
				$.fancybox.open([
					'; ?>
<?php $_from = $this->_tpl_vars['item']['productitemimage']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fancyimage'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fancyimage']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['image']):
        $this->_foreach['fancyimage']['iteration']++;
?><?php echo '
					{ href : '; ?>
'http://<?php echo $this->_tpl_vars['campaign']['campaign_domain']; ?>
/<?php echo $this->_tpl_vars['image']['productitemimage_path']; ?>
/big_<?php echo $this->_tpl_vars['image']['productitemimage_code']; ?>
<?php echo $this->_tpl_vars['image']['productitemimage_extension']; ?>
', title : '<?php echo $this->_tpl_vars['image']['productitemimage_description']; ?>
' <?php echo '}'; ?>
<?php if (($this->_foreach['fancyimage']['iteration'] == $this->_foreach['fancyimage']['total'])): ?><?php else: ?>,<?php endif; ?><?php echo '
					'; ?>
<?php endforeach; endif; unset($_from); ?><?php echo '
				], {
					padding : 0
				});
				return false;
			});
			'; ?>
<?php endforeach; endif; unset($_from); ?><?php echo '		
			});
	</script>	
	'; ?>
	
</head>
<body>
<div id="wrap">
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/header.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
	
	<div id="main">
		<h2>We offer several kinds of rooms</h2>
		<div id="gallery">
			<?php $_from = $this->_tpl_vars['productitemData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['facility'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['facility']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['facility']['iteration']++;
?>
			<div class="galleryitem">
				<a href="javascript:;" class="fancybox_<?php echo $this->_tpl_vars['item']['productitem_code']; ?>
_click"> 
					<img class="extra-img png" width="200" src="/<?php echo $this->_tpl_vars['item']['productitemimage_path']; ?>
/tmb_<?php echo $this->_tpl_vars['item']['productitemimage_code']; ?>
<?php echo $this->_tpl_vars['item']['productitemimage_extension']; ?>
" title="<?php echo $this->_tpl_vars['item']['campaign_name']; ?>
 - <?php echo $this->_tpl_vars['item']['productitem_name']; ?>
" alt="<?php echo $this->_tpl_vars['campaign']['campaign_name']; ?>
 - <?php echo $this->_tpl_vars['item']['productitem_name']; ?>
" />
				</a>
				<br />
				<b class="gallerytitle"><?php echo $this->_tpl_vars['item']['productitem_name']; ?>
</b><br />
				<p><?php echo $this->_tpl_vars['item']['productitem_description']; ?>
</p>
				<?php $_from = $this->_tpl_vars['item']['productitems']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['productitem']):
?>
				<p class="sectionitem"><?php echo $this->_tpl_vars['productitem']['productitem_name']; ?>
</p>
				<?php endforeach; endif; unset($_from); ?>
				<p><b>Prices</b></p>
				<?php if (! empty ( $this->_tpl_vars['item']['price'] )): ?>
				<?php $_from = $this->_tpl_vars['item']['price']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['price']):
?>
					<p class="sectionitem"><?php echo $this->_tpl_vars['price']['_price_number']; ?>
 people - R <?php echo ((is_array($_tmp=$this->_tpl_vars['price']['_price_cost'])) ? $this->_run_mod_handler('number_format', true, $_tmp, 2, ",", ".") : number_format($_tmp, 2, ",", ".")); ?>
 per night</p>				
				<?php endforeach; endif; unset($_from); ?>	
				<?php else: ?>
					<p class="sectionitem">No prices set yet</p>
				<?php endif; ?>				
				<p><b>Features</b></p>
				<?php if (! empty ( $this->_tpl_vars['item']['feature'] )): ?>
				<?php $_from = $this->_tpl_vars['item']['feature']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['feature']):
?>
					<p class="sectionitem"><?php echo $this->_tpl_vars['feature']['productitemdata_name']; ?>
 - <?php echo $this->_tpl_vars['feature']['productitemdata_description']; ?>
</p>				
				<?php endforeach; endif; unset($_from); ?>	
				<?php else: ?>
					<p class="sectionitem">No prices set yet</p>
				<?php endif; ?>
<br />				
				<div class="button">
					<span><span><a href="javascript:;" class="fancybox_<?php echo $this->_tpl_vars['item']['product_code']; ?>
_click">view facility</a></span></span>
				</div>
			</div>
			<?php if (!($this->_foreach['facility']['iteration'] % 3)): ?><div class="line-hor"></div><?php endif; ?>
			<?php endforeach; endif; unset($_from); ?>
		</div>
	</div>
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/sidebar.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
	
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/footer.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
	
</div>
</body>
</html>