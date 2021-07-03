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
						<form name="detailsForm" id="detailsForm" action="/admin/products/items.php?code={$productData.product_code}" method="post">
						<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<th>Name</th>
							<th></th>
							<th></th>
						   </tr>
						{if isset($productitemData)} 
						{foreach from=$productitemData item=item name=food}
						  <tr>							  
							<td align="left" class="alt">
								<input type="text" name="productitem_name_{$item.productitem_code}" id="productitem_name_{$item.productitem_code}" value="{$item.productitem_name}" size="60" />
							</td>							
							<td align="left" class="alt">
								<a class="link link_{$item.productitem_code}" href="javascript:updateForm({$item.productitem_code});">Update</a>	
							</td>	
							<td align="left" class="alt">
								<a class="link link_{$item.productitem_code}" href="javascript:deleteForm({$item.productitem_code});">Delete</a>	
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
					<h3>Add a feature</h3>
					<div id="tableContent" align="center">		
					<div class="content_table">		
					<form name="additemForm" id="additemForm" action="/admin/products/items.php?code={$productData.product_code}" method="post">					
						<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<th class="error">Name</th>
							<th></th>
						   </tr>			
						  <tr>					  
							<td align="left" class="alt" valign="top">
								<input type="text" name="productitem_name" id="productitem_name" value="" size="60" />
							</td>							
							<td colspan="2">
								<a class="link" href="javascript:addItemForm();">Add Feature</a>	
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
								url: "items.php",
								data: "code={/literal}{$productData.product_code}{literal}&productitem_code_update="+id+"&productitem_name="+$('#productitem_name_'+id).val()+"&productitem_description="+$('#productitem_description_'+id).val(),
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
									url: "items.php",
									data: "code={/literal}{$productData.product_code}{literal}&productitem_code_delete="+id,
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