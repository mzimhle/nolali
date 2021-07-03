<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
		<title>Products | {$domainData.campaign_company}</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/products/">Products</a> &raquo; 
				<a href="/admin/products/details.php?code={$productData.product_code}">{$productData.product_name}</a> &raquo; 
				<a href="#">Images</a>
			</p>			
			<div id="main">
				<div class="clr"></div>
				<p class="linebreak"></p>
				<div class="clr"></div>
				<h3>{$productData.product_name} Product Images</h3>
				<div id="tableContent" align="center">				
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="detailsForm" id="detailsForm" action="/admin/products/images.php?code={$productData.product_code}" method="post">
						<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<th>Added</th>
							<th>Image</th>
							<th>Description</th>
							<th>Primary</th>
							<th></th>
							<th></th>
						   </tr>
						  {foreach from=$productimageData item=item}
						  <tr>							  
							<td align="left" class="alt">
								{$item.productimage_added|date_format}
							</td>													
							<td align="left" class="alt">
								<img src="http://{$domainData.campaign_domain}{$item.productimage_path}/tny_{$item.productimage_code}{$item.productimage_extension}" width="100" />
							</td>								
							<td align="left" class="alt">
								<textarea name="productimage_description_{$item.productimage_code}" id="productimage_description_{$item.productimage_code}" cols="30" rows="5">{$item.productimage_description}</textarea>
							</td>	
							<td align="left" class="alt">
								<input type="radio" name="productimage_primary" id="productimage_primary_{$item.productimage_code}" value="{$item.productimage_code}" {if $item.productimage_primary eq 1} checked="checked"{/if} />
							</td>		
							<td align="left" class="alt">
								<a class="link link_{$item.productimage_code}" href="javascript:updateForm('{$item.productimage_code}');">Update</a>	
							</td>							
							<td align="left" class="alt">
								<a class="link link_{$item.productimage_code}" href="javascript:deleteForm('{$item.productimage_code}');">Delete</a>	
							</td>							
						  </tr>
						  {foreachelse}
							<tr>
								<td colspan="8">There are no current items in the system.</td>
							</tr>
						  {/foreach}  						  						  							  
						</table>
						</form>
					</div>
					</div>
					<h3>Add an image</h3><span class="selecteditem">Please only add jpg, png and gif's.</span>
					<div id="tableContent" align="center">		
					<div class="content_table">		
					<form name="additemForm" id="additemForm" action="/admin/products/images.php?code={$productData.product_code}" method="post"  enctype="multipart/form-data">					
						<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<th {if isset($errorArray.imagefile)}class="error"{/if}>Upload</th>
							<th {if isset($errorArray.productimage_description)}class="error"{/if}>Description</th>
							<th></th>
						   </tr>						
						  <tr>		
							<td align="left" class="alt">
								<input type="file" id="imagefile" name="imagefile" />
							</td>						
							<td align="left" class="alt">
								<textarea name="productimage_description" id="productimage_description" rows="5" cols="30"></textarea>
							</td>	
							<td colspan="2">
							<a class="link" href="javascript:addItemForm();">Add file</a>	
							</td>						
						  </tr>	
						  </table>
						 </form>
					 </div>
					 <!-- End Content Table -->
					<div class="clear"></div>
	  
				</div>
			</div>							
			<div class="clr"></div>
			{include_php file='includes/footer.php'}
			{literal}
				<script type="text/javascript">
				
				function addItemForm() {
					document.forms.additemForm.submit();					 
				}			
				
				function updateForm(id) {					
					if(confirm('Are you sure you want to update this file ?')) {
						var primary = '';
						if($('#productimage_primary_'+id).is(':checked')) {
							primary = id;
						}
						$.ajax({ 
								type: "GET",
								url: "images.php",
								data: "code={/literal}{$productData.product_code}{literal}&productimage_code_update="+id+"&productimage_primary="+primary + "&productimage_description="+$('#productimage_description_'+id).val(),
								dataType: "json",
								success: function(data){
										if(data.result == 1) {
											alert('Updated');
											window.location.href = window.location.href;
										} else {
											alert(data.error);
										}
								}
						});							
					}
				}	
				
				function deleteForm(id) {	
					if(confirm('Are you sure you want to delete this file?')) {

							$.ajax({ 
									type: "GET",
									url: "images.php",
									data: "code={/literal}{$productData.product_code}{literal}&productimage_code_delete="+id,
									dataType: "json",
									success: function(data){
											if(data.result == 1) {
												alert('Deleted');
												window.location.href = window.location.href;
											} else {
												alert(data.error);
											}
									}
							});								
						}
				}					
				</script>
			{/literal}
			</div>
	</body>
</html>