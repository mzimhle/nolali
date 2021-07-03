<?php /* Smarty version 2.6.20, created on 2015-05-20 08:03:18
         compiled from article/details.tpl */ ?>
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
	<h2 class="content-header-title">Articles</h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="/article/">Articles</a></li>
	<li><a href="#"><?php if (isset ( $this->_tpl_vars['articleData'] )): ?><?php echo $this->_tpl_vars['articleData']['article_name']; ?>
<?php else: ?>Add a article<?php endif; ?></a></li>
	<li class="active">Details</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					<?php if (isset ( $this->_tpl_vars['articleData'] )): ?><?php echo $this->_tpl_vars['articleData']['article_name']; ?>
<?php else: ?>Add a article<?php endif; ?>
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/article/details.php<?php if (isset ( $this->_tpl_vars['articleData'] )): ?>?code=<?php echo $this->_tpl_vars['articleData']['article_code']; ?>
<?php endif; ?>" method="POST" data-validate="parsley" class="form parsley-form">
                <div class="form-group">
                  <label for="article_name">Name</label>
                  <input type="text" id="article_name" name="article_name" class="form-control" data-required="true" value="<?php echo $this->_tpl_vars['articleData']['article_name']; ?>
" />
				<?php if (isset ( $this->_tpl_vars['errorArray']['article_name'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['article_name']; ?>
</span><?php endif; ?>					  
                </div>			
                <div class="form-group">
					<label for="article_description">Description</label>
					<textarea id="article_description" name="article_description" class="form-control" rows="3"><?php echo $this->_tpl_vars['articleData']['article_description']; ?>
</textarea>
					<?php if (isset ( $this->_tpl_vars['errorArray']['article_description'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['article_description']; ?>
</span><?php endif; ?>					  
                </div>
                <div class="form-group">
					<label for="article_page">Page</label>
					<textarea id="article_page" name="article_page" class="form-control" rows="20"><?php echo $this->_tpl_vars['articleData']['article_page']; ?>
</textarea>
					<?php if (isset ( $this->_tpl_vars['errorArray']['article_page'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['article_page']; ?>
</span><?php endif; ?>					  
                </div>				
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->
		<div class="col-sm-3">
			<div class="list-group">  
				<a class="list-group-item" href="/article/">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<?php if (isset ( $this->_tpl_vars['articleData'] )): ?>					
				<a class="list-group-item" href="#">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a> 
				<a class="list-group-item" href="/article/image.php?code=<?php echo $this->_tpl_vars['articleData']['article_code']; ?>
">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Add Images
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>				
				<?php endif; ?>
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

<script type="text/javascript" language="javascript" src="/library/javascript/nicedit/nicEdit.js"></script>	
<?php echo '
<script type="text/javascript" language="javascript">
$(document).ready(function() {			
	new nicEditor({
		iconsPath	: \'/library/javascript/nicedit/nicEditorIcons.gif\',
		buttonList 	: [\'bold\',\'italic\',\'underline\',\'left\',\'center\', \'ol\', \'ul\', \'xhtml\', \'fontFormat\', \'fontFamily\', \'fontSize\', \'unlink\', \'link\', \'strikethrough\', \'superscript\', \'subscript\', \'upload\'],
		uploadURI : \'/library/javascript/nicedit/nicUpload.php\',
	}).panelInstance(\'article_page\');				
});

function submitForm() {
	nicEditors.findEditor(\'article_page\').saveContent();
	document.forms.detailsForm.submit();					 
}

</script>
'; ?>

</html>