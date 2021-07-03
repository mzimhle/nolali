<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
		<script type="text/javascript" language="javascript" src="default.js"></script>
		<title>Newsletters | {$domainData.campaign_company}</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/newsletter/">Newsletters</a> &raquo; 
				<a href="/admin/newsletter/details.php?code={$newsletterData.newsletter_code}">{$newsletterData.newsletter_name}</a> &raquo; 
				<a href="#">Comms</a>
			</p>
			<p class="linebreak"></p>
			<div id="main">
				<p>Send out and view mailers sent out</p>
				<div id="tableContent" align="center">
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="htmlForm" id="htmlForm" action="/admin/newsletter/mail.php?code={$newsletterData.newsletter_code}" method="post">
							<table border="0" cellspacing="0" cellpadding="0" id="dataTable">							
								<thead>
								<tr>
								<th>Sent</th>
								<th>Name</th>
								<th>Email</th>
								<th>Cellphone</th>
								<th>Result</th>
								<th>Mailer</th>
								</tr>
							   </thead>
							   <tbody> 
							  {foreach from=$commData item=item}
							  <tr class="{if $item._comm_sent eq '1'}success{else}error{/if}">
								<td align="left">{$item._comm_added|date_format}</td>
								<td align="left">{$item.participant_name} {$item.participant_surname}</td>
								<td align="left">{$item.participant_email}</td>
								<td align="left">{$item.participant_cellphone}</td>
								<td align="left">{$item._comm_output}</td>
								<td align="left"><a href="/mailer/view/{$item._comm_code}" target="_blank">View Mailer</a></td>
							  </tr>
							  {/foreach}     
							  </tbody>
							</table>
							<input id="sendnewsletter" type="hidden" value="1" name="sendnewsletter">
						 </form>
					 </div>
					 <!-- End Content Table -->
					<div class="clear"></div>
				</div>
			</div>	
					<div class="article">
						<p class="short">
							<a class="link" href="javascript:sendEmail();">Sent Newsletter</a>
						</p>
					</div>					
			<div class="clr"></div>
			{include_php file='includes/footer.php'}
			</div>
			{literal}
			<script type="text/javascript">
			function sendEmail() {
				if(confirm('Are you sure you want to send this to all members?')) {
					document.forms.htmlForm.submit();					 
				}
			}
			</script>
			{/literal}			
	</body>
</html>