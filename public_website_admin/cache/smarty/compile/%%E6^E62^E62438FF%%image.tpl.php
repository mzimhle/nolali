<?php /* Smarty version 2.6.20, created on 2015-05-26 15:40:02
         compiled from gallery/image.tpl */ ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title><?php echo $this->_tpl_vars['domainData']['campaign_name']; ?>
 Management System</title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</head>
<body>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<div class="container">
  <div class="content">
    <div class="content-container">
	<div class="content-header">
		<h2 class="content-header-title">Galleries</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="/gallery/">Gallery</a></li>
			<li><a href="#"><?php echo $this->_tpl_vars['galleryData']['gallery_name']; ?>
</a></li>
			<li class="active">Images</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Image List
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/gallery/image.php?code=<?php echo $this->_tpl_vars['galleryData']['gallery_code']; ?>
" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">			
				<p>Below is a list of images under this gallery.</p>
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td>Image</td>
							<td></td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					<?php $_from = $this->_tpl_vars['galleryimageData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
						<tr>
							<td>
								<a href="http://<?php echo $this->_tpl_vars['domainData']['campaign_domain']; ?>
/<?php echo $this->_tpl_vars['item']['galleryimage_path']; ?>
/big_<?php echo $this->_tpl_vars['item']['galleryimage_code']; ?>
<?php echo $this->_tpl_vars['item']['galleryimage_extension']; ?>
" target="_blank">
									<img src="http://<?php echo $this->_tpl_vars['domainData']['campaign_domain']; ?>
/<?php echo $this->_tpl_vars['item']['galleryimage_path']; ?>
/tny_<?php echo $this->_tpl_vars['item']['galleryimage_code']; ?>
<?php echo $this->_tpl_vars['item']['galleryimage_extension']; ?>
" width="60" />
								</a>
							</td>
							<td>
								<?php if ($this->_tpl_vars['item']['galleryimage_primary'] == '0'): ?>
									<button value="Make Primary" class="btn btn-danger" onclick="statusSubModal('<?php echo $this->_tpl_vars['item']['galleryimage_code']; ?>
', '1', 'image', '<?php echo $this->_tpl_vars['item']['gallery_code']; ?>
'); return false;">Make Primary</button>
								<?php else: ?>
								<b>Primary</b>
								<?php endif; ?>
							</td>
							<td>
								<?php if ($this->_tpl_vars['item']['galleryimage_primary'] == '0'): ?>
									<button value="Delete" class="btn btn-danger" onclick="deleteModal('<?php echo $this->_tpl_vars['item']['galleryimage_code']; ?>
', '<?php echo $this->_tpl_vars['item']['gallery_code']; ?>
', 'image'); return false;">Delete</button>
								<?php else: ?>
								<b>Primary</b>
								<?php endif; ?>
							</td>
						</tr>			     
					<?php endforeach; else: ?>
						<tr>
							<td align="center" colspan="3">There are currently no items</td>
						</tr>					
					<?php endif; unset($_from); ?>
					</tbody>					  
				</table>
				<p>Add new images below</p>		
                <div class="form-group">
					<label for="imagefiles">Image Upload</label>
					<input type="file" id="imagefiles[]" name="imagefiles[]" multiple />
					<?php if (isset ( $this->_tpl_vars['errorArray']['imagefiles'] )): ?><br /><span class="error"><?php echo $this->_tpl_vars['errorArray']['imagefiles']; ?>
</span><?php endif; ?>					  
					<br /><span class="error">Allowed files are png, jpg, jpeg, gif</span>
                </div>	
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
				<br />	
				<input type="hidden" value="1" name="image" id="image" />
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->	
		<div class="col-sm-3">
			<div class="list-group">  
				<a class="list-group-item" href="#">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a> 
				<a class="list-group-item" href="/gallery/image.php?code=<?php echo $this->_tpl_vars['galleryData']['gallery_code']; ?>
">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Add Images
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>				
			</div> <!-- /.list-group -->
		</div>			
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</html>