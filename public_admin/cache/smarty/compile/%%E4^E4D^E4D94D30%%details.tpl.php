<?php /* Smarty version 2.6.20, created on 2015-05-19 16:06:33
         compiled from website/people/details.tpl */ ?>
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
			<li><a href="/website/people/" title="">People</a></li>
			<li><a href="#" title=""><?php if (isset ( $this->_tpl_vars['participantData'] )): ?><?php echo $this->_tpl_vars['participantData']['participant_name']; ?>
 <?php echo $this->_tpl_vars['participantData']['participant_surname']; ?>
<?php else: ?>Add a Person<?php endif; ?></a></li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2><?php if (isset ( $this->_tpl_vars['participantData'] )): ?>Edit Person<?php else: ?>Add a Person<?php endif; ?></h2>
    <div id="sidetabs">
        <ul> 
            <li class="active"><a href="#" title="Details">Details</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/website/people/details.php<?php if (isset ( $this->_tpl_vars['participantData'] )): ?>?code=<?php echo $this->_tpl_vars['participantData']['participant_code']; ?>
<?php endif; ?>" method="post"  enctype="multipart/form-data">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">			  	   
          <tr>
            <td>
				<h4 class="error">Name:</h4><br />
				<input type="text" name="participant_name" id="participant_name" value="<?php echo $this->_tpl_vars['participantData']['participant_name']; ?>
" size="40"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['participant_name'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['participant_name']; ?>
</em><?php endif; ?>
			</td>	
            <td>
				<h4 class="error">Surname:</h4><br />
				<input type="text" name="participant_surname" id="participant_surname" value="<?php echo $this->_tpl_vars['participantData']['participant_surname']; ?>
" size="40"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['participant_surname'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['participant_surname']; ?>
</em><?php endif; ?>
			</td>	
            <td>
				<h4 class="error">E-Mail:</h4><br />
				<input type="text" name="participant_email" id="participant_email" value="<?php echo $this->_tpl_vars['participantData']['participant_email']; ?>
" size="40"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['participant_email'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['participant_email']; ?>
</em><?php endif; ?>
			</td>					
          </tr>	 
          <tr>		  
            <td>
				<h4>Cellphone:</h4><br />
				<input type="text" name="participant_cellphone" id="participant_cellphone" value="<?php echo $this->_tpl_vars['participantData']['participant_cellphone']; ?>
" size="40"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['participant_cellphone'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['participant_cellphone']; ?>
</em><?php endif; ?>
			</td>		
			<td colspan="2">
				<h4>Area:</h4><br />
				<input type="text" name="areapost_name" id="areapost_name" value="<?php echo $this->_tpl_vars['participantData']['areapost_name']; ?>
" size="90" />
				<input type="hidden" name="areapost_code" id="areapost_code" value="<?php echo $this->_tpl_vars['participantData']['areapost_code']; ?>
" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['areapost_code'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['areapost_code']; ?>
</em><?php endif; ?>
			</td>			
          </tr>
		  <tr>
			<td>
				<input type="file" name="imagefile" id="imagefile" /><br />
				<?php if (isset ( $this->_tpl_vars['errorArray']['imagefile'] )): ?><em class="error"><?php echo $this->_tpl_vars['errorArray']['imagefile']; ?>
</em><?php else: ?><br /><em>Please only upload jpg, png, gif or jpeg</em><?php endif; ?>
			</td>
			<td colspan="2">
					<?php if ($this->_tpl_vars['participantData']['participant_image_path'] != ''): ?>
						<img src="http://<?php echo $this->_tpl_vars['participantData']['campaign_domain']; ?>
/<?php echo $this->_tpl_vars['participantData']['participant_image_path']; ?>
/tny_<?php echo $this->_tpl_vars['participantData']['participant_image_name']; ?>
<?php echo $this->_tpl_vars['item']['participant_image_extension']; ?>
"  width="90" />
					<?php else: ?>
						<img src="/images/no-image.jpg" width="90" />
					<?php endif; ?>			
			</td>
		  </tr>
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="javascript:submitForm();" class="blue_button mrg_left_20 fl"><span>Save &amp; Complete</span></a>   
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
<script type="text/javascript" language="javascript">

function submitForm() {
	document.forms.detailsForm.submit();					 
}

$( document ).ready(function() {
	$( "#areapost_name" ).autocomplete({
		source: "/feeds/area.php",
		minLength: 2,
		select: function( event, ui ) {
		
			if(ui.item.id == \'\') {
				$(\'#areapost_name\').html(\'\');
				$(\'#areapost_code\').val(\'\');					
			} else {
				$(\'#areapost_name\').html(\'<b>\' + ui.item.value + \'</b>\');
				$(\'#areapost_code\').val(ui.item.id);	
			}
			$(\'#areapost_name\').val(\'\');										
		}
	});
});

</script>
'; ?>

<!-- End Main Container -->
</body>
</html>