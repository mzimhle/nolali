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
			<li><a href="/website/invoice/" title="">Invoice</a></li>
			<li>REF#{$invoiceData.invoice_code}</li>
			<li>Items</li>
        </ul>
	</div><!--breadcrumb-->
	<div class="inner">
		<div class="clearer"><!-- --></div>
		<br /><h2>Manage <span class="success">{$domainData.campaign_name}</span> Items</h2><br />
		<div id="sidetabs">
		<ul> 
            <li><a href="/website/invoice/details.php?code={$invoiceData.invoice_code}" title="Details">Details</a></li>
			<li class="active"><a href="#" title="Items">Items</a></li>
			<li><a href="/website/invoice/payment.php?code={$invoiceData.invoice_code}" title="Payment">Payment</a></li>			
		</ul>
		</div><!--tabs-->	
		  <div class="detail_box">  
		  <form name="invoiceitemForm" id="invoiceitemForm" action="/website/invoice/item.php?code={$invoiceData.invoice_code}" method="post">
			  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="innertable"> 
			  <thead>
			  <tr>				
				<th valign="top">Name</th>
				<th valign="top">Description</th>
				<th valign="top">Quantity</th>
				<th valign="top">Amount</th>
				<th valign="top"></th>			
			  </tr>
			  </thead>
			  <tbody>
			  {foreach from=$invoiceitemData item=item}
			  <tr>	
				<td valign="top">{$item.invoiceitem_name}</td>
				<td valign="top">{$item.invoiceitem_description}</td>
				<td valign="top">{$item.invoiceitem_quantity}</td>
				<td valign="top">{$item.invoiceitem_amount}</td>
				<td valign="top"><button onclick="deleteitem('{$item.invoiceitem_code}'); return false;">Delete</button></td>
			  </tr>
			  {/foreach}			
			  <tr>	  
				<td valign="top">
					<input type="text" id="invoiceitem_name" name="invoiceitem_name"  size="30" />
					{if isset($errorArray.invoiceitem_name)}<br /><em class="error">{$errorArray.invoiceitem_name}</em>{/if}
				</td>				  			  
				<td valign="top">
					<textarea id="invoiceitem_description" name="invoiceitem_description" cols="50"></textarea>
					{if isset($errorArray.invoiceitem_description)}<br /><em class="error">{$errorArray.invoiceitem_description}</em>{/if}
				</td>
				<td valign="top">
					<input type="text" id="invoiceitem_quantity" name="invoiceitem_quantity"  size="5" />
					{if isset($errorArray.invoiceitem_quantity)}<br /><em class="error">{$errorArray.invoiceitem_quantity}</em>{/if}
				</td>
				<td valign="top">
					<input type="text" id="invoiceitem_amount" name="invoiceitem_amount"  size="10" />
					{if isset($errorArray.invoiceitem_amount)}<br /><em class="error">{$errorArray.invoiceitem_amount}</em>{/if}
				</td>					
				<td valign="top">
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
				url: "item.php?code={/literal}{$invoiceData.invoice_code}{literal}",
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
