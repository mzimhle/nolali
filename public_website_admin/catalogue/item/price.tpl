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
		<li class="active">Price</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Price List
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/catalogue/item/price.php?code={$productitemData.productitem_code}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">			
				<p>Below is a list of images under this productitem.</p>
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td>ID</td>
							<td>Number of Items</td>
							<td>Price</td>
							<td>Start Date</td>
							<td>End Date</td>
						</tr>
					</thead>
					<tbody>
					{foreach from=$priceData item=item}
					  <tr>	
						<td valign="top" {if $item._price_active eq '1'}class="success"{else}class="error"{/if}>{$item._price_id}</td>
						<td valign="top" {if $item._price_active eq '1'}class="success"{else}class="error"{/if}>{$item._price_number} item(s)</td>
						<td valign="top" {if $item._price_active eq '1'}class="success"{else}class="error"{/if}>R {$item._price_cost|number_format:0:".":","}</td>
						<td valign="top" {if $item._price_active eq '1'}class="success"{else}class="error"{/if}>{$item._price_startdate}</td>
						<td valign="top" {if $item._price_active eq '1'}class="success"{else}class="error"{/if} colspan="2">{$item._price_enddate|default:'N/A'}</td>
					  </tr>			     
					{foreachelse}
						<tr>
							<td align="center" colspan="5">There are currently no items</td>
						</tr>					
					{/foreach}
					</tbody>					  
				</table>
				<p>Add new price below</p>
                <div class="form-group">
					<label for="_price_number">Number of items</label>
					<input type="text" id="_price_number" name="_price_number" class="form-control" value="1"/>
					{if isset($errorArray._price_number)}<br /><span class="error">{$errorArray._price_number}</span>{/if}					  
                </div>					
                <div class="form-group">
					<label for="_price_cost">Price amount</label>
					<input type="text" id="_price_cost" name="_price_cost" class="form-control" />
					{if isset($errorArray._price_cost)}<br /><span class="error">{$errorArray._price_cost}</span>{/if}					  
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