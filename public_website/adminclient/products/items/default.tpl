<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
		<script type="text/javascript" language="javascript" src="default.js"></script>
		<title>{$domainData.campaign_company}| Admin | {$campaignproductData.campaignproduct_name}</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/products/">Products</a> &raquo;
				<a href="/admin/products/details.php?code={$campaignproductData.campaignproduct_code}">{$campaignproductData.campaignproduct_name}</a> &raquo;
				<a href="#">Product Items</a>
			</p>
			<p class="linebreak"></p>
			<div id="main">
				<a class="link" href="/admin/products/items/details.php?code={$campaignproductData.campaignproduct_code}">Add a New Item</a>
				<div id="tableContent" align="center">
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="htmlForm" id="htmlForm" action="/admin/products/" method="post">
							<table border="0" cellspacing="0" cellpadding="0" id="dataTable">							
								<thead>
								<tr>
									<th>Added</th>
									<th>Name</th>
									<th>Price</th>
									<th>Description</th>
									<th>Status</th>
									<th></th>
								</tr>
								</thead>							
							   <tbody>
							  {foreach from=$campaignproductitemData item=item}
							  <tr>
								<td>{$item.campaignproductitem_added|date_format}</td>
								<td align="left"><a href="/admin/products/items/details.php?code={$campaignproductData.campaignproduct_code}&item={$item.campaignproductitem_code}">{$item.campaignproductitem_name}</a></td>	
								<td align="left">R {$item.campaignproductitem_price|number_format:2:".":","}</td>
								<td align="left">{$item.campaignproductitem_description}</td>
								<td align="left">{if $item.campaignproductitem_active eq 1}<span class="success">Active</span>{else}<span class="error">Not active</span>{/if}</td>
								<td align="left"><a class="link" href="javascript:deleteForm('{$item.campaignproductitem_code}');">Delete</a>	</td>
							  </tr>
							  {/foreach}     
							  </tbody>
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
			function deleteForm(id) {	
				if(confirm('Are you sure you want to delete this item?')) {

						$.ajax({ 
								type: "GET",
								url: "default.php",
								data: "code={/literal}{$campaignproductData.campaignproduct_code}{literal}&campaignproductitem_code_delete="+id,
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