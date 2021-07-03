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
			<li><a href="/products/" title="">Products</a></li>
			<li><a href="/products/package/" title="">Package</a></li>
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
			<li class="active"><a href="#" title="Price">Price</a></li>
			<li><a href="{if isset($packageData)}/products/package/component.php?code={$packageData._package_code}{else}#{/if}" title="Component">Component</a></li>			
		</ul>
		</div><!--tabs-->	
		  <div class="detail_box">  
		  <form name="priceForm" id="priceForm" action="/products/package/price.php?code={$packageData._package_code}" method="post">
			  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="innertable"> 
			  <thead>
			  <tr>				
				<th valign="top">ID</th>
				<th valign="top">Price</th>
				<th valign="top">Type</th>
				<th valign="top">Start Date</th>
				<th valign="top">End Date</th>			
			  </tr>
			  </thead>
			  <tbody>
			  {foreach from=$priceData item=item}
			  <tr>	
				<td valign="top" {if $item._price_active eq '1'}class="success"{else}class="error"{/if}>{$item._price_id}</td>
				<td valign="top" {if $item._price_active eq '1'}class="success"{else}class="error"{/if}>R {$item._price_cost|number_format:0:".":","}</td>				
				<td valign="top" {if $item._price_active eq '1'}class="success"{else}class="error"{/if}>{$item._price_type}</td>	
				<td valign="top" {if $item._price_active eq '1'}class="success"{else}class="error"{/if}>{$item._price_startdate}</td>
				<td valign="top" {if $item._price_active eq '1'}class="success"{else}class="error"{/if}>{$item._price_enddate}</td>
			  </tr>
			  {/foreach}			
			  <tr>
				<td valign="top"></td>			  
				<td valign="top">
					<input type="text" id="_price_cost" name="_price_cost"  size="20" />
					{if isset($errorArray._price_cost)}<br /><em class="error">{$errorArray._price_cost}</em>{/if}
				</td>
				<td valign="top">
					<select id="_price_type" name="_price_type">
						<option value=""> -------- </option>
						<option value="INITIAL"> Initial Cost </option>
						<option value="MONTHLY"> Monthly Cost </option>
					</select>
					{if isset($errorArray._price_type)}<br /><em class="error">{$errorArray._price_type}</em>{/if}
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
