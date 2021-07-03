<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nolali - The Creative</title>
{include_php file='includes/css.php'}
{include_php file='includes/javascript.php'}
<script type="text/javascript" language="javascript" src="default.js"></script>
</head>

<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content Section -->
  <div id="content">
    {include_php file='includes/header.php'}
	<div id="breadcrumb">
        <ul>
            <li><a href="/" title="Home">Home</a></li>
			<li><a href="/website/" title="Website">Website</a></li>
			<li><a href="#" title="Website"><span class="success">{$domainData.campaign_name}</span></a></li>
			<li><a href="/website/inquiry/" title="Inquiries">Inquiries</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage {$domainData.campaign_name} Inquiries</h2>
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">			
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
				<tr>
				<th>Added</th>
				<th>Name</th>
				<th>Email</th>
				<th>Number</th>
				<th>Subject</th>
				<th>Message</th>
				</tr>
			   </thead>
			   <tbody> 
			  {foreach from=$inquiryData item=item}
			  <tr>
				<td>{$item.inquiry_added|date_format}</td>
				<td align="left">{$item.inquiry_name}</td>
				<td align="left">{$item.inquiry_email}</td>	
				<td align="left">{$item.inquiry_number}</td>
				<td align="left">{$item.inquiry_subject}</td>
				<td align="left">{$item.inquiry_comments}</td>
			  </tr>
			  {/foreach}     
			  </tbody>
			</table>
		 </div>
		 <!-- End Content Table -->	
	</div>
    <div class="clearer"><!-- --></div>
    </div><!--inner-->
  </div><!-- End Content Section -->
 {include_php file='includes/footer.php'}
</div>
<!-- End Main Container -->
</body>
</html>
