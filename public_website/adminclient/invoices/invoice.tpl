<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
		<title>{$domainData.campaign_company} Admin | Invoice | Create and Download PDF invoice</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/invoices/">Invoices</a> &raquo; 
				<a href="/admin/invoices/details.php?code={$invoiceData.invoice_code}">{$invoiceData.invoice_code}</a> &raquo; 
				<a href="#">Finalize and create invoice pdf to download</a>
			</p>			
			<div id="main">
				<div class="clr"></div>
				<p class="linebreak"></p>
				<div class="clr"></div>
				<h3>{$invoiceData.participant_name} {$invoiceData.participant_surname}'s invoice: {$invoiceData.invoice_code}</h3>
				{if $invoicePayments.items eq 0}
				<span class="error">You will only be able to create, download and send the invoice</span>
				{else}
				<span class="success">Below you can view the invoice online statement as well as create pdf and download it.</span>
				{/if}
				<div id="tableContent" align="center">				
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="detailsForm" id="detailsForm" action="/admin/invoices/invoice.php?code={$invoiceData.invoice_code}" method="post">
						<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
							<td align="left" class="alt" colspan="4">
								<span class="blackheading">Invoice Items</span>
							</td>						
						  <tr>
							<th>Quantity</th>
							<th>Item</th>
							<th>Description</th>
							<th class="textalignright">Unit Price</th>
						   </tr>
						  {foreach from=$invoiceitemsData item=item}
						  <tr>	
							<td align="left" class="alt">
								{$item.invoiceitem_quantity}
							</td>							  
							<td align="left" class="alt">
								{$item.invoiceitem_name}
							</td>	
							<td align="left" class="alt">
								{$item.invoiceitem_description}
							</td>
							<td align="left" class="alt textalignright error">
								R {$item.invoiceitem_price|number_format:2:".":","}
							</td>													
						  </tr>
						  {foreachelse}
							<tr>
								<td colspan="5">There are no current items in the system.</td>
							</tr>
						  {/foreach}  
							<td align="left" class="alt" colspan="4">
								<span class="blackheading">Invoice payments made</span>
							</td>
						  <tr>
							<th>Date Paid</th>
							<th>Description</th>
							<th colspan="2" class="textalignright">Amount</th>
						   </tr>
						  {foreach from=$invoicepaymentsData item=item}
						  <tr>	
							<td align="left" class="alt">
								{$item.invoicepayment_added|date_format}
							</td>							  
							<td align="left" class="alt">
								{$item.invoicepayment_description}
							</td>	
							<td align="left" class="alt textalignright success" colspan="2">
								 R - {$item.invoicepayment_amount|number_format:2:".":","}
							</td>													
						  </tr>
						  {foreachelse}
							<tr>
								<td colspan="4">There are no current items in the system.</td>
							</tr>
						  {/foreach} 
						  <tr>
							<th colspan="4"></th>
						   </tr>						  
							<tr>
								<td align="left" class="alt textalignright error" colspan="2">Item Total</td>
								<td align="left" class="alt textalignright error" colspan="2">R {$invoicePayments.items|number_format:2:".":","}</td>							
							</tr>
							<tr>
								<td align="left" class="alt textalignright error" colspan="2">Vat Total</td>
								<td align="left" class="alt textalignright error" colspan="2">R {$invoicePayments.vat|number_format:2:".":","}</td>							
							</tr>							
							<tr>
								<td align="left" class="alt textalignright success" colspan="2">Payments Total</td>
								<td align="left" class="alt textalignright success" colspan="2">R {$invoicePayments.payments|number_format:2:".":","}</td>							
							</tr>
							<tr>
								<td align="left" class="alt textalignright {if $invoicePayments.due lt 0}error{else}success{/if}" colspan="2">Final Total</td>
								<td align="left" class="alt textalignright {if $invoicePayments.due lt 0}error{else}success{/if}" colspan="2">R {$invoicePayments.due|number_format:2:".":","}</td>							
							</tr>
							<tr>
								<td align="left" class="alt" colspan="4"><b>{if $invoicePayments.due lt 0}You owe {$invoiceData.participant_name} {$invoiceData.participant_surname} R {$invoicePayments.due|number_format:2:".":","}{else}{$invoiceData.participant_name} {$invoiceData.participant_surname} needs to pay R {$invoicePayments.due|number_format:2:".":","}{/if}</b></td>							
							</tr>
						  <tr>
							<th colspan="4">Would you like to mark this invoice as paid ? </th>
						   </tr>
							<tr>
								<td align="left" class="alt" colspan="4">
									<span class="error">Check this button to mark as paid :</span> <input type="checkbox" name="invoice_paid" id="invoice_paid" {if $invoiceData.invoice_paid eq 1}checked{/if} value="1"  />
								</td>							
							</tr>						   
						</table>
						<br /><br />
							{if $invoiceData.total_amount neq 0}
								<input type="hidden" id="invoicecreate" name="invoicecreate" value="1" />
								<a class="link" href="javascript:submitForm();">Create and Download PDF</a>
							{else}
								<span class="error">You need to add invoice items before you can create a downloadable PDF.</span>
							{/if}
						</form>
					</div>
					</div>
			</div>							
			<div class="clr"></div>
			{include_php file='includes/footer.php'}
			{literal}
				<script type="text/javascript">
				
				function submitForm() {
					document.forms.detailsForm.submit();					 
				}			
				</script>
			{/literal}
			</div>
	</body>
</html>