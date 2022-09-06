
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	{include_php file="{$DOCUMENTROOT}/includes/meta.php"}
    <link href="/css/summernote-bs4.css" rel="stylesheet">
  </head>
  <body>
	{include_php file="{$DOCUMENTROOT}/includes/header.php"}
    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
			<ol class="breadcrumb slim-breadcrumb">
			{if isset($productData)}
			<li class="breadcrumb-item active" aria-current="page">Edit</li>
			<li class="breadcrumb-item">{$productData.product_name}</li>
			{else}
			<li class="breadcrumb-item active" aria-current="page">Add</li>
			{/if}			
			<li class="breadcrumb-item"><a href="/">Products</a></li>	
			<li class="breadcrumb-item"><a href="/">{$activeAccount.account_name}</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">products</h6>
        </div><!-- slim-pageheader -->
        {if isset($productData)}
		<ul class="nav nav-activity-profile mg-t-20">
			<li class="nav-item">
				<a href="/product/details.php?id={$productData.product_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Details</a>
			</li>
			<li class="nav-item">
				<a href="/product/price.php?id={$productData.product_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Price</a>
			</li>
			<li class="nav-item">
				<a href="/product/media.php?id={$productData.product_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Media</a>
			</li>              
		</ul><br />
        {/if}		
        <div class="section-wrapper">
			<label class="section-title">{if isset($productData)}Update {$productData.product_name}{else}Add new product{/if}</label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the product</p>				
          <div class="row">
			<div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
            {if isset($errors)}<div class="alert alert-danger" role="alert"><strong>{$errors}</strong></div>{/if}				
            <form action="/product/details.php{if isset($productData)}?id={$productData.product_id}{/if}" method="POST">
                <div class="row">	
                    <div class="col-sm-4">			  
                        <div class="form-group has-error">
                            <label for="product_type">Type</label>
                                <select type="text" id="product_type" name="product_type" class="form-control">
                                    <option value=""> --- Select --- </option>
                                    <option value="PRODUCT" {if isset($productData) && $productData.product_type eq 'PRODUCT'}selected{/if}> PRODUCT </option>
                                    <option value="SERVICE" {if isset($productData) && $productData.product_type eq 'SERVICE'}selected{/if}> SERVICE </option>
                                    <option value="BOOK"  {if isset($productData) && $productData.product_type eq 'BOOK'}selected{/if}> BOOKING </option>
                                    <option value="CATALOG"  {if isset($productData) && $productData.product_type eq 'CATALOG'}selected{/if}> CATALOG </option>
                                </select>
                            <code>Please add the name of the product</code>									
                        </div>
                    </div>				
                    <div class="col-sm-8">			  
                        <div class="form-group has-error">
                            <label for="product_name">Name</label>
                            <input type="text" id="product_name" name="product_name" class="form-control" value="{if isset($productData)}{$productData.product_name}{/if}" />
                            <code>Please add the name of the product</code>									
                        </div>
                    </div>				
				</div>
				<div class="row">
                    <div class="col-sm-12">			  
                        <div class="form-group">
                            <label for="product_text">Description</label>
                            <textarea id="product_text" name="product_text" class="form-control wysihtml5" rows="5">{if isset($productData)}{$productData.product_text}{/if}</textarea>
                            <code>Add description of the product</code>									
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-actions text">
                            <input type="submit" value="{if !isset($productData)}Add{else}Update{/if}" class="btn btn-primary" />
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
    <script src="/library/javascript/summernote-0.8.18-dist/summernote-bs4.min.js"></script>
    {literal}
    <script type="text/javascript">
    $(document).ready(function() {
        // Summernote editor
        $('#product_text').summernote({
          height: 150,
          tooltip: false
        })
    });
    </script>
    {/literal}	
  </body>
</html>
