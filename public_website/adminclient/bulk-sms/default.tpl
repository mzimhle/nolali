<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
		<script type="text/javascript" language="javascript" src="default.js"></script>
		<title>Bulk SMS | {$domainData.campaign_company}</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/bulk-sms/">Bulk SMS's</a>
			</p>
			<p class="linebreak"></p>
			<div id="main">
			<p>
			{if $commDetails.sms_count_remainding gt 0}
				<span class="success">You have {$commDetails.sms_count_remainding} sms credits remaining to send. </span>				
			{else} 
				<span class="error">You do not have enought sms credits left to send, with  a balance of : {$commDetails.sms_count_remainding}, you will need to wait for next month, or request extra sms's to send by sending an email to the admin to <a href="mailto:admin@willow-nettica.co.za">admin@willow-nettica.co.za</a>.</span>
			{/if}
			</p>
			<p class="linebreak"></p>
				{if $commDetails.sms_count_remainding gt 0} 
					<a class="link" href="/admin/bulk-sms/details.php">Send Bulk SMS's to participants</a>
				{else}
					<span class="error">You do not have enough sms credits to send</span>	
				{/if}
				<div id="tableContent" align="center">
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="htmlForm" id="htmlForm" action="/admin/bulk-sms/" method="post">
							<table border="0" cellspacing="0" cellpadding="0" id="dataTable">							
								<thead>
								<tr>
									<th>Added</th>
									<th>Status</th>
									<th>Subscriber</th>
									<th>Cell Number</th>
									<th>Message</th>
									<th>Result</th>															
								</tr>
								</thead>							
							   <tbody>
							  {foreach from=$commData item=item}
							  <tr>
								<td align="left">{$item._comm_added|date_format}</td>
								<td align="left">{if $item._comm_sent eq 1}<span class="success">Successful</span>{else}<span class="error">Failed</span>{/if}</td>
								<td align="left">{$item.participant_name} {$item.participant_surname}</td>
								<td align="left">{$item._comm_cell}</td>
								<td align="left">{$item._comm_message}</td>
								<td align="left">{$item._comm_output}</td>							
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