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
				<a href="#">Features Items</a>
			</p>			
			<div id="main">
				<div class="clr"></div>
				<p class="linebreak"></p>
				<div class="clr"></div>
				<h3>{$productData.product_name} - Feature items.</h3>
				<div id="tableContent" align="center">				
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="detailsForm" id="detailsForm" action="/admin/products/prices.php?code={$productData.product_code}" method="post">
						<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<th>Name</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Description</th>
							<th></th>
							<th></th>
						   </tr>
						{if isset($productpriceData)} 
						{foreach from=$productpriceData item=item name=food}
						  <tr>							  
							<td align="left" class="alt">
								<input type="text" name="productprice_name_{$item.productprice_code}" id="productprice_name_{$item.productprice_code}" value="{$item.productprice_name}" size="10" />
							</td>	
							<td align="left" class="alt">
								<input type="text" name="productprice_count_{$item.productprice_code}" id="productprice_count_{$item.productprice_code}" value="{$item.productprice_count}" size="10" />
							</td>	
							<td align="left" class="alt">
								<input type="text" name="productprice_price_{$item.productprice_code}" id="productprice_price_{$item.productprice_code}" value="{$item.productprice_price}" size="10" />
							</td>							
							<td align="left" class="alt">
								<textarea name="productprice_description_{$item.productprice_code}" id="productprice_description_{$item.productprice_code}" rows="2" cols="50">{$item.productprice_description}</textarea>
							</td>								
							<td align="left" class="alt">
								<a class="link link_{$item.productprice_code}" href="javascript:updateForm({$item.productprice_code});">Update</a>	
							</td>	
							<td align="left" class="alt">
								<a class="link link_{$item.productprice_code}" href="javascript:deleteForm({$item.productprice_code});">Delete</a>	
							</td>							
						  </tr>
						  {/foreach}
						  {else}
							<tr>
								<td colspan="6">There are no current items in the system.</td>
							</tr>
						  {/if}  						  						  							  
						</table>
						</form>
					</div>
					</div>
					<h3>Add a Price</h3>
					<div id="tableContent" align="center">		
					<div class="content_table">		
					<form name="additemForm" id="additemForm" action="/admin/products/prices.php?code={$productData.product_code}" method="post">					
						<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<th class="error">Name</th>
							<th class="error">Quantity</th>
							<th class="error">Price</th>
							<th class="error">Description</th>
							<th></th>
						   </tr>			
						  <tr>					  
							<td align="left" class="alt" valign="top">
								<input type="text" name="productprice_name" id="productprice_name" value="" size="20" />
							</td>	
							<td align="left" class="alt" valign="top">
								<input type="text" name="productprice_count" id="productprice_count" value="" size="5" />
							</td>
							<td align="left" class="alt" valign="top">
								<input type="text" name="productprice_price" id="productprice_price" value="" size="20" />
							</td>							
							<td align="left" class="alt" valign="top">
								<textarea name="productprice_description" id="productprice_description" rows="3" cols="30"></textarea>
							</td>	
							<td>
								<a class="link" href="javascript:addItemForm();">Add Price</a>	
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
					if(confirm('Are you sure you want to update this item?')) {			
						
						$.ajax({ 
								type: "GET",
								url: "prices.php",
								data: "code={/literal}{$productData.product_code}{literal}&productprice_code_update="+id+"&productprice_name="+$('#productprice_name_'+id).val()+"&productprice_description="+$('#productprice_description_'+id).val()+"&productprice_count="+$('#productprice_count_'+id).val()+"&productprice_price="+$('#productprice_price_'+id).val(),
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
					if(confirm('Are you sure you want to delete this item?')) {

							$.ajax({ 
									type: "GET",
									url: "prices.php",
									data: "code={/literal}{$productData.product_code}{literal}&productprice_code_delete="+id,
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