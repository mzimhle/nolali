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
			<li><a href="/products/" title="Products">Products</a></li>
			<li>
				<a href="/products/package/" title="{$packageData._package_name}">Package</a>
			</li>			
			<li>
				<a href="/products/package/details.php?code={$packageData._package_code}" title="{$packageData._package_name}">{$packageData._package_name}</a>
			</li>
			<li>Price</li>
        </ul>
	</div><!--breadcrumb-->
	<div class="inner">
		<div class="clearer"><!-- --></div>
		<br /><h2>Manage Price</h2><br />
		<div id="sidetabs">
		<ul> 
            <li><a href="/products/package/details.php?code={$packageData._package_code}" title="Details">Details</a></li>
			<li><a href="/products/package/price.php?code={$packageData._package_code}" title="Price">Price</a></li>
			<li class="active"><a href="#" title="Component">Component</a></li>
		</ul>
		</div><!--tabs-->	
		  <div class="detail_box">  
		  <form name="componentForm" id="componentForm" action="/products/package/component.php?code={$packageData._package_code}" method="post">
			  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="innertable"> 
			  <thead>
			  <tr>				
				<th valign="top">Product</th>
				<th valign="top">Description</th>
				<th valign="top"></th>			
			  </tr>
			  </thead>
			  <tbody>
			  {foreach from=$componentData item=item}
			  <tr>	
				<td valign="top">{$item._product_type} : {$item._product_name} ({$item._product_quantity})</td>
				<td valign="top">{$item._product_description}</td>	
				<td valign="top"><button onclick="deleteitem('{$item._component_code}');">Delete</button></td>
			  </tr>
			  {/foreach}			
			  <tr>
				<td valign="top">
					<select id="_product_code" name="_product_code">
						<option value=""> -------- </option>
						{html_options options=$productPairs}
					</select>
					{if isset($errorArray._product_code)}<br /><em class="error">{$errorArray._product_code}</em>{/if}
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
</script>
{/literal}	
<!-- End Main Container -->
</body>
</html>
