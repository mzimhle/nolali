<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>{$domainData.campaign_name} Management System</title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	{include_php file='includes/css.php'}
</head>
<body>
{include_php file='includes/header.php'}
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
                    <input type="text" name="administrator_name" id="administrator_name" value="{$administratorData.administrator_name}" class="form-control" data-required="true" />
					{if isset($errorArray.administrator_name)}<span class="error">{$errorArray.administrator_name}</span>{/if}		
                  </div> <!-- /.col -->
                </div> <!-- /.form-group -->
                <div class="form-group">
                  <label class="col-md-3">Surname</label>
                  <div class="col-md-7">
                    <input type="text" name="administrator_name" id="administrator_name" value="{$administratorData.administrator_name}" class="form-control" data-required="true" />
					{if isset($errorArray.administrator_name)}<span class="error">{$errorArray.administrator_name}</span>{/if}		
                  </div> <!-- /.col -->
                </div> <!-- /.form-group -->				
                <div class="form-group">
                  <label class="col-md-3">Contact Number</label>
                  <div class="col-md-7">
                    <input type="text" name="administrator_cellphone" id="administrator_cellphone" value="{$administratorData.administrator_cellphone}" class="form-control" data-required="true" />
					{if isset($errorArray.administrator_cellphone)}<span class="error">{$errorArray.administrator_cellphone}</span>{/if}		
                  </div> <!-- /.col -->
                </div> <!-- /.form-group -->
				<hr>
                <div class="form-group">
                  <label class="col-md-3">Log in Email</label>
                  <div class="col-md-7">
                    <input type="text" name="administrator_email" id="administrator_email" value="{$administratorData.administrator_email}" class="form-control"  disabled readonly />
                  </div> <!-- /.col -->
                </div> <!-- /.form-group -->				
                <div class="form-group">
                  <label class="col-md-3">Password</label>
                  <div class="col-md-7">
                    <input type="password" name="administrator_password" id="administrator_password" value="{$administratorData.administrator_password}" class="form-control" data-required="true" />
					{if isset($errorArray.administrator_password)}<span class="error">{$errorArray.administrator_password}</span>{/if}		
                  </div> <!-- /.col -->
                </div> <!-- /.form-group -->
                <div class="form-group">
                  <label class="col-md-3">Re-Type Password</label>
                  <div class="col-md-7">
                    <input type="password" name="administrator_password_2" id="administrator_password_2" value="{$administratorData.administrator_password}" class="form-control" data-required="true" />
					{if isset($errorArray.administrator_password_2)}<span class="error">{$errorArray.administrator_password_2}</span>{/if}		
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
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}
</html>
