<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}
		<title>{$domainData.campaign_company} | Admin</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/resources/">Resources</a>
			</p>			
			<p class="linebreak"></p>			
			<div id="main">
				<div class="col">
					<div class="article">
						<h4><a href="/admin/resources/documents/">Document Groups</a></h4>
						<p class="short">Online storage for any important company documents .<a href="/admin/resources/documents/">&raquo;</a></p>
					</div>					
				</div>
				<div class="col">
					<div class="article">
						<h4><a href="/admin/resources/sms/">Send Out SMS notification (Bulk SMS)</a></h4>
						<p class="short">Send bulk SMS's to all subscribers of the campaign<a href="/admin/resources/sms/">&raquo;</a></p>
					</div>						
				</div>				
			</div>
			{include_php file='includes/footer.php'}
		</div>
	</body>
</html>