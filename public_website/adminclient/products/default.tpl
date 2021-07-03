<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
		<script type="text/javascript" language="javascript" src="default.js"></script>
		<title>{$domainData.campaign_company}| Admin | Products</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/products/">Products</a>
			</p>
			<p class="linebreak"></p>
			<div id="main">
				<a class="link" href="/admin/products/details.php">Add a New Products</a>
				<div id="tableContent" align="center">
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="htmlForm" id="htmlForm" action="/admin/products/" method="post">
							<table border="0" cellspacing="0" cellpadding="0" id="dataTable">							
								<thead>
								<tr>
									<th>Added</th>
									<th>Product</th>
									<th>Description</th>
									<th>Status</th>
									<th></th>
								</tr>
								</thead>							
							   <tbody>
							  {foreach from=$productData item=item}
							  <tr>
								<td>{$item.product_added|date_format}</td>
								<td align="left"><a href="/admin/products/details.php?code={$item.product_code}">{$item.product_name}</a></td>	
								<td align="left">{$item.product_description}</td>
								<td align="left">{if $item.product_active eq 1}<span class="success">Active</span>{else}<span class="error">Not active</span>{/if}</td>
								<td align="left"><a class="link" href="javascript:deleteForm('{$item.product_code}');">Delete</a>	</td>
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
								data: "product_code_delete="+id,
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