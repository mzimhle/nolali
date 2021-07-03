<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
		<title>{$domainData.campaign_company} Admin | Invoice | Payments | {$invoiceData.invoice_code}</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/invoices/">Invoices</a> &raquo; 
				<a href="/admin/invoices/details.php?code={$invoiceData.invoice_code}">{$invoiceData.invoice_code}</a> &raquo; 
				<a href="#">Payments</a>
			</p>
			<div id="main">
				<div class="clr"></div>
				<p class="linebreak"></p>
				<div class="clr"></div>
				<h3>{$invoiceData.participant_name} {$invoiceData.participant_surname}'s invoice: {$invoiceData.invoice_code} - Payments made on the invoice.</h3>
				
				{if $invoiceData.due_amount lt 0}<span class="success">Invoice Amount has been fully paid. Pending amount: R {$invoiceData.due_amount|number_format:2:".":","}</span>{/if}
				{if $invoiceData.due_amount gt 0}<span class="error">Invoice Amount has not been paid,  amount pending is R {$invoiceData.due_amount|number_format:2:".":","}.</span>{/if}
				
				<div id="tableContent" align="center">				
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="detailsForm" id="detailsForm" action="/admin/invoices/payments.php?code={$invoiceData.invoice_code}" method="post">
						<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<th>Date Paid</th>
							<th>Amount</th>
							<th>Notes</th>
							<th></th>
							<th></th>
						   </tr>
						  {foreach from=$invoicepaymentData item=item}
						  <tr>							  
							<td align="left" class="alt">
								{$item.invoicepayment_added|date_format}
							</td>	
							<td align="left" class="alt">
								<input type="text" name="invoicepayment_amount_{$item.invoicepayment_code}" id="invoicepayment_amount_{$item.invoicepayment_code}" value="{$item.invoicepayment_amount}" size="10" />
							</td>
							<td align="left" class="alt">
								<textarea name="invoicepayment_description_{$item.invoicepayment_code}" id="invoicepayment_description_{$item.invoicepayment_code}" rows="1" cols="50">{$item.invoicepayment_description}</textarea>
							</td>							
							<td align="left" class="alt">
								<a class="link link_{$item.invoicepayment_code}" href="javascript:updateForm({$item.invoicepayment_code});">Update</a>	
							</td>	
							<td align="left" class="alt">
								<a class="link link_{$item.invoicepayment_code}" href="javascript:deleteForm({$item.invoicepayment_code});">Delete</a>	
							</td>							
						  </tr>
						  {foreachelse}
							<tr>
								<td colspan="5">There are no current items in the system.</td>
							</tr>
						  {/foreach}  						  						  							  
						</table>
						</form>
					</div>
					</div>
					<h3>Add a payment</h3>
					<div id="tableContent" align="center">		
					<div class="content_table">		
					<form name="additemForm" id="additemForm" action="/admin/invoices/payments.php?code={$invoiceData.invoice_code}" method="post">					
						<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<th {if isset($errorArray.invoicepayment_amount)}class="error"{/if}>Amount</th>
							<th>Notes</th>
							<th></th>
						   </tr>						
						  <tr>		
							<td align="left" class="alt">
								<input type="text" name="invoicepayment_amount" id="invoicepayment_amount" value="" size="20" />
							</td>
							<td align="left" class="alt">
								<textarea name="invoicepayment_description" id="invoicepayment_description" rows="1" cols="50"></textarea>
							</td>	
							<td colspan="2">
							<a class="link" href="javascript:addItemForm();">Add Item</a>	
							</td>						
						  </tr>	
						  </table>
						 </form>
					 </div>
					 <!-- End Content Table -->
					<div class="clear"></div>
	  
				</div>
			</div>							
			<div class="clr"></div>
			{include_php file='includes/footer.php'}
			{literal}
				<script type="text/javascript">
				
				function addItemForm() {
					document.forms.additemForm.submit();					 
				}
				
				function updateForm(id) {			
					if(confirm('Are you sure you want to update this item?')) {
						$('.link_'+id).html('<b>Loading...</b>');

						$.ajax({ 
								type: "GET",
								url: "payments.php",
								data: "code={/literal}{$invoiceData.invoice_code}{literal}&invoicepayment_code_update="+id+"&invoicepayment_amount="+$('#invoicepayment_amount_'+id).val()+"&invoicepayment_description="+$('#invoicepayment_description_'+id).val(),
								dataType: "json",
								success: function(data){
										if(data.result == 1) {
											alert('Updated');
											window.location.href = window.location.href;
										} else {
											alert(data.error);
										}
								}
						});	
						
						$('.link_'+id).html('Update Item');
					}
				}				
				
				function deleteForm(id) {	
					if(confirm('Are you sure you want to delete this item?')) {
						$('.link_'+id).html('<b>Loading...</b>');

							$.ajax({ 
									type: "GET",
									url: "payments.php",
									data: "code={/literal}{$invoiceData.invoice_code}{literal}&invoicepayment_code_delete="+id,
									dataType: "json",
									success: function(data){
											if(data.result == 1) {
												alert('Deleted');
												window.location.href = window.location.href;
											} else {
												alert(data.error);
											}
									}
							});	
							
							$('.link_'+id).html('Delete Item');
						}
				}					
				</script>
			{/literal}
			</div>
	</body>
</html>