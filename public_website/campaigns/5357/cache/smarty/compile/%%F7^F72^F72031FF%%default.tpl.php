<?php /* Smarty version 2.6.20, created on 2015-06-04 18:31:36
         compiled from gallery/default.tpl */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datuma Guest House - Galleries</title>
	<meta name="keywords" content="our galleries, guest house pictures, images, rooms, guest house, south africa, thornton cape town, western cape, accomodation">
	<meta name="description" content="<?php echo $this->_tpl_vars['campaign']['campaign_name']; ?>
 has a lot of memories to share with our previous guest, please see below as to what they had experience as well as our guest house.">          
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
 has a lot of memories to share with our previous guest, please see below as to what they had experience as well as our guest house.">
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/css.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/javascript.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

	<?php echo '
	<script type="text/javascript">
		$(document).ready(function() {
			
			'; ?>
<?php $_from = $this->_tpl_vars['galleryData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['gallery'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['gallery']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['gallery']['iteration']++;
?><?php echo '
			
			$(".fancybox_'; ?>
<?php echo $this->_tpl_vars['item']['gallery_code']; ?>
<?php echo '_click").click(function() {
				$.fancybox.open([
					'; ?>
<?php $_from = $this->_tpl_vars['item']['images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fancyimage'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fancyimage']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['image']):
        $this->_foreach['fancyimage']['iteration']++;
?><?php echo '
					{ href : '; ?>
'http://<?php echo $this->_tpl_vars['campaign']['campaign_domain']; ?>
/<?php echo $this->_tpl_vars['image']['galleryimage_path']; ?>
/big_<?php echo $this->_tpl_vars['image']['galleryimage_code']; ?>
<?php echo $this->_tpl_vars['image']['galleryimage_extension']; ?>
', title : '' <?php echo '}'; ?>
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
		<p>Below is a list of all our galleries, here you will find the people who have enjoyed a stay at our beautiful guest house. Please enjoy</p>
		<div class="line-hor"></div>
		<div id="gallery">
			<?php $_from = $this->_tpl_vars['galleryData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['gallery'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['gallery']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['gallery']['iteration']++;
?>
			<div class="galleryitem">
				<a href="javascript:;" class="fancybox_<?php echo $this->_tpl_vars['item']['gallery_code']; ?>
_click"> 
					<img class="extra-img png" src="/<?php echo $this->_tpl_vars['item']['galleryimage_path']; ?>
/tmb_<?php echo $this->_tpl_vars['item']['galleryimage_code']; ?>
<?php echo $this->_tpl_vars['item']['galleryimage_extension']; ?>
" title="<?php echo $this->_tpl_vars['campaign']['campaign_name']; ?>
 - <?php echo $this->_tpl_vars['item']['gallery_name']; ?>
" alt="<?php echo $this->_tpl_vars['item']['campaign_name']; ?>
 - <?php echo $this->_tpl_vars['item']['gallery_name']; ?>
" width="200" />
				</a>
				<br />
				<b class="gallerytitle"><?php echo $this->_tpl_vars['item']['gallery_name']; ?>
</b><br />
				<p><?php echo $this->_tpl_vars['item']['gallery_description']; ?>
</p>
				<br />
				<div class="button">
					<span><span><a href="javascript:;" class="fancybox_<?php echo $this->_tpl_vars['item']['gallery_code']; ?>
_click">view gallery</a></span></span>
				</div>
			</div>
			<?php if (!($this->_foreach['gallery']['iteration'] % 3)): ?><div class="line-hor"></div><?php endif; ?>
			<?php endforeach; else: ?>
			<p>There are unfortunately not image galleries at the moment.</p>
			<?php endif; unset($_from); ?>
		</div>
	</div>
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/sidebar.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
	
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/footer.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
	
</div>
</body>
</html>