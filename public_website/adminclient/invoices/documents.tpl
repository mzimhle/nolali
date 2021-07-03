<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
		<title>{$domainData.campaign_company} Admin | Invoice | Documents | {$invoiceData.invoice_code}</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/invoices/">Invoices</a> &raquo; 
				<a href="/admin/invoices/details.php?code={$invoiceData.invoice_code}">{$invoiceData.invoice_code}</a> &raquo; 
				<a href="#">Documents</a>
			</p>			
			<div id="main">
				<div class="clr"></div>
				<p class="linebreak"></p>
				<div class="clr"></div>
				<h3>{$invoiceData.participant_name} {$invoiceData.participant_surname}'s invoice: {$invoiceData.invoice_code} - Documents saved for this invoice.</h3>
				<div id="tableContent" align="center">				
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="detailsForm" id="detailsForm" action="/admin/invoices/documents.php?code={$invoiceData.invoice_code}" method="post">
						<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<th>Added</th>
							<th>Filename / Download</th>
							<th>Description</th>
							<th></th>
						   </tr>
						  {foreach from=$invoicefileData item=item}
						  <tr>							  
							<td align="left" class="alt">
								{$item.invoicefile_added|date_format}
							</td>									
							<td align="left" class="alt">
								<a href="http://{$domainData.campaign_domain}{$item.invoicefile_path}" target="_blank">{$item.invoicefile_userfilename}</a>
							</td>
							<td align="left" class="alt">
								{$item.invoicefile_description}
							</td>							
							<td align="left" class="alt">
								<a class="link link_{$item.invoicefile_code}" href="javascript:deleteForm({$item.invoicefile_code});">Delete</a>	
							</td>							
						  </tr>
						  {foreachelse}
							<tr>
								<td colspan="4">There are no current items in the system.</td>
							</tr>
						  {/foreach}  						  						  							  
						</table>
						</form>
					</div>
					</div>
					<h3>Add a document</h3><span class="selecteditem">Please only upload valid readable files like statement documents for this particular invoice.</span>
					<div id="tableContent" align="center">		
					<div class="content_table">		
					<form name="additemForm" id="additemForm" action="/admin/invoices/documents.php?code={$invoiceData.invoice_code}" method="post"  enctype="multipart/form-data">					
						<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<th {if isset($errorArray.documentfile)}class="error"{/if}>Upload</th>
							<th>Description</th>
							<th></th>
						   </tr>						
						  <tr>		
							<td align="left" class="alt">
								<input type="file" id="documentfile" name="documentfile" />
							</td>
							<td align="left" class="alt">
								<textarea name="invoicefile_description" id="invoicefile_description" rows="2" cols="50"></textarea>
							</td>	
							<td colspan="2">
							<a class="link" href="javascript:addItemForm();">Add file</a>	
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
				
				function deleteForm(id) {	
					if(confirm('Are you sure you want to delete this file?')) {
						$('.link_'+id).html('<b>Loading...</b>');

							$.ajax({ 
									type: "GET",
									url: "documents.php",
									data: "code={/literal}{$invoiceData.invoice_code}{literal}&invoicefile_code_delete="+id,
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