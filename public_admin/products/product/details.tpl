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
			<li><a href="/products/product/" title="">Product</a></li>
			<li>{if isset($productData)}Edit a product{else}Add a product{/if}</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{if isset($productData)}{$productData._product_name}{else}Add a new product{/if}</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
        </ul>
    </div><!--tabs-->

	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/products/product/details.php{if isset($productData)}?code={$productData._product_code}{/if}" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
				<tr>
					<td class="heading" colspan="3">Product Type</td>
				</tr>
				<tr>
					<td colspan="3">
					{if !isset($productData)}
						<select id="_product_type" name="_product_type">
							<option value=""> -------- </option>
							<option value="SERVICE"> Service </option>
							<option value="PAGE"> Page</option>
						</select>
						{if isset($errorArray._product_type)}<br /><span class="error">{$errorArray._product_type}</span>{/if}						
					{else}
					<h3 class="success">{$productData._product_type}</h3>
					<input type="hidden" id="_product_type" name="_product_type" value="{$productData._product_type}" />
					{/if}
					</td>					
				</tr>
				<tr>
					<td class="left_col error" valign="top"><h4>Name:</h4><br />
						<input type="text" name="_product_name" id="_product_name" value="{$productData._product_name}" size="30"/>
						{if isset($errorArray._product_name)}<br /><span class="error">{$errorArray._product_name}</span>{/if}
					</td>
					<td class="left_col" colspan="2">
						<h4 class="error">Description:</h4><br />
						<textarea type="text" name="_product_description" id="_product_description" rows="3" cols="100">{$productData._product_description}</textarea>
						{if isset($errorArray._product_description)}<br /><span class="error">{$errorArray._product_description}</span>{/if}
					</td>						
				</tr> 		  
				<tr class="service" {if $productData._product_type eq 'PAGE'}style="display: none;"{/if}>
					<td class="left_col error" colspan="3"><h4>Quantity:</h4><br />
						<input type="text" name="_product_service_quantity" id="_product_service_quantity" value="{$productData._product_service_quantity}" size="30"/>
						{if isset($errorArray._product_service_quantity)}<br /><span class="error">{$errorArray._product_service_quantity}</span>{/if}
					</td>
				</tr>
				<tr class="page" {if $productData._product_type eq 'SERVICE'}style="display: none;"{/if}>
					<td class="left_col error" colspan="3"><h4>Page Url:</h4><br />
						<input type="text" name="_product_page_link" id="_product_page_link" value="{$productData._product_page_link}" size="60"/>
						{if isset($errorArray._product_page_link)}<br /><span class="error">{$errorArray._product_page_link}</span>{/if}
					</td>
				</tr>				
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="/products/product/" class="button cancel mrg_left_147 fl"><span>Cancel</span></a>
          <a href="javascript:submitForm();" class="blue_button mrg_left_20 fl"><span>Save &amp; Complete</span></a>   
        </div>
    <div class="clearer"><!-- --></div>
    </div><!--inner-->
 </div> 	
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 {include_php file='includes/footer.php'}
</div>
{literal}
<script type="text/javascript" language="javascript">
function submitForm() {
	document.forms.detailsForm.submit();					 
}
</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
