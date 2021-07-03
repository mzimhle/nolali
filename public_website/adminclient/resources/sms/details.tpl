<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>{$domainData.campaign_company} | Admin | Bulk SMS</title>		
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
		<script type="text/javascript" language="javascript" src="default.js"></script>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/resources/">Resources</a> &raquo; 
				<a href="/admin/resources/sms/">Bulk SMS's</a>
				<a href="#">Send SMS's</a>
			</p>
			<p class="linebreak"></p>
			<div id="main">
				<form id="detailsForm" name="detailsForm" action="/admin/resources/sms/details.php" method="post">
				<div class="col">										
					<div class="article">
						<h4><a href="#" {if isset($errorArray._comms_message)}class="error"{/if}>Message</a>{if isset($errorArray._comms_message)}<span class="error"> - {$errorArray._comms_message}</span>{/if}</h4>					
						<p class="short">
							<textarea id="_comms_message" name="_comms_message" rows="5" cols="40" >{$comms_message}</textarea>	
							<p><span id="charcount" class="error">0</span> characters entered.</p>
						</p>						
					</div>					
					<div class="article">
						<p class="short">
							<a class="link" href="javascript:submitForm();">Send SMS to {$particiapntnumber} subscriber(s)</a>
						</p>
					</div>						
				</div>
				<div class="col"></div>
				<div class="col">										
					<div class="article">
						<h4><a href="#">Remainding SMS Credits</a></h4>					
						<p class="short">
							{$commsDetails.sms_count_remainding}	
						</p>						
					</div>
					<div class="article">
						<h4><a href="#">Total SMS's sent so far</a></h4>					
						<p class="short">
							{$commsDetails.sms_count_sent}
						</p>						
					</div>					
				</div>					
				</form>
				<div class="clear"></div>
				<div id="tableContent" align="center">
					<!-- Start Content Table -->
					<div class="content_table">
						<p><h2>SMS's you have just sent</h2></p>
						<form name="htmlForm" id="htmlForm" action="/admin/resources/sms/" method="post">
							<table border="0" cellspacing="0" cellpadding="0" id="dataTable">							
								<thead>
								<tr>
									<th>Subscriber</th>
									<th>Cell Number</th>
									<th>Output</th>
								</tr>
								</thead>							
							   <tbody>
							  {foreach from=$commsData item=item}
							  <tr>
								<td align="left">{$item.fullname}</td>
								<td align="left">{$item.cell}</td>
								<td align="left">{$item.output}</td>
							  </tr>
							  {/foreach}     
							  </tbody>
							</table>
						 </form>
					 </div>
					 <!-- End Content Table -->				
				</div>				
				<div class="clr"></div>
			</div>
			{include_php file='includes/footer.php'}
		</div>
		{literal}
		<script type="text/javascript">
		function submitForm() {
			if(confirm('Are sure you want to send this sms to all your subscribers?')) {
				document.forms.detailsForm.submit();					 
			}
		}
		$(document).ready(function(){
		
			$("#_comms_message").keyup(function () {
				var i = $("#_comms_message").val().length;
				$("#charcount").html(i);
				if (i > 160) {
					$('#charcount').removeClass('success');
					$('#charcount').addClass('error');
				} else if(i == 0) {
					$('#charcount').removeClass('success');
					$('#charcount').addClass('error');
				} else {
					$('#charcount').removeClass('error');
					$('#charcount').addClass('success');
				} 
			});	
			
		});
		</script>
		{/literal}			
	</body>
</html>