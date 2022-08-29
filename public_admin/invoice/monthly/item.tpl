
<!DOCTYPE html>
<html lang="en">
  <head>
	{include_php file="{$DOCUMENTROOT}/includes/meta.php"}
        <link href="/css/summernote-bs4.css" rel="stylesheet">
  </head>
  <body>
	{include_php file="{$DOCUMENTROOT}/includes/header.php"}
    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
			<ol class="breadcrumb slim-breadcrumb">
				<li class="breadcrumb-item active" aria-current="page">Items</li>
				<li class="breadcrumb-item"><a href="/invoice/monthly/details.php?id={$invoicemonthlyData.invoicemonthly_id}">#{$invoicemonthlyData.invoicemonthly_id}</a></li>
				<li class="breadcrumb-item"><a href="/invoice/monthly/">Monthly</a></li>
				<li class="breadcrumb-item"><a href="/invoice/monthly/">Invoice</a></li>
				<li class="breadcrumb-item"><a href="/">{$activeAccount.account_name}</a></li>
				<li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Monthly Invoice</h6>
        </div><!-- slim-pageheader -->
		<ul class="nav nav-activity-profile mg-t-20">
			<li class="nav-item">
				<a href="/invoice/monthly/details.php?id={$invoicemonthlyData.invoicemonthly_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Details</a>
			</li>
			<li class="nav-item">
				<a href="/invoice/monthly/item.php?id={$invoicemonthlyData.invoicemonthly_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Items</a>
			</li>
			<li class="nav-item">
				<a href="/invoice/monthly/invoice.php?id={$invoicemonthlyData.invoicemonthly_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Invoices</a>
			</li>		
		</ul>
        <div class="section-wrapper card card-latest-activity mg-t-20">
			<label class="section-title">Items of {$invoicemonthlyData.invoicemonthly_id}</label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the monthly invoice items</p>
			<div class="row">
				<div class="col-md-6">
					<div class="form-actions text">
						<input type="button" value="Add Product" onclick="addProductModal('{$invoicemonthlyData.invoicemonthly_id}', 'item', 'monthly'); return false;" class="btn btn-secondary" />
					</div>
				</div>
			</div>
			<br />			
            <div class="row">
                <div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
                    {if isset($errors)}<div class="alert alert-danger" role="alert"><strong>{$errors}</strong></div>{/if}				
                    <form action="/invoice/monthly/item.php?id={$invoicemonthlyData.invoicemonthly_id}" method="POST">		  
                        <table class="table table-bordered" width="100%">	
                            <thead>
                                <tr>
                                    <td width="20%">Name</td>
                                    <td width="50%">Description</td>
                                    <td width="5%">Units</td>
                                    <td width="10%">Price</td>
                                    <td width="10%">Amount</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                            {if isset($invoiceitemData)}
                            {foreach from=$invoiceitemData item=item}
							  <tr>
								<td align="left" class="alt">{$item.invoiceitem_title}</td>	
								<td align="left" class="alt">{$item.invoiceitem_text}</td>	
								<td align="left" class="alt">{$item.invoiceitem_quantity}</td>		
								<td align="left" class="alt">R {$item.invoiceitem_amount_unit|number_format:2:",":" "}</td>		
								<td align="left" class="alt">R {$item.invoiceitem_amount_total|number_format:2:",":" "}</td>
								<td align="left" class="alt"><button type="button" class="btn" onclick="javascript:deleteModal('{$item.invoiceitem_id}', '{$item.invoicemonthly_id}', 'item');">delete</button></td>
							  </tr>		     				
                            {/foreach}
                            {else}
                                <tr>
                                    <td align="center" colspan="6">There are currently no items</td>
                                </tr>
                            {/if}						
                            </tbody>					  
                        </table>
                        <br />			
                    </form>
                </div><!-- col-4 -->
            </div><!-- row -->
        </div><!-- section-wrapper -->
		
      </div><!-- container -->
    </div><!-- slim-mainpanel -->
	{include_php file="{$DOCUMENTROOT}/includes/footer.php"}
    {literal}
    <script type="text/javascript">
    $(document).ready(function() {
        $( "#modal_product_name" ).autocomplete({
            source: "/feeds/product.php",
            minLength: 2,
            select: function( event, ui ) {
                if(ui.item.id == '') {
                    $('#modal_product_name').html('');
                    $('#modal_product_id').val('');					
                } else {
                    $('#modal_product_name').val(ui.item.value);
                    $('#modal_product_id').val(ui.item.id);
					getProductPrice(ui.item.id);
                }
                $('#modal_product_name').val('');										
            }
        });			
    });
    </script>
    {/literal}	
  </body>
</html>
