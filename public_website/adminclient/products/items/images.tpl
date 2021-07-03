<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
		<title>{$domainData.campaign_company} Admin | Product Images | {$campaignproductitemData.campaignproductitem_name}</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/products/">Products</a> &raquo;
				<a href="/admin/products/details.php?code={$campaignproductData.campaignproduct_code}">{$campaignproductData.campaignproduct_name}</a> &raquo;
				<a href="/admin/products/items/?code={$campaignproductData.campaignproduct_code}">Items</a> &raquo;
				<a href="/admin/products/items/details.php?code={$campaignproductData.campaignproduct_code}&item={$campaignproductitemData.campaignproductitem_code}">{$campaignproductitemData.campaignproductitem_name}</a> &raquo;
				<a href="#">{$campaignproductitemData.campaignproductitem_name} Gallery</a>
			</p>			
			<div id="main">
				<div class="clr"></div>
				<p class="linebreak"></p>
				<div class="clr"></div>
				<h3>{$campaignproductitemData.campaignproductitem_name} Images</h3>
				<div id="tableContent" align="center">				
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="detailsForm" id="detailsForm" action="#" method="post">
							<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<th>Added</th>
								<th>Filename</th>
								<th>Image</th>
								<th>Description</th>
								<th>Primary</th>
								<!-- <th>Show ?</th> -->
								<th></th>
								<th></th>
							   </tr>
							  {foreach from=$campaignproductitemimageData item=item}
							  <tr>							  
								<td align="left" class="alt">
									{$item.campaignproductitemimage_added|date_format}
								</td>													
								<td align="left" class="alt">
									<input type="text" name="campaignproductitemimage_name_{$item.campaignproductitemimage_code}" id="campaignproductitemimage_name_{$item.campaignproductitemimage_code}" value="{$item.campaignproductitemimage_name}" />
								</td>
								<td align="left" class="alt">
									<img src="http://{$domainData.campaign_domain}{$item.campaignproductitemimage_path}/{$images.tiny.code}{$item.campaignproductitemimage_code}{$item.campaignproductitemimage_extension}" />
								</td>								
								<td align="left" class="alt">
									<textarea name="campaignproductitemimage_description_{$item.campaignproductitemimage_code}" id="campaignproductitemimage_description_{$item.campaignproductitemimage_code}" cols="30" rows="5">{$item.campaignproductitemimage_description}</textarea>
								</td>	
								<td align="left" class="alt">
									<input type="radio" name="campaignproductitemimage_primary" id="campaignproductitemimage_primary_{$item.campaignproductitemimage_code}" value="{$item.campaignproductitemimage_code}" {if $item.campaignproductitemimage_primary eq 1} checked="checked"{/if} />
								</td>		
								<!-- 
								<td align="left" class="alt">
									<input type="checkbox" name="campaignproductitemimage_active_{$item.campaignproductitemimage_code}" id="campaignproductitemimage_active_{$item.campaignproductitemimage_code}" {if $item.campaignproductitemimage_active eq 1}checked{/if} value="1"  />
								</td>
								-->
								<td align="left" class="alt">
									<a class="link link_{$item.campaignproductitemimage_code}" href="javascript:updateForm('{$item.campaignproductitemimage_code}');">Update</a>	
								</td>							
								<td align="left" class="alt">
									<a class="link link_{$item.campaignproductitemimage_code}" href="javascript:deleteForm('{$item.campaignproductitemimage_code}');">Delete</a>	
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
					<form name="additemForm" id="additemForm" action="/admin/products/items/images.php?code={$campaignproductData.campaignproduct_code}&item={$campaignproductitemData.campaignproductitem_code}" method="post"  enctype="multipart/form-data">					
						<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<th {if isset($errorArray.imagefile)}class="error"{/if}>Upload</th>
							<th {if isset($errorArray.campaignproductitemimage_name)}class="error"{/if}>Name</th>
							<th {if isset($errorArray.campaignproductitemimage_description)}class="error"{/if}>Description</th>
							<th></th>
						   </tr>						
						  <tr>		
							<td align="left" class="alt">
								<input type="file" id="imagefile" name="imagefile" />
							</td>
							<td align="left" class="alt">
								<input type="text" name="campaignproductitemimage_name" id="campaignproductitemimage_name" size="40" />
							</td>							
							<td align="left" class="alt">
								<textarea name="campaignproductitemimage_description" id="campaignproductitemimage_description" rows="5" cols="30"></textarea>
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
						if($('#campaignproductitemimage_primary_'+id).is(':checked')) {
							primary = id;
						}
						$.ajax({ 
								type: "GET",
								url: "images.php",
								data: "{/literal}code={$campaignproductData.campaignproduct_code}&item={$campaignproductitemData.campaignproductitem_code}{literal}&campaignproductitemimage_code_update="+id+"&campaignproductitemimage_name="+$('#campaignproductitemimage_name_'+id).val()+"&campaignproductitemimage_primary="+primary + "&campaignproductitemimage_description="+$('#campaignproductitemimage_description_'+id).val(),
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
									data: "{/literal}code={$campaignproductData.campaignproduct_code}&item={$campaignproductitemData.campaignproductitem_code}{literal}&campaignproductitemimage_code_delete="+id,
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