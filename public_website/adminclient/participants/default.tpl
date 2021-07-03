<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
		<script type="text/javascript" language="javascript" src="default.js"></script>
		<title>Participants | {$domainData.campaign_company}</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/participants/">Participants</a>
			</p>
			<p class="linebreak"></p>
			<div id="main">
				<a class="link" href="/admin/participants/details.php">Add a New Participants</a>
				<div id="tableContent" align="center">
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="htmlForm" id="htmlForm" action="/admin/participants/" method="post">
							<table border="0" cellspacing="0" cellpadding="0" id="dataTable">							
								<thead>
								<tr>
									<th>Added</th>
									<th>Full Name</th>
									<th>Email</th>
									<th>Cell</th>
									<th></th>
								</tr>
								</thead>							
							   <tbody>
							  {foreach from=$participantData item=item}
							  <tr>
								<td align="left">{$item.participant_added|date_format}</td>
								<td align="left">
									<a href="/admin/participants/details.php?code={$item.participant_code}">{$item.participant_name} {$item.participant_surname}</a>
								</td>	
								<td align="left">{$item.participant_email}</td>
								<td align="left">{$item.participant_cellphone}</td>
								<td align="left"><button onclick="deleteItem({$item.participant_code}); return false;">Delete</button></td>
							  </tr>
							  {/foreach}     
							  </tbody>
							</table>
						 </form>
					 </div>
					 <!-- End Content Table -->
					<div class="clear"></div>				
				</div>
			</div>							
			<div class="clr"></div>
			{include_php file='includes/footer.php'}
			</div>
			{literal}
			<script type="text/javascript">
			function deleteItem(code) {	
				if(confirm('Are you sure you want to delete this person?')) {

						$.ajax({ 
								type: "GET",
								url: "default.php",
								data: "participant_code_delete="+code,
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
	</body>
</html>