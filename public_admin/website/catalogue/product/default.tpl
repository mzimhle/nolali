<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nolali - The Creative</title>
{include_php file='includes/css.php'}
{include_php file='includes/javascript.php'}
<script type="text/javascript" language="javascript" src="default.js"></script>
</head>

<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content Section -->
  <div id="content">
    {include_php file='includes/header.php'}
	<div id="breadcrumb">
        <ul>
            <li><a href="/" title="Home">Home</a></li>
			<li><a href="/website/" title="Website">Website</a></li>
			<li><a href="#" title="Website"><span class="success">{$domainData.campaign_name}</span></a></li>
			<li><a href="/website/catalogue/" title="">Catalogue</a></li>
			<li><a href="/website/catalogue/product/" title="">Products</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage <span class="success">{$domainData.campaign_name}</span> products</h2>		
	<a href="/website/catalogue/product/details.php" title="Click to Add a new product" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new product</span></a> <br />
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">			
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
			  <tr>
				<th></th>
				<th>Campaign</th>
				<th>Name</th>
				<th></th>
			   </tr>
			   </thead>
			   <tbody>
			  {foreach from=$productData item=item}
			  <tr>
				<td>
					{if $item.productimage_path neq ''}
						<img src="http://{$item.campaign_domain}/{$item.productimage_path}/tny_{$item.productimage_code}{$item.productimage_extension}"  width="70" />
					{else}
						<img src="/images/no-image.jpg" width="70" />
					{/if}
				</td>
				<td align="left">{$item.campaign_name}</td>
				<td align="left"><a href="/website/catalogue/product/details.php?code={$item.product_code}">{$item.product_name}</a></td>	
				<td align="left"><button onclick="deleteitem('{$item.product_code}'); return false;">Delete</button></td>				
			  </tr>
			  {/foreach}     
			  </tbody>
			</table>
		 </div>
		 <!-- End Content Table -->	
	</div>
    <div class="clearer"><!-- --></div>
    </div><!--inner-->
  </div><!-- End Content Section -->
 {include_php file='includes/footer.php'}
</div>
<!-- End Main Container -->
{literal}
<script type="text/javascript" language="javascript">
function deleteitem(code) {
	if(confirm('Are you sure you want to delete this item?')) {
		$.ajax({ 
				type: "GET",
				url: "default.php",
				data: "delete_code="+code,
				dataType: "json",
				success: function(data){
						if(data.result == 1) {
							alert('Item deleted!');
							window.location.href = window.location.href;
						} else {
							alert(data.error);
						}
				}
		});							
	}
	return false;
}
</script>
{/literal}
</body>
</html>
