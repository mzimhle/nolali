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
			<li><a href="/website/booking/" title="">Booking</a></li>
			<li><a href="/website/booking/" title="">View</a></li>
			<li>{$bookingData.booking_person_name}</li>
			<li>Item</li>
        </ul>
	</div><!--breadcrumb-->
	<div class="inner">
		<div class="clearer"><!-- --></div>
		<br /><h2>Manage Price</h2><br />
		<div id="sidetabs">
		<ul> 
            <li><a href="/website/booking/details.php?code={$bookingData.booking_code}" title="Details">Details</a></li>
			<li class="active"><a href="#" title="Item">Item</a></li>
		</ul>
		</div><!--tabs-->	
		  <div class="detail_box">  
		  <form name="priceitemForm" id="priceitemForm" action="/website/booking/item.php?code={$bookingData.booking_code}" method="post">
			  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="innertable"> 
			  <thead>
			  <tr>				
				<th valign="top">Product Booked</th>
				<th valign="top">Price</th>
				<th valign="top">Quantity</th>
				<th valign="top"></th>			
			  </tr>
			  </thead>
			  <tbody>
			  {foreach from=$priceitemData item=item}
			  <tr>	
				<td valign="top">{$item.productitem_name}</td>
				<td valign="top">R {$item._price_cost|number_format:0:".":","}</td>
				<td valign="top">{$item._priceitem_quantity}</td>
				<td valign="top"><button onclick="deleteitem('{$item._priceitem_code}')">delete</button></td>
			  </tr>
			  {/foreach}			
			  <tr>	  
				<td valign="top" colspan="2">
					<select id="_price_code" name="_price_code">
						{html_options options=$pricePairs}
					</select>
					{if isset($errorArray._price_code)}<br /><em class="error">{$errorArray._price_code}</em>{/if}
				</td>	
				<td>
					<input type="text" size="10" id="_priceitem_quantity" name="_priceitem_quantity" />
					{if isset($errorArray._priceitem_quantity)}<br /><em class="error">{$errorArray._priceitem_quantity}</em>{/if}				
				</td>
				<td valign="top">
					<button type="submit" onclick="submitForm();">Add</button>	
				</td>			
			  </tr>
			  </tbody>
			</table>
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
