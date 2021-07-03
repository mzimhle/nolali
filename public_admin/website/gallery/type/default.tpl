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
			<li><a href="/website/gallery/" title="">Gallery</a></li>
			<li><a href="/website/gallery/type/" title="">Type</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage <span class="success">{$domainData.campaign_name}</span> Gallery Types</h2>
	<a href="/website/gallery/type/details.php" title="Click to Add a new Type" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new Type</span></a>  <br /> 
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
				<tr>
				<th>Added</th>
				<th>Name</th>
				<th></th>
				</tr>
			   </thead>
			   <tbody> 
			  {foreach from=$gallerytypeData item=item}
			  <tr>
				<td>{$item.gallerytype_added|date_format}</td>
				<td align="left"><a href="/website/gallery/type/details.php?code={$item.gallerytype_code}">{$item.gallerytype_name}</a></td>
				<td align="right"><button onclick="deleteitem('{$item.gallerytype_code}')">Delete</button></td>
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
