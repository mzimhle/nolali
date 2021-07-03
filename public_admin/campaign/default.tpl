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
			<li><a href="/campaign/" title="Campaign">Campaign</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage Campaign</h2>		
	<a href="/campaign/details.php" title="Click to Add a new Campaign" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new campaign</span></a> <br />
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">			
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
				<thead>
			  <tr>
				<th>Added</th>
				<th>Domain</th>
				<th>Company</th>
				<th>Contact</th>
				<th>Email</th>
				<th>Cellphone</th>
				<th>Area</th>
				<th></th>
			   </tr>
			   </thead>
			   <tbody>
			  {foreach from=$campaignData item=item}
			  <tr>
				<td>{$item.campaign_added|date_format}</td>
				<td>
					<a href="http://{$item.campaign_domain}" target="_blank">Website</a> | 
					<a href="http://{$item.campaign_domain_admin}" target="_blank">Admin</a>
				</td>
				<td align="left">
					<a href="/campaign/details.php?code={$item.campaign_code}" class="{if $item.campaign_active eq 1}success{else}error{/if}">
						{$item.campaign_company}
					</a>
				</td>	
				<td align="left">{$item.campaign_contact_name} {$item.campaign_contact_surname}</td>
				<td align="left">{$item.campaign_email}</td>
				<td align="left">{$item.campaign_telephone|default:"N/A"} / {$item.campaign_cell|default:"N/A"}</td>
				<td align="left">{$item.areapost_name}</td>
				<td align="left"><button onclick="changeStatus('{$item.campaign_code}', '{if $item.campaign_active eq '1'}0{else}1{/if}')">{if $item.campaign_active eq '1'}Deactivate{else}Activate{/if}</button></td>
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
