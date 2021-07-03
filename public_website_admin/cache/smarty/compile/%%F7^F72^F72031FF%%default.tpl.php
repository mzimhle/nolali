<?php /* Smarty version 2.6.20, created on 2015-06-11 10:18:37
         compiled from gallery/default.tpl */ ?>
<!DOCTYPE html><!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]--><!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]--><!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]--><!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]--><head>	<title><?php echo $this->_tpl_vars['domainData']['campaign_name']; ?>
 Management System</title>	<meta charset="utf-8">	<meta name="description" content="">	<meta name="viewport" content="width=device-width">	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
</head><body><?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
<div class="container">  <div class="content">    <div class="content-container">	<div class="content-header">		<h2 class="content-header-title">Galleries</h2>		<ol class="breadcrumb">		<li><a href="/">Home</a></li>		<li class="active"><a href="/gallery/">Galleries</a></li>		</ol>	</div>	  	<div class="row">        <div class="col-md-12">		<button class="btn btn-secondary fr" type="button" onclick="link('/gallery/details.php'); return false;">Add a new Gallery</button><br/ ><br />          <div class="portlet">            <div class="portlet-header">              <h3>                <i class="fa fa-hand-o-up"></i>                Gallery List              </h3>            </div> <!-- /.portlet-header -->			              <div class="portlet-content">           			              <div class="table-responsive">              <table                 class="table table-striped table-bordered table-hover table-highlight"                 data-provide="datatable"                 data-display-rows="30"                data-info="true"                data-search="true"                data-length-change="false"                data-paginate="true"              >					<thead>						<tr>							<th></th>							<th data-sortable="true">Name</th>							<th></th>													</tr>					</thead>											   <tbody>				  <?php $_from = $this->_tpl_vars['galleryData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>				  <tr>					<td>						<?php if ($this->_tpl_vars['item']['galleryimage_path'] != ''): ?>						<a href="http://<?php echo $this->_tpl_vars['domainData']['campaign_domain']; ?>
/<?php echo $this->_tpl_vars['item']['galleryimage_path']; ?>
/tny_<?php echo $this->_tpl_vars['item']['galleryimage_code']; ?>
<?php echo $this->_tpl_vars['item']['galleryimage_extension']; ?>
">							<img src="http://<?php echo $this->_tpl_vars['domainData']['campaign_domain']; ?>
/<?php echo $this->_tpl_vars['item']['galleryimage_path']; ?>
/tny_<?php echo $this->_tpl_vars['item']['galleryimage_code']; ?>
<?php echo $this->_tpl_vars['item']['galleryimage_extension']; ?>
" width="60" />						</a>						<?php else: ?>							<img src="http://www.mailbok.co.za/images/no-image.jpg" width="60" />						<?php endif; ?>											</td>						<td><a href="/gallery/details.php?code=<?php echo $this->_tpl_vars['item']['gallery_code']; ?>
"><?php echo $this->_tpl_vars['item']['gallery_name']; ?>
</a></td>						<td>						<button onclick="deleteModal('<?php echo $this->_tpl_vars['item']['gallery_code']; ?>
', '', 'default'); return false;" class="btn btn-danger">Delete</button>					</td>				  </tr>				<?php endforeach; else: ?>				<tr><td colspan="6">No galleries have been added yet</td></tr>				  <?php endif; unset($_from); ?>				  </tbody>                </table>              </div> <!-- /.table-responsive -->            </div> <!-- /.portlet-content -->          </div> <!-- /.portlet -->        </div> <!-- /.col -->	  </div> <!-- /.content --></div> <!-- /.container --><?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
</html>