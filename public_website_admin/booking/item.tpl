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
		<h2 class="content-header-title">Booking</h2>
		<ol class="breadcrumb">
			<li><a href="/">Home</a></li>
			<li><a href="/booking/item/">Booking</a></li>
			<li><a href="#">{$bookingData.booking_person_name} - {$bookingData.booking_person_email}</a></li>
			<li class="active">Items</li>
		</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					Items List
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/booking/item.php?code={$bookingData.booking_code}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">			
				<p>Below is a list of items under this booking.</p>
				<table class="table table-bordered">	
					<thead>
					  <tr>				
						<th valign="top">Product Booked</th>
						<th valign="top">Price</th>
						<th valign="top">Quantity</th>
						<th valign="top"></th>			
					  </tr>
					</thead>
					<tbody>
					{foreach from=$priceitemData item=item}
					  <tr>	
						<td valign="top">{$item.productitem_name}</td>
						<td valign="top">R {$item._price_cost|number_format:0:".":","}</td>
						<td valign="top">{$item._priceitem_quantity}</td>
						<td valign="top">
							<button value="Delete" class="btn btn-danger" onclick="deleteModal('{$item._priceitem_code}', '{$item.booking_code}', 'item'); return false;">Delete</button>
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
					<label for="_price_code">Product and Price</label>
					<select name="_price_code" id="_price_code" class="form-control" >
						<option value=""> --------------- </option>
						{html_options options=$pricePairs}
					</select>
					{if isset($errorArray._price_code)}<br /><span class="error">{$errorArray._price_code}</span>{/if}					  
                </div>
                <div class="form-group">
					<label for="_priceitem_quantity">Quantity</label>
					<input type="text" id="_priceitem_quantity" name="_priceitem_quantity" class="form-control" data-required="true" value="{$bookingData._priceitem_quantity}" />
					{if isset($errorArray._priceitem_quantity)}<br /><span class="error">{$errorArray._priceitem_quantity}</span>{/if}					  
                </div>				
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
              </form>
            </div> <!-- /.portlet-content --> 
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->	
		<div class="col-sm-3">
			<div class="list-group">  
				<a class="list-group-item" href="/booking/">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/booking/details.php?code={$bookingData.booking_code}">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a> 
				<a class="list-group-item" href="#">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Items
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/booking/payment.php?code={$bookingData.booking_code}">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Payments
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>				
				<a class="list-group-item" href="/booking/generate.php?code={$bookingData.booking_code}">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Generate PDF Invoice
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