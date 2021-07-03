<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
		<script type="text/javascript" language="javascript" src="default.js"></script>
		<title>{$domainData.campaign_company}| Admin | Resources | Bulk SMS's</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/resources/">Resources</a> &raquo; 
				<a href="/admin/resources/sms/">Bulk SMS's</a>
			</p>
			<p class="linebreak"></p>
			<div id="main">
			<p>
			{if $commsDetails.sms_count_remainding gt 0} 
				<span class="success">You have {$commsDetails.sms_count_remainding} sms credits remaining to send. </span>				
			{else} 
				<span class="error">You do not have enought sms credits left to send, with  a balance of : {$commsDetails.sms_count_remainding}, you will need to wait for next month, or request extra sms's to send by sending an email to the admin to <a href="mailto:admin@willow-nettica.co.za">admin@willow-nettica.co.za</a>.</span>
			{/if}
			</p>
			<p class="linebreak"></p>
				{if $commsDetails.sms_count_remainding gt 0} 
					<a class="link" href="/admin/resources/sms/details.php">Send Bulk SMS's to subscribers</a>
				{else}
					<span class="error">You do not have enough sms credits to send</span>	
				{/if}
				<div id="tableContent" align="center">
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="htmlForm" id="htmlForm" action="/admin/resources/sms/" method="post">
							<table border="0" cellspacing="0" cellpadding="0" id="dataTable">							
								<thead>
								<tr>
									<th>Added</th>
									<th>Subscriber</th>
									<th>Cell Number</th>
									<th>Message</th>									
								</tr>
								</thead>							
							   <tbody>
							  {foreach from=$commsData item=item}
							  <tr>
								<td>{$item._comms_added|date_format}</td>
								<td align="left">{$item.participant_name} {$item.participant_surname}</td>
								<td align="left">{$item.participantdetail_cell}</td>
								<td align="left">{$item._comms_message}</td>
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
	</body>
</html>