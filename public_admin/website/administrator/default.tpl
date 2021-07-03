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
			<li><a href="/website/administrator/" title="">Administrator</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage <span class="success">{$domainData.campaign_name}</span> Administrators</h2>			
	<a href="/website/administrator/details.php" title="Click to Add a new Administrator" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new Administrator</span></a> <br />
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
			<thead>
			  <tr>	
				<th>Full Name</th>
				<th>Cellphone</th>
				<th>Email</th>
				<th>Password</th>
				<th>Last Login</th>
				<th></th>
			   </tr>
			   </thead>
			   <tbody>
			  {foreach from=$administratorData item=item}
			  <tr>
				<td align="left"><a href="/website/administrator/details.php?code={$item.administrator_code}">{$item.administrator_name} {$item.administrator_surname}</a></td>	
				<td align="left">{$item.administrator_cellphone}</td>
				<td align="left">{$item.administrator_email}</td>	
				<td align="left">{$item.administrator_password}</td>		
				<td align="left">{$item.administrator_last_login}</td>		
				<td align="left"><button onclick="deleteitem('{$item.administrator_code}')">Delete</button></td>	
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
