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
              <form id="validate-basic" action="/catalogue/item/image.php?code={$productitemData.productitem_code}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">			
				<p>Below is a list of images under this productitem.</p>
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td>Image</td>
							<td></td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					{foreach from=$productitemimageData item=item}
						<tr>
							<td>
								<a href="http://{$domainData.campaign_domain}/{$item.productitemimage_path}/big_{$item.productitemimage_code}{$item.productitemimage_extension}" target="_blank">
									<img src="http://{$domainData.campaign_domain}/{$item.productitemimage_path}/tny_{$item.productitemimage_code}{$item.productitemimage_extension}" width="60" />
								</a>
							</td>
							<td>
								{if $item.productitemimage_primary eq '0'}
									<button value="Make Primary" class="btn btn-danger" onclick="statusSubModal('{$item.productitemimage_code}', '1', 'image', '{$item.productitem_code}'); return false;">Make Primary</button>
								{else}
								<b>Primary</b>
								{/if}
							</td>
							<td>
								{if $item.productitemimage_primary eq '0'}
									<button value="Delete" class="btn btn-danger" onclick="deleteModal('{$item.productitemimage_code}', '{$item.productitem_code}', 'image'); return false;">Delete</button>
								{else}
								<b>Primary</b>
								{/if}
							</td>
						</tr>			     
					{foreachelse}
						<tr>
							<td align="center" colspan="3">There are currently no items</td>
						</tr>					
					{/foreach}
					</tbody>					  
				</table>
				<p>Add new images below</p>		
                <div class="form-group">
					<label for="imagefiles">Image Upload</label>
					<input type="file" id="imagefiles[]" name="imagefiles[]" multiple />
					{if isset($errorArray.imagefiles)}<br /><span class="error">{$errorArray.imagefiles}</span>{/if}					  
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
				<a class="list-group-item" href="/catalogue/item/">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/catalogue/item/details.php?code={$productitemData.productitem_code}">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/catalogue/item/image.php?code={$productitemData.productitem_code}">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Price
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a> 				
				<a class="list-group-item" href="#">
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