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
		<h2 class="content-header-title">Items</h2>
	<ol class="breadcrumb">
		<li><a href="/">Home</a></li>
		<li><a href="/catalogue/">Catalogue</a></li>
		<li><a href="#">{$productitemData.product_name}</a></li>
		<li><a href="/catalogue/item">Items</a></li>
		<li><a href="#">{$productitemData.productitem_name}</a></li>
		<li class="active">Extras</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Extras List
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/catalogue/item/extra.php?code={$productitemData.productitem_code}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">			
				<p>Below is a list of images under this item.</p>
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td>Type</td>
							<td>Name</td>
							<td>Description</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					{foreach from=$productitemdataData item=item}
					  <tr>	
						<td valign="top">{$item.productitemdata_type}</td>
						<td valign="top">{$item.productitemdata_name}</td>
						<td valign="top">{$item.productitemdata_description}</td>
						<td valign="top">
							<button value="Delete" class="btn btn-danger" onclick="deleteModal('{$item.productitemdata_code}', '{$item.productitem_code}', 'extra'); return false;">Delete</button>
						</td>						
					  </tr>			     
					{foreachelse}
						<tr>
							<td align="center" colspan="4">There are currently no items</td>
						</tr>					
					{/foreach}
					</tbody>					  
				</table>
				<p>Add new price below</p>
                <div class="form-group">
					<label for="productitemdata_type">Type</label>
					<select name="productitemdata_type" id="productitemdata_type" class="form-control" >
						<option value=""> --------------- </option>
						<option value="FEATURES"> FEATURES </option>
						<option value="SERVICES"> SERVICES </option>
						<option value="EXTRAS"> EXTRAS </option>
					</select>
					{if isset($errorArray.productitemdata_type)}<br /><span class="error">{$errorArray.productitemdata_type}</span>{/if}					  
                </div>
                <div class="form-group">
					<label for="productitemdata_name">Name</label>
					<input type="text" id="productitemdata_name" name="productitemdata_name" class="form-control" data-required="true" value="{$productitemData.productitemdata_name}" />
					{if isset($errorArray.productitemdata_name)}<br /><span class="error">{$errorArray.productitemdata_name}</span>{/if}					  
                </div>
                <div class="form-group">
					<label for="productitemdata_description">Description</label>
					<textarea id="productitemdata_description" name="productitemdata_description" class="form-control" data-required="true" cols="20" rows="3"></textarea>
					{if isset($errorArray.productitemdata_description)}<br /><span class="error">{$errorArray.productitemdata_description}</span>{/if}					  
                </div>				
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
              </form>
            </div> <!-- /.portlet-content --> 
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->	
		<div class="col-sm-3">
			<div class="list-group">  
				<a class="list-group-item" href="/catalogue/item/">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/catalogue/item/details.php?code={$productitemData.productitem_code}">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="#">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Price
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a> 				
				<a class="list-group-item" href="/catalogue/item/image.php?code={$productitemData.productitem_code}">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Add Images
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/catalogue/item/extra.php?code={$productitemData.productitem_code}">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Add Extras
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