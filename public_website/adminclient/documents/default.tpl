<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
		<script type="text/javascript" language="javascript" src="default.js"></script>
		<title>{$domainData.campaign_company}| Admin | Documents</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/documents/">Documents Groups</a>
			</p>
			<p class="linebreak"></p>
			<div id="main">
				<a class="link" href="/admin/documents/details.php">Add a New Document</a>
				<div id="tableContent" align="center">
					<!-- Start Content Table -->
					<div class="content_table">
						<form name="htmlForm" id="htmlForm" action="/admin/documents/" method="post">
							<table border="0" cellspacing="0" cellpadding="0" id="dataTable">							
								<thead>
								<tr>
									<th>Added</th>
									<th>Name</th>
									<th>Description</th>
								</tr>
								</thead>							
							   <tbody>
							  {foreach from=$campaigndocumentData item=item}
							  <tr>
								<td>{$item.campaigndocument_added|date_format}</td>
								<td align="left"><a href="/admin/documents/details.php?code={$item.campaigndocument_code}">{$item.campaigndocument_name}</a></td>
								<td align="left">{$item.campaigndocument_description}</td>
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