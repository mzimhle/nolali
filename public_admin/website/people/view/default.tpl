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
			<li><a href="/website/people/" title="">People</a></li>
			<li><a href="/website/people/view/" title="">View</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage <span class="success">{$domainData.campaign_name}</span> People</h2>		
	<a href="/website/people/view/details.php" title="Click to Add a new Person" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new Person</span></a> <br />
    <div class="clearer"><!-- --></div>
	<label for="search">Search by name, surname or cellphone number</label><br />
	<input type="text" class="form-control"  id="search" name="search" size="60" value="" />
	<button type="button" onClick="getAll();" class="btn btn-primary">Search</button><br /><br />		
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">		
			Loading subscriber details..... Please wait...
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
