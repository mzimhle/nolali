<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>{$domainData.campaign_company} | Admin | Enquiries</title>
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/enquiries/">Enquries</a> &raquo; 
				<a href="#">View Enquiry</a>
			</p>
			<p class="linebreak"></p>
			<div id="main">
				<form id="detailsForm" name="detailsForm" action="#" method="post">
				<div class="col">
					<div class="article">
						<h4><a href="#">Name</a></h4>
						<p class="short">
							{$enquiryData.enquiry_name}
						</p>
					</div>
					<div class="article">
						<h4><a href="#">Message</a></h4>
						<p class="short">
							{$enquiryData.enquiry_comments}
						</p>
					</div>					
				</div>				
				<div class="col">
					<div class="article">
						<h4><a href="#">Email</a></h4>
						<p class="short">
							{$enquiryData.enquiry_email|default:"N/A"}
						</p>
					</div>		
					<div class="article">
						<h4><a href="#">Cell</a></h4>
						<p class="short">
							{$enquiryData.enquiry_cell|default:"N/A"}
						</p>
					</div>					
				</div>	
				</form>					
				<div class="clr"></div>
			</div>
			{include_php file='includes/footer.php'}
		</div>			
	</body>
</html>