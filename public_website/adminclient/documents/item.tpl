<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
		<title>{$domainData.campaign_company} Admin |  Documents | {$campaigndocumentData.campaigndocument_name}</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/resources/">Resources</a> &raquo; 
				<a href="/admin/documents/">Documents Groups</a>&raquo; 
				<a href="/admin/documents/details.php?code={$campaigndocumentData.campaigndocument_code}">{$campaigndocumentData.campaigndocument_name}</a> &raquo; 
				<a href="#">Documents</a>
			</p>			
			<div id="main">
				<div class="clr"></div>
				<p class="linebreak"></p>
				<div class="clr"></div>
				<h3>{$campaigndocumentData.campaigndocument_name} Documents</h3>
				<div id="tableContent" align="center">				
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="detailsForm" id="detailsForm" action="/admin/documents/item.php?code={$campaigndocumentData.campaigndocument_code}" method="post">
						<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<th>Added</th>
							<th>Filename</th>
							<th>Document</th>
							<th>Description</th>
							<th></th>
							<th></th>
						   </tr>
						  {foreach from=$campaigndocumentitemData item=item}
						  <tr>							  
							<td align="left" class="alt">
								{$item.campaigndocumentitem_added|date_format}
							</td>													
							<td align="left" class="alt">
								<input type="text" name="campaigndocumentitem_name_{$item.campaigndocumentitem_code}" id="campaigndocumentitem_name_{$item.campaigndocumentitem_code}" value="{$item.campaigndocumentitem_name}" />
							</td>
							<td align="left" class="alt">
								<a href="http://{$domainData.campaign_domain}{$item.campaigndocumentitem_path}">{$item.campaigndocumentitem_filename}</a>
							</td>								
							<td align="left" class="alt">
								<textarea name="campaigndocumentitem_description_{$item.campaigndocumentitem_code}" id="campaigndocumentitem_description_{$item.campaigndocumentitem_code}" cols="20" rows="3">{$item.campaigndocumentitem_description}</textarea>
							</td>		
							<td align="left" class="alt">
								<a class="link link_{$item.campaigndocumentitem_code}" href="javascript:updateForm('{$item.campaigndocumentitem_code}');">Update</a>	
							</td>							
							<td align="left" class="alt">
								<a class="link link_{$item.campaigndocumentitem_code}" href="javascript:deleteForm('{$item.campaigndocumentitem_code}');">Delete</a>	
							</td>							
						  </tr>
						  {foreachelse}
							<tr>
								<td colspan="8">There are no current items in the system.</td>
							</tr>
						  {/foreach}  						  						  							  
						</table>
						</form>
					</div>
					</div>
					<h3>Add a document item</h3><span class="selecteditem">Please only add pdf, xls, txt, docx, doc and cvs files</span>
					<div id="tableContent" align="center">		
					<div class="content_table">		
					<form name="additemForm" id="additemForm" action="/admin/documents/item.php?code={$campaigndocumentData.campaigndocument_code}" method="post"  enctype="multipart/form-data">					
						<table id="grid_table" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<th {if isset($errorArray.itemfile)}class="error"{/if}>Upload</th>
							<th {if isset($errorArray.campaigndocumentitem_name)}class="error"{/if}>Name</th>
							<th {if isset($errorArray.campaigndocumentitem_description)}class="error"{/if}>Description</th>
							<th></th>
						   </tr>						
						  <tr>		
							<td align="left" class="alt">
								<input type="file" id="itemfile" name="itemfile" />
							</td>
							<td align="left" class="alt">
								<input type="text" name="campaigndocumentitem_name" id="campaigndocumentitem_name" size="20" />
							</td>							
							<td align="left" class="alt">
								<textarea name="campaigndocumentitem_description" id="campaigndocumentitem_description" rows="2" cols="25"></textarea>
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
					
					function updateForm(id) {
						if(confirm('Are you sure you want to update this file ?')) {

							$.ajax({ 
									type: "GET",
									url: "item.php",
									data: "code={/literal}{$campaigndocumentData.campaigndocument_code}{literal}&campaigndocumentitem_code_update="+id+"&campaigndocumentitem_name="+$('#campaigndocumentitem_name_'+id).val()+ "&campaigndocumentitem_description="+$('#campaigndocumentitem_description_'+id).val() + "&campaigndocumentitem_active="+$('#campaigndocumentitem_active_'+id).val(),
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
						}
					}	
					
					function deleteForm(id) {	
						if(confirm('Are you sure you want to delete this file?')) {

								$.ajax({ 
										type: "GET",
										url: "item.php",
										data: "code={/literal}{$campaigndocumentData.campaigndocument_code}{literal}&campaigndocumentitem_code_delete="+id,
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
							}
					}					
				</script>
			{/literal}
			</div>
	</body>
</html>