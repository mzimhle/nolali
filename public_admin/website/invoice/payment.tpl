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
			<li><a href="/website/invoice/payment.php?code={$invoiceData.invoice_code}" title="Items">Items</a></li>
			<li class="active"><a href="#" title="Payment">Payment</a></li>			
		</ul>
		</div><!--tabs-->	
		  <div class="detail_box">  
		  <form name="invoicepaymentForm" id="invoicepaymentForm" action="/website/invoice/payment.php?code={$invoiceData.invoice_code}" method="post" enctype="multipart/form-data">
			  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="innertable"> 
			  <thead>
			  <tr>				
				<th valign="top">Amount</th>
				<th valign="top">Date of Payment</th>
				<th valign="top">Proof of Payment</th>
				<th valign="top"></th>			
			  </tr>
			  </thead>
			  <tbody>
			  {foreach from=$invoicepaymentData item=item}
			  <tr>	
				<td valign="top">{$item.invoicepayment_amount}</td>
				<td valign="top">{$item.invoicepayment_paid_date}</td>
				<td valign="top">{if $item.invoicepayment_file eq ''}N / A{else}<a href="http://{$item.campaign_domain}{$item.invoicepayment_file}" target="_blank">Download</a>{/if}</td>
				<td valign="top"><button onclick="deleteitem('{$item.invoicepayment_code}'); return false;">Delete</button></td>
			  </tr>
			  {/foreach}			
			  <tr>	  
				<td valign="top">
					<input type="text" id="invoicepayment_amount" name="invoicepayment_amount"  size="10" />
					{if isset($errorArray.invoicepayment_amount)}<br /><em class="error">{$errorArray.invoicepayment_amount}</em>{/if}
				</td>				  			  
				<td valign="top">
					<input type="text" id="invoicepayment_paid_date" name="invoicepayment_paid_date"  size="10" />
					{if isset($errorArray.invoicepayment_paid_date)}<br /><em class="error">{$errorArray.invoicepayment_paid_date}</em>{/if}
				</td>	
				<td valign="top">
					<input type="file" id="paymentfile" name="paymentfile" /><br />
					{if isset($errorArray.paymentfile)}<em class="error">{$errorArray.paymentfile}</em>{else}<em>Only upload, txt, pdf, doc, docx and zip files</em>{/if}
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
$( document ).ready(function() {
	$( "#invoicepayment_paid_date" ).datepicker({
	  defaultDate: "+1w",
	  dateFormat: 'yy-mm-dd',
	  changeMonth: true,
	  changeYear: true
	});
});

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
