<?php /* Smarty version 2.6.20, created on 2015-06-11 10:18:21
         compiled from account/default.tpl */ ?>
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
	<h2 class="content-header-title">My Account</h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li class="active"><a href="#">My Account</a></li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-md-9 col-sm-8">
          <div class="tab-content stacked-content">
            <div class="tab-pane fade in active" id="profile-tab">
              <h3 class="">Edit My Account Details</h3>
              <br />
              <form id="validate-basic" action="/account/" method="POST" data-validate="parsley" class="form-horizontal parsley-form">
                <div class="form-group">
                  <label class="col-md-3">Name</label>
                  <div class="col-md-7">
                    <input type="text" name="administrator_name" id="administrator_name" value="<?php echo $this->_tpl_vars['administratorData']['administrator_name']; ?>
" class="form-control" data-required="true" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['administrator_name'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['administrator_name']; ?>
</span><?php endif; ?>		
                  </div> <!-- /.col -->
                </div> <!-- /.form-group -->
                <div class="form-group">
                  <label class="col-md-3">Surname</label>
                  <div class="col-md-7">
                    <input type="text" name="administrator_name" id="administrator_name" value="<?php echo $this->_tpl_vars['administratorData']['administrator_name']; ?>
" class="form-control" data-required="true" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['administrator_name'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['administrator_name']; ?>
</span><?php endif; ?>		
                  </div> <!-- /.col -->
                </div> <!-- /.form-group -->				
                <div class="form-group">
                  <label class="col-md-3">Contact Number</label>
                  <div class="col-md-7">
                    <input type="text" name="administrator_cellphone" id="administrator_cellphone" value="<?php echo $this->_tpl_vars['administratorData']['administrator_cellphone']; ?>
" class="form-control" data-required="true" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['administrator_cellphone'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['administrator_cellphone']; ?>
</span><?php endif; ?>		
                  </div> <!-- /.col -->
                </div> <!-- /.form-group -->
				<hr>
                <div class="form-group">
                  <label class="col-md-3">Log in Email</label>
                  <div class="col-md-7">
                    <input type="text" name="administrator_email" id="administrator_email" value="<?php echo $this->_tpl_vars['administratorData']['administrator_email']; ?>
" class="form-control"  disabled readonly />
                  </div> <!-- /.col -->
                </div> <!-- /.form-group -->				
                <div class="form-group">
                  <label class="col-md-3">Password</label>
                  <div class="col-md-7">
                    <input type="password" name="administrator_password" id="administrator_password" value="<?php echo $this->_tpl_vars['administratorData']['administrator_password']; ?>
" class="form-control" data-required="true" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['administrator_password'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['administrator_password']; ?>
</span><?php endif; ?>		
                  </div> <!-- /.col -->
                </div> <!-- /.form-group -->
                <div class="form-group">
                  <label class="col-md-3">Re-Type Password</label>
                  <div class="col-md-7">
                    <input type="password" name="administrator_password_2" id="administrator_password_2" value="<?php echo $this->_tpl_vars['administratorData']['administrator_password']; ?>
" class="form-control" data-required="true" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['administrator_password_2'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['administrator_password_2']; ?>
</span><?php endif; ?>		
                  </div> <!-- /.col -->
                </div> <!-- /.form-group -->
				<hr>				
				<br />
                <div class="form-group">
                  <div class="col-md-7 col-md-push-3">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    &nbsp;
                    <button type="reset" class="btn btn-default">Cancel</button>
                  </div> <!-- /.col -->
                </div> <!-- /.form-group -->
              </form>
            </div> <!-- /.tab-pane --> 
          </div> <!-- /.tab-content -->

        </div> <!-- /.col -->
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</html>