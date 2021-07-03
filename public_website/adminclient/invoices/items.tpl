<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
		<title>{$domainData.campaign_company} Admin | Invoice | {$invoiceData.invoice_code}</title>
		{literal}
		<style type="text/css">
			.col {
				width: auto;
			}
		</style>
		{/literal}
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/invoices/">Invoices</a> &raquo; 
				<a href="/admin/invoices/details.php?code={$invoiceData.invoice_code}">{$invoiceData.invoice_code}</a> &raquo; 
				<a href="#">Item</a>
			</p>		
			<div id="main">
				<div class="clr"></div>
				<p class="linebreak"></p>
				<div class="clr"></div>
				<h3>{$invoiceData.participant_name} {$invoiceData.participant_surname}'s invoice: {$invoiceData.invoice_code} - Would you like to change anything in this invoice? you can edit the item below.</h3>
				<div id="tableContent" align="center">				
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="detailsForm" id="detailsForm" action="/admin/invoices/items.php?code={$invoiceData.invoice_code}" method="post">
						<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<th>Item</th>
							<th>Description</th>
							<th>Price</th>
							<th>Quantity</th>
							<th></th>
						   </tr>
						  {foreach from=$invoiceitemData item=item}
						  <tr>						  					  
							<td align="left" class="alt">
								<input type="text"  {if $item.invoice_paid eq 1}disabled{/if} name="invoiceitem_name_{$item.invoiceitem_code}" id="invoiceitem_name_{$item.invoiceitem_code}" value="{$item.invoiceitem_name} " size="25" />
							</td>	
							<td align="left" class="alt">
								<textarea  {if $item.invoice_paid eq 1}disabled{/if} name="invoiceitem_description_{$item.invoiceitem_code}" id="invoiceitem_description_{$item.invoiceitem_code}" rows="2" cols="20">{$item.invoiceitem_description}</textarea>
							</td>
							<td align="left" class="alt">
								<input type="text"  {if $item.invoice_paid eq 1}disabled{/if} name="invoiceitem_price_{$item.invoiceitem_code}" id="invoiceitem_price_{$item.invoiceitem_code}" value="{$item.invoiceitem_price}" size="10" />
							</td>
							<td align="left" class="alt">
								<input type="text"  {if $item.invoice_paid eq 1}disabled{/if} name="invoiceitem_quantity_{$item.invoiceitem_code}" id="invoiceitem_quantity_{$item.invoiceitem_code}" value="{$item.invoiceitem_quantity}" size="5" />
							</td>							
							<td align="left" class="alt">
								<a class="link link_{$item.invoiceitem_code}" href="javascript:updateForm({$item.invoiceitem_code});">Update</a>	
							</td>						
						  </tr>
						  {foreachelse}
							<tr>
								<td colspan="6">There are no current items in the system.</td>
							</tr>
						  {/foreach}  						  						  							  
						</table>
						</form>
					</div>
					</div>				
					<div class="clear"></div>			
			<div class="clr"></div>
			{include_php file='includes/footer.php'}
			{literal}
				<script type="text/javascript">
				function updateForm(id) {	
					if(confirm('Are you sure you want to update this item?')) {
						$.ajax({
								type: "GET",
								url: "items.php",
								data: "code={/literal}{$invoiceData.invoice_code}{literal}&invoiceitem_code_update="+id+"&invoiceitem_quantity="+$('#invoiceitem_quantity_'+id).val()+"&invoiceitem_name="+$('#invoiceitem_name_'+id).val() + "&invoiceitem_description="+$('#invoiceitem_description_'+id).val() + "&invoiceitem_price="+$('#invoiceitem_price_'+id).val(),
								dataType: "json",
								success: function(data){
										if(data.result == 1) {
											alert('Updated');
											window.location.href = '/admin/invoices/items.php?code={/literal}{$invoiceData.invoice_code}{literal}';
										} else {
											alert(data.error);
										}
								}
						});	
					}
				}
				</script>
			{/literal}
			</div>
	</body>
</html>