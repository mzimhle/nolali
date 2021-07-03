<?php /* Smarty version 2.6.20, created on 2015-05-16 13:49:59
         compiled from website/gallery/default.tpl */ ?>
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
			<li><a href="/website/gallery/" title="">Gallery</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage  <span class="success"><?php echo $this->_tpl_vars['domainData']['campaign_name']; ?>
</span> Gallery</h2>		
	<a href="/website/gallery/details.php" title="Click to Add a new gallery" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new gallery</span></a> <br />
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">			
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
					<th></th>
					<th>Campaign</th>
					<th>Gallery Name</th>
					<th></th>
					<th></th>
					</tr>
				</thead>
			   <tbody>
			  <?php $_from = $this->_tpl_vars['galleryData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			  <tr>
				<td valign="top">
						<?php if ($this->_tpl_vars['item']['galleryimage_path'] != ''): ?> 
						<img src="http://<?php echo $this->_tpl_vars['item']['campaign_domain']; ?>
/<?php echo $this->_tpl_vars['item']['galleryimage_path']; ?>
/tny_<?php echo $this->_tpl_vars['item']['galleryimage_code']; ?>
<?php echo $this->_tpl_vars['item']['galleryimage_extension']; ?>
" width="80" />
						<?php else: ?>
						<img src="/images/no-image.jpg" width="80" />
						<?php endif; ?>
				</td>	
				<td align="left"><?php echo $this->_tpl_vars['item']['campaign_company']; ?>
</td>
				<td align="left">
						<a href="/website/gallery/details.php?code=<?php echo $this->_tpl_vars['item']['gallery_code']; ?>
" class="<?php if ($this->_tpl_vars['item']['gallery_active'] == '1'): ?>success<?php else: ?>error<?php endif; ?>">
							<?php echo $this->_tpl_vars['item']['gallery_name']; ?>

						</a>
				</td>		
				<td align="left"><button onclick="changeStatus('<?php echo $this->_tpl_vars['item']['gallery_code']; ?>
', '<?php if ($this->_tpl_vars['item']['gallery_active'] == '1'): ?>0<?php else: ?>1<?php endif; ?>'); return false;"><?php if ($this->_tpl_vars['item']['gallery_active'] == '1'): ?>deactivate<?php else: ?>activate<?php endif; ?></button></td>	
				<td align="left"><button onclick="deleteitem('<?php echo $this->_tpl_vars['item']['gallery_code']; ?>
'); return false;">delete</button></td>
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
<?php echo '
<script type="text/javascript" language="javascript">
function deleteitem(code) {					
	if(confirm(\'Are you sure you want to delete this item?\')) {
		$.ajax({ 
				type: "GET",
				url: "default.php",
				data: "delete_code="+code,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert(\'Item deleted!\');
							window.location.href = window.location.href;
						} else {
							alert(data.error);
						}
				}
		});							
	}
	return false;
}

function changeStatus(code, status) {					
	if(confirm(\'Are you sure you want to change this item status?\')) {
		$.ajax({ 
				type: "GET",
				url: "default.php",
				data: "status_code="+code+"&status="+status,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert(\'Item status changed!\');
							window.location.href = window.location.href;
						} else {
							alert(data.error);
						}
				}
		});							
	}
	return false;
}
</script>
'; ?>

</body>
</html>