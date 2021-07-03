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
			<li><a href="/website/invoice/" title="">Invoice</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage <span class="success">{$domainData.campaign_name}</span> Invoice</h2>		
	<a href="/website/invoice/details.php" title="Click to Add a new Invoice" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new Invoice</span></a> <br />
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">			
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
				<tr>
					<th>Added</th>
					<th>Reference</th>
					<th>Person Name</th>
					<th>Person Contact</th>
					<th>Total Item Amount</th>
					<th>Paid Amount</th>				
					<th>Remainder</th>				
					<th>Type</th>
					<th></th>			
				</tr>
			   </thead>
			   <tbody>
			  {foreach from=$invoiceData item=item}
			  <tr>
				<td>{$item.invoice_added|date_format}</td>
				<td align="left"><a href="/website/invoice/details.php?code={$item.invoice_code}">REF#{$item.invoice_code}</a></td>
				<td align="left">{$item.invoice_person_name}</td>
				<td align="left">{$item.invoice_person_number|default:'N/A'} / {$item.invoice_person_email|default:'N/A'}</td>				
				<td align="left">R {$item.item_total|number_format:0:".":","}</td>				
				<td align="left">R {$item.payment_total|number_format:0:".":","}</td>
				<td align="left">R {$item.payment_remainder|number_format:0:".":","}</td>
				<td align="left">
					{if $item.invoice_pdf neq ''}
						<a href="http://{$item.campaign_domain}{$item.invoice_pdf}" target="_blank">{$item.invoice_make}</a>
					{else}
						{$item.invoice_make}
					{/if}
				</td>				
				<td align="left"><button onclick="deleteitem('{$item.invoice_code}'); return false;">Delete</button></td>
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
