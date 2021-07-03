<?php /* Smarty version 2.6.20, created on 2015-05-25 20:43:27
         compiled from people/details.tpl */ ?>
<!DOCTYPE html><!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]--><!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]--><!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]--><!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]--><head>	<title><?php echo $this->_tpl_vars['domainData']['campaign_name']; ?>
 Management System</title>	<meta charset="utf-8">	<meta name="description" content="">	<meta name="viewport" content="width=device-width">	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
	 </head><body><?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
<div class="container">  <div class="content">    <div class="content-container">	<div class="content-header">	<h2 class="content-header-title">People</h2>	<ol class="breadcrumb">	<li><a href="/">Home</a></li>	<li><a href="/people/">People</a></li>	<li><?php if (isset ( $this->_tpl_vars['participantData'] )): ?><?php echo $this->_tpl_vars['participantData']['participant_name']; ?>
 <?php echo $this->_tpl_vars['participantData']['participant_surname']; ?>
<?php else: ?>Add a member<?php endif; ?></li>	<li class="active">Details</li>	</ol>	</div>	      <div class="row">        <div class="col-sm-9">          <div class="portlet">            <div class="portlet-header">              <h3>                <i class="fa fa-tasks"></i>					<?php if (isset ( $this->_tpl_vars['participantData'] )): ?><?php echo $this->_tpl_vars['participantData']['participant_name']; ?>
 <?php echo $this->_tpl_vars['participantData']['participant_surname']; ?>
<?php else: ?>Add a member<?php endif; ?>              </h3>            </div> <!-- /.portlet-header -->            <div class="portlet-content">              <form id="validate-basic" action="/people/details.php<?php if (isset ( $this->_tpl_vars['participantData'] )): ?>?code=<?php echo $this->_tpl_vars['participantData']['participant_code']; ?>
<?php endif; ?>" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">                <div class="form-group">					<label for="participant_name">Name</label>					<input type="text" id="participant_name" name="participant_name" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['participantData']['participant_name']; ?>
" />					<?php if (isset ( $this->_tpl_vars['errorArray']['participant_name'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['participant_name']; ?>
</span><?php endif; ?>					                  </div>                <div class="form-group">					<label for="participant_surname">Surname</label>					<input type="text" id="participant_surname" name="participant_surname" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['participantData']['participant_surname']; ?>
" />					<?php if (isset ( $this->_tpl_vars['errorArray']['participant_surname'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['participant_surname']; ?>
</span><?php endif; ?>					                  </div>				                <div class="form-group">					<label for="participant_email">Email</label>					<input type="text" id="participant_email" name="participant_email" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['participantData']['participant_email']; ?>
" />					<?php if (isset ( $this->_tpl_vars['errorArray']['participant_email'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['participant_email']; ?>
</span><?php endif; ?>					                  </div>	                <div class="form-group">					<label for="participant_cellphone">Cellphone</label>					<input type="text" id="participant_cellphone" name="participant_cellphone" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['participantData']['participant_cellphone']; ?>
" />					<?php if (isset ( $this->_tpl_vars['errorArray']['participant_cellphone'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['participant_cellphone']; ?>
</span><?php endif; ?>					                  </div>                <div class="form-group">					<label for="areapost_name">Area</label>					<input type="text" name="areapost_name" id="areapost_name" value="<?php echo $this->_tpl_vars['participantData']['areapost_name']; ?>
" class="form-control" data-required="true"/>					<input type="hidden" name="areapost_code" id="areapost_code" value="<?php echo $this->_tpl_vars['participantData']['areapost_code']; ?>
" />					<?php if (isset ( $this->_tpl_vars['errorArray']['areapost_code'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['areapost_code']; ?>
</span><?php endif; ?>					                  </div>                <div class="form-group">				<br />				<?php if ($this->_tpl_vars['participantData']['participant_image_path'] != ''): ?><img src="http://<?php echo $this->_tpl_vars['participantData']['campaign_domain']; ?>
/<?php echo $this->_tpl_vars['participantData']['participant_image_path']; ?>
/tny_<?php echo $this->_tpl_vars['participantData']['participant_image_name']; ?>
<?php echo $this->_tpl_vars['item']['participant_image_extension']; ?>
" /><?php else: ?><img src="http://www.mailbok.co.za/images/no-image.jpg" /><?php endif; ?>				<br /><?php if (isset ( $this->_tpl_vars['errorArray']['profilelogo'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['profilelogo']; ?>
<span><?php else: ?><br /><em>jpg, jpeg, png images only</em><?php endif; ?>					<br /><br />									<label for="participant_description">Upload Image Profile</label>					<input type="file" id="profilelogo" name="profilelogo" />					<?php if (isset ( $this->_tpl_vars['errorArray']['participant_description'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['participant_description']; ?>
</span><?php endif; ?>					                  </div>				                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>              </form>            </div> <!-- /.portlet-content -->          </div> <!-- /.portlet -->        </div> <!-- /.col -->			<div class="col-sm-3">			<div class="list-group">  				<a class="list-group-item" href="#/">				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;Show List				  <i class="fa fa-chevron-right list-group-chevron"></i>				</a>				<a class="list-group-item" href="/people/import.php">				  <i class="fa fa-envelope"></i> &nbsp;&nbsp;Import CVS List				  <i class="fa fa-chevron-right list-group-chevron"></i>				</a>			</div> <!-- /.list-group -->		</div>		      </div> <!-- /.row -->    </div> <!-- /.content-container -->  </div> <!-- /.content --></div> <!-- /.container --><?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
<?php echo '<script type="text/javascript">$( document ).ready(function() {	$( "#areapost_name" ).autocomplete({		source: "/feeds/areapost.php",		minLength: 2,		select: function( event, ui ) {			if(ui.item.id == \'\') {				$(\'#areapost_name\').html(\'\');				$(\'#areapost_code\').val(\'\');								} else {				$(\'#areapost_name\').html(\'<b>\' + ui.item.value + \'</b>\');				$(\'#areapost_code\').val(ui.item.id);				}			$(\'#areapost_name\').val(\'\');												}	});});</script>'; ?>
</html>