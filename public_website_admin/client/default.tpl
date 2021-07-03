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
	<li class="active">List</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-md-12">
		<button class="btn btn-secondary fr" type="button" onclick="link('/client/details.php'); return false;">Add a new Category</button><br/ ><br />
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-hand-o-up"></i>
                Category List
              </h3>
            </div> <!-- /.portlet-header -->			  
            <div class="portlet-content">           			
              <div class="table-responsive">
              <table 
                class="table table-striped table-bordered table-hover table-highlight" 
                data-provide="datatable" 
                data-display-rows="30"
                data-info="true"
                data-search="true"
                data-length-change="false"
                data-paginate="true"
              >
					<thead>
						<tr>
							<th data-sortable="true">Name</th>
							<th data-sortable="true">Number of members</th>
							<th></th>							
						</tr>
					</thead>							
				   <tbody>
				  {foreach from=$clientData item=item}
				  <tr>
					<td align="left"><a href="/client/details.php?code={$item.client_code}">{$item.client_name}</a></td>
					<td align="left">{$item.participant_number}</td>
					<td align="left">{if $item.participant_number eq 0}<button onclick="deleteModal('{$item.client_code}', '', 'default'); return false;" class="btn btn-danger">Delete</button>{else}Members linked to category{/if}</td>
				  </tr>
				{foreachelse}
				<tr><td colspan="6">No members have been added yet</td></tr>
				  {/foreach}
				  </tbody>
                </table>
              </div> <!-- /.table-responsive -->
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->	
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}
</body>
</html>
