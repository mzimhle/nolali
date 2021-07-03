<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>{$account.website_name}</title>
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
	<h2 class="content-header-title">Categories</h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="/client/">Categories</a></li>
	<li>{if isset($clientData)}{$clientData.client_name}{else}Add a category{/if}</li>
	<li class="active">Details</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					{if isset($clientData)}Edit a category{else}Add a category{/if}
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/client/details.php{if isset($clientData)}?code={$clientData.client_code}{/if}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">
                <div class="form-group">
					<label for="client_name">Name</label>
					<input type="text" id="client_name" name="client_name" class="form-control" data-required="true" value="{$clientData.client_name}" />
					{if isset($errorArray.client_name)}<span class="error">{$errorArray.client_name}</span>{/if}					  
                </div>				
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->	
		<div class="col-sm-3">
			<div class="list-group">  
				<a class="list-group-item" href="/client/">
					<i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
					<i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="#">
					<i class="fa fa-envelope"></i> &nbsp;&nbsp;Details
					<i class="fa fa-chevron-right list-group-chevron"></i>
				</a>			
			</div> <!-- /.list-group -->
		</div>		
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}

</html>
