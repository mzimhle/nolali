<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
		<title>{$domainData.campaign_company} Admin | Invoice | {$invoiceData.campaigninvoice_code}</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/invoices/">Invoices</a> &raquo; 
				<a href="/admin/invoices/details.php?code={$invoiceData.campaigninvoice_code}">{$invoiceData.campaigninvoice_code}</a> &raquo; 
				<a href="#">Items</a>
			</p>		
			<div id="main">
				<div class="clr"></div>
				<p class="linebreak"></p>
				<div class="clr"></div>
				<h3>{$invoiceData.participant_name} {$invoiceData.participant_surname}'s invoice: {$invoiceData.campaigninvoice_code}</h3>
				<div id="tableContent" align="center">				
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="detailsForm" id="detailsForm" action="/admin/invoices/items.php?code={$invoiceData.campaigninvoice_code}" method="post">
						<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<th>Days</th>
							<th>People</th>
							<th>Item</th>
							<th>Description</th>
							<th>Unit Price / Per Day</th>
							<th></th>
							<th></th>
						   </tr>
						  {foreach from=$campaigninvoiceitemData item=item}
						  <tr>	
							<td align="left" class="alt">
									
							</td>						  
							<td align="left" class="alt">
								<select name="campaigninvoiceitem_quantity_{$item.campaigninvoiceitem_code}" id="campaigninvoiceitem_quantity_{$item.campaigninvoiceitem_code}" {if $item.campaigninvoice_paid eq 1}disabled{/if}>
									<option value="1" {if $item.campaigninvoiceitem_quantity eq 1}selected{/if}>1</option>
									<option value="2" {if $item.campaigninvoiceitem_quantity eq 2}selected{/if}>2</option>
									<option value="3" {if $item.campaigninvoiceitem_quantity eq 3}selected{/if}>3</option>
									<option value="4" {if $item.campaigninvoiceitem_quantity eq 4}selected{/if}>4</option>
									<option value="5" {if $item.campaigninvoiceitem_quantity eq 5}selected{/if}>5</option>
									<option value="6" {if $item.campaigninvoiceitem_quantity eq 6}selected{/if}>6</option>
									<option value="7" {if $item.campaigninvoiceitem_quantity eq 7}selected{/if}>7</option>
									<option value="8" {if $item.campaigninvoiceitem_quantity eq 8}selected{/if}>8</option>
									<option value="9" {if $item.campaigninvoiceitem_quantity eq 9}selected{/if}>9</option>
									<option value="10" {if $item.campaigninvoiceitem_quantity eq 10}selected{/if}>10</option>
								</select>
							</td>						  
							<td align="left" class="alt">
								<input type="text"  {if $item.campaigninvoice_paid eq 1}disabled{/if} name="campaigninvoiceitem_name_{$item.campaigninvoiceitem_code}" id="campaigninvoiceitem_name_{$item.campaigninvoiceitem_code}" value="{$item.campaigninvoiceitem_name} " size="15" />
							</td>	
							<td align="left" class="alt">
								<textarea  {if $item.campaigninvoice_paid eq 1}disabled{/if} name="campaigninvoiceitem_description_{$item.campaigninvoiceitem_code}" id="campaigninvoiceitem_description_{$item.campaigninvoiceitem_code}" rows="5" cols="40">{$item.campaigninvoiceitem_description}</textarea>
							</td>
							<td align="left" class="alt">
								<input type="text"  {if $item.campaigninvoice_paid eq 1}disabled{/if} name="campaigninvoiceitem_price_{$item.campaigninvoiceitem_code}" id="campaigninvoiceitem_price_{$item.campaigninvoiceitem_code}" value="{$item.campaigninvoiceitem_price}" size="10" />
							</td>							
							<td align="left" class="alt">
								{if $item.campaigninvoice_paid eq 0}
								<a class="link link_{$item.campaigninvoiceitem_code}" href="javascript:updateForm({$item.campaigninvoiceitem_code});">Update</a>	
								{/if}
							</td>	
							<td align="left" class="alt">
							{if $item.campaigninvoice_paid eq 0}
								<a class="link link_{$item.campaigninvoiceitem_code}" href="javascript:deleteForm({$item.campaigninvoiceitem_code});">Delete</a>	
								{/if}
							</td>							
						  </tr>
						  {foreachelse}
							<tr>
								<td colspan="7">There are no current items in the system.</td>
							</tr>
						  {/foreach}  						  						  							  
						</table>
						</form>
					</div>
					</div>
					{if $invoiceData.campaigninvoice_paid eq 0}
					<h3>Add invoice item</h3>
					<div id="tableContent" align="center">		
					<div class="content_table">		
					<form name="additemForm" id="additemForm" action="/admin/invoices/items.php?code={$invoiceData.campaigninvoice_code}" method="post">					
						<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<th>People</th>
							<th>Product</th>
							<th></th>
						   </tr>						
						  <tr>		
							<td align="left" class="alt">
								<select id="campaigninvoiceitem_quantity" name="campaigninvoiceitem_quantity">
									<option value="1"> 1 </option>
									<option value="2"> 2 </option>
									<option value="3"> 3 </option>
									<option value="4"> 4 </option>
									<option value="5"> 5 </option>
									<option value="6"> 6 </option>
									<option value="7"> 7 </option>
									<option value="8"> 8 </option>
									<option value="9"> 9 </option>
									<option value="10"> 10 </option>
								</select>
							</td>
							<td align="left" class="alt">
								<select id="campaignproduct_code" name="campaignproduct_code">
									<option value=""> ---- </option>
									{html_options options=$campaignproductPairs}
								</select>
							</td>	
							<td colspan="2">
							<a class="link" href="javascript:addItemForm();	">Add Item</a>	
							</td>						
						  </tr>	
						  </table>
						 </form>
					 </div>
					 <!-- End Content Table -->
					<div class="clear"></div>
	  
				</div>
				{/if}
			</div>							
			<div class="clr"></div>
			{include_php file='includes/footer.php'}
			{literal}
				<script type="text/javascript">
				
				function submitForm() {
					document.forms.detailsForm.submit();					 
				}
				
				function addItemForm() {
					document.forms.additemForm.submit();					 
				}
				
				function updateForm(id) {					
					$('.link_'+id).html('<b>Loading...</b>');

						$.ajax({ 
								type: "GET",
								url: "items.php",
								data: "code={/literal}{$invoiceData.campaigninvoice_code}{literal}&campaigninvoiceitem_code_update="+id+"&campaigninvoiceitem_quantity="+$('#campaigninvoiceitem_quantity_'+id).val()+"&campaigninvoiceitem_name="+$('#campaigninvoiceitem_name_'+id).val() + "&campaigninvoiceitem_description="+$('#campaigninvoiceitem_description_'+id).val() + "&campaigninvoiceitem_price="+$('#campaigninvoiceitem_price_'+id).val(),
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
				
				function deleteForm(id) {	
					if(confirm('Are you sure you want to delete this item?')) {
						$('.link_'+id).html('<b>Loading...</b>');

							$.ajax({ 
									type: "GET",
									url: "items.php",
									data: "code={/literal}{$invoiceData.campaigninvoice_code}{literal}&campaigninvoiceitem_code_delete="+id,
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