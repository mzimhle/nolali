<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nolali - The Creative</title>
{include_php file='includes/css.php'}
{include_php file='includes/javascript.php'} 
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
        </ul>
	</div><!--breadcrumb-->  	
  <div class="inner">  
   <h2>Manage Galleries</h2>	

  <div class="clearer"><!-- --></div>
  <div class="section">
  	<a href="/website/gallery/view/" title="Manage View"><img src="/images/users.gif" alt="Manage View" height="50" width="50" /></a>
  	<a href="/website/gallery/view/" title="Manage View" class="title">Manage View</a>
  </div> 
  <div class="section mrg_left_50">
  	<a href="/website/gallery/type/" title="Manage Type"><img src="/images/users.gif" alt="Manage Type" height="50" width="50" /></a>
  	<a href="/website/gallery/type/" title="Manage Type" class="title">Manage Type</a>
  </div>   
    <div class="clearer"><!-- --></div>   
    </div><!--inner-->
  </div><!-- End Content Section -->
 {include_php file='includes/footer.php'}
</div>
<!-- End Main Container -->
</body>
</html>
