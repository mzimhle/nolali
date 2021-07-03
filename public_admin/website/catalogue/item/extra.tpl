<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nolali - The Creative</title>
{include_php file='includes/css.php'}
{include_php file='includes/javascript.php'}
</head>
<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content recruiter -->
  <div id="content">
    {include_php file='includes/header.php'}
  	<br />
	<div id="breadcrumb">
        <ul>
            <li><a href="/" title="Home">Home</a></li>
			<li><a href="/website/" title="Website">Website</a></li>
			<li><a href="#" title="Website"><span class="success">{$domainData.campaign_name}</span></a></li>
			<li><a href="/website/catalogue/" title="">Catalogue</a></li>
			<li><a href="/website/catalogue/item/" title="">Items</a></li>
			<li>{$productitemData.productitem_name}</li>
			<li>Data / Extras</li>
        </ul>
	</div><!--breadcrumb-->
	<div class="inner">
		<div class="clearer"><!-- --></div>
		<br /><h2>Manage Price</h2><br />
		<div id="sidetabs">
		<ul> 
            <li><a href="/website/catalogue/item/details.php?code={$productitemData.productitem_code}" title="Details">Details</a></li>
			<li><a href="/website/catalogue/item/price.php?code={$productitemData.productitem_code}" title="Price">Price</a></li>
			<li><a href="/website/catalogue/item/image.php?code={$productitemData.productitem_code}" title="Image">Image</a></li>			
			<li class="active"><a href="#" title="Extras">Extras</a></li>			
		</ul>
		</div><!--tabs-->	
		  <div class="detail_box">  
		  <form name="productitemdataForm" id="productitemdataForm" action="/website/catalogue/item/extra.php?code={$productitemData.productitem_code}" method="post">
			  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="innertable"> 
			  <thead>
			  <tr>				
				<th valign="top">Type</th>
				<th valign="top">Name</th>
				<th valign="top">Description</th>
				<th valign="top"></th>			
			  </tr>
			  </thead>
			  <tbody>
			  {foreach from=$productitemdataData item=item}
			  <tr>	
				<td valign="top">{$item.productitemdata_type}</td>
				<td valign="top">{$item.productitemdata_name}</td>
				<td valign="top">{$item.productitemdata_description}</td>
				<td valign="top"><button onclick="deleteitem('{$item.productitemdata_code}'); return false;">Delete</button></td>
			  </tr>
			  {/foreach}			
			  <tr>	  
				<td valign="top">
					<select id="productitemdata_type" name="productitemdata_type">
						<option value=""> --------------- </option>
						<option value="FEATURES"> FEATURES </option>
						<option value="SERVICES"> SERVICES </option>
						<option value="EXTRAS"> EXTRAS </option>
					</select>
					{if isset($errorArray.productitemdata_type)}<br /><em class="error">{$errorArray.productitemdata_type}</em>{/if}
				</td>				  
				<td valign="top">
					<input type="text" id="productitemdata_name" name="productitemdata_name"  size="40" />
					{if isset($errorArray.productitemdata_name)}<br /><em class="error">{$errorArray.productitemdata_name}</em>{/if}
				</td>				  
				<td valign="top">
					<textarea id="productitemdata_description" name="productitemdata_description" cols="60"></textarea>
					{if isset($errorArray.productitemdata_description)}<br /><em class="error">{$errorArray.productitemdata_description}</em>{/if}
				</td>	
				<td valign="top" colspan="2">
					<button type="submit" onclick="submitForm();">Add</button>	
				</td>			
			  </tr>
			  </tbody>
			</table>
			{if isset($errorArray.error)}<span class="error">{$errorArray.error}</span>{/if}
			</form>
		</div>		
	<div class="clearer"><!-- --></div>
    </div><!--inner-->
 </div> 	
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 {include_php file='includes/footer.php'}
</div>
{literal}
<script type="text/javascript">
function submitForm() {
	document.forms.imageForm.submit();					 
}

function deleteitem(code) {
	if(confirm('Are you sure you want to delete this item?')) {
		$.ajax({ 
				type: "GET",
				url: "extra.php?code={/literal}{$productitemData.productitem_code}{literal}",
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
<!-- End Main Container -->
</body>
</html>
