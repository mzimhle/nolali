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
			<li class="breadcrumb-item active" aria-current="page">Media</li>
			<li class="breadcrumb-item"><a href="/product/details.php?id={$productData.product_id}">{$productData.product_name}</a></li>
            <li class="breadcrumb-item"><a href="/product/">Product</a></li>            
			<li class="breadcrumb-item"><a href="/">{$activeAccount.account_name}</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Media</h6>
        </div><!-- slim-pageheader -->
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
        <div class="section-wrapper">
          <label class="section-title">Images for  {$productData.product_name}</label>	
          <div class="row">
			<div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
            {if isset($errors)}<div class="alert alert-danger" role="alert"><strong>{$errors}</strong></div>{/if}
			<form action="/product/media.php?id={$productData.product_id}" method="POST" enctype="multipart/form-data">
				<table class="table table-bordered">	
					<thead>
						<tr>
							<td></td>	
							<td></td>
							<td></td>                            
							<td></td>
						</tr>
					</thead>
					<tbody>
					{if isset($mediaData)}
					{foreach from=$mediaData item=item}
						<tr>
                            <td><img src="{$config.site}{$item.media_path}tny_{$item.media_code}{$item.media_ext}" /></td>
                            <td>{$item.media_text}</td>
							<td>{if $item.media_primary eq '0'}<button class="btn" onclick="deleteModal('{$item.media_id}', '{$productData.product_id}', 'media'); return false;">Delete</button>{else}N / A{/if}</td>
							<td>{if $item.media_primary eq '0'}<button class="btn" onclick="statusSubModal('{$item.media_id}', '0', 'media', '{$productData.product_id}'); return false;">Primary</button>{else}N / A{/if}</td>
						</tr>
					{/foreach} id, status, page, parent
					{else}
						<tr>
							<td align="center" colspan="3">There are currently no images</td>
						</tr>	
					{/if}						
					</tbody>					  
				</table>
				<div class="row">					
					<div class="col-sm-12">	
						<div class="form-group has-error">
							<label for="price_discount">Upload Image(s)</label><br />
							<input type="file" id="mediafiles[]" name="mediafiles[]" multiple /><br />
							<span class="help-block text">Please only upload <b>.jpg</b>, <b>.jpeg</b> and <b>.png</b></span>	
						</div>	
					</div>
				</div> 
				<div class="row">					
					<div class="col-sm-12">	
						<div class="form-group">
							<label for="media_text">Image message</label><br />
							<textarea class="form-control" id="media_text" name="media_text" rows="5"></textarea><br />
							<span class="help-blodck text">Add message for the image(s) to upload</span>	
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
