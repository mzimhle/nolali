<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	{include_php file="{$DOCUMENTROOT}/includes/meta.php"}	
  </head>
  <body>
	{include_php file="{$DOCUMENTROOT}/includes/header.php"}
    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
			<ol class="breadcrumb slim-breadcrumb">
			<li class="breadcrumb-item active" aria-current="page">Prices</li>
			<li class="breadcrumb-item"><a href="/content/article/details.php?id={$contentData.content_id}">{$contentData.content_name}</a></li>
			<li class="breadcrumb-item"><a href="/content/article/">contents</a></li>	
			<li class="breadcrumb-item"><a href="/">{$activeAccount.account_name}</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">contents</h6>
        </div><!-- slim-pageheader -->
		<ul class="nav nav-activity-profile mg-t-20">
			<li class="nav-item">
				<a href="/content/article/details.php?id={$contentData.content_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Details</a>
			</li>
			<li class="nav-item">
				<a href="/content/article/price.php?id={$contentData.content_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Price</a>
			</li>		
		</ul><br />	
        <div class="section-wrapper">
			<label class="section-title">Add price for {$contentData.content_name}</label>
			<p class="mg-b-20 mg-sm-b-10">Below is the list of prices for the content</p>		
          <div class="row">
			<div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
            {if isset($errors)}<div class="alert alert-danger" role="alert"><strong>{$errors}</strong></div>{/if}
			<form action="/content/article/price.php?id={$contentData.content_id}" method="POST">
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td>Name</td>	
                            <td>Type</td>	
                            <td>Original Price</td>	                            
							<td>Discount</td>
							<td>Amount</td>
							<td width="5%">Quantity</td>
							<td>Start Date</td>
							<td>End Date</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					{if isset($priceData)}
					{foreach from=$priceData item=item}
						<tr>
                            <td {if $item.price_active eq '1'}class="success"{else}class="error"{/if}>{$item.price_name}</td>
                            <td {if $item.price_active eq '1'}class="success"{else}class="error"{/if}>{$item.price_type}</td>
							<td {if $item.price_active eq '1'}class="success"{else}class="error"{/if}>R {$item.price_original|number_format:2:".":","}</td>
							<td {if $item.price_active eq '1'}class="success"{else}class="error"{/if}>{$item.price_discount}%</td>
							<td {if $item.price_active eq '1'}class="success"{else}class="error"{/if}>R {$item.price_amount|number_format:2:".":","}</td>
							<td {if $item.price_active eq '1'}class="success"{else}class="error"{/if}>{$item.price_quantity}</td>
							<td {if $item.price_active eq '1'}class="success"{else}class="error"{/if}>{$item.price_added}</td>
							<td {if $item.price_active eq '1'}class="success"{else}class="error"{/if}>{$item.price_date_end}</td>
							<td {if $item.price_active eq '1'}class="success"{else}class="error"{/if}>{if $item.price_active eq '1'}<button class="btn" onclick="deleteModal('{$item.price_id}', '{$contentData.content_id}', 'price'); return false;">Deactivate</button>{else}N / A{/if}</td>
						</tr>			     					
					{/foreach}
					{else}
						<tr>
							<td align="center" colspan="8">There are currently no items</td>
						</tr>	
					{/if}						
					</tbody>					  
				</table>
				<br />
				<p>Add new price below</p>	
				<div class="row">
					<div class="col-sm-6">	
						<div class="form-group">
							<label for="price_name">Name</label>
							<input type="text" id="price_name" name="price_name" size="20" class="form-control" value="" />
							<span class="help-block text">Name of the price</span>	
						</div>	
					</div>					
					<div class="col-sm-6">	
						<div class="form-group">
							<label for="price_type">Type of payment is this</label>
							<select id="price_type" name="price_type" class="form-control">
                                <option value="ONCOFF"> Once Off </option>
                                <option value="MONTHLY"> Monthly </option>
                            </select>
							<span class="help-block text">Select the type of price this is</span>	
						</div>	
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-4">				
						<div class="form-group has-error">
							<label for="price_original">Price</label>
							<input type="text" id="price_original" name="price_original"  size="20" class="form-control" data-required="true"  />
							<span class="help-block text">Please add only number separated by a period ( . ) for cents.</span>	
						</div>
					</div>
					<div class="col-sm-4">	
						<div class="form-group has-error">
							<label for="price_quantity">Number of items</label>
							<input type="text" id="price_quantity" name="price_quantity"  size="20" class="form-control" data-required="true" value="1" />
							<span class="help-block text">Add the number of items for this amount</span>	
						</div>	
					</div>					
					<div class="col-sm-4">	
						<div class="form-group has-error">
							<label for="price_discount">Discount in percentage (%)</label>
							<input type="text" id="price_discount" name="price_discount"  size="20" class="form-control" data-required="true" value="0" />
							<span class="help-block text">This needs to be between 0 and 100</span>	
						</div>	
					</div>
				</div>                
				<div class="row">
					<div class="col-md-6">	
						<div class="form-actions text">
							<input type="submit" value="Add" class="btn btn-primary">
						</div>
					</div>
				</div>
			</form>						
			</div><!-- col-4 -->
          </div><!-- row -->
        </div><!-- section-wrapper -->
		
      </div><!-- container -->
    </div><!-- slim-mainpanel -->
	{include_php file="{$DOCUMENTROOT}/includes/footer.php"}
  </body>
</html>
