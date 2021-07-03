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
			<li><a href="/website/booking/" title="">Booking</a></li>
			<li><a href="/website/booking/" title="">View</a></li>
        </ul>
	</div><!--breadcrumb-->  
	<div class="inner">     
    <h2>Manage <span class="success">{$domainData.campaign_name}</span> Bookings</h2>		
	<a href="/website/booking/details.php" title="Click to Add a new booking" class="blue_button fr mrg_bot_10"><span style="float:right;">Add a new booking</span></a> <br />
    <div class="clearer"><!-- --></div>
    <div id="tableContent" align="center">
		<!-- Start Content Table -->
		<div class="content_table">			
			<table id="dataTable" border="0" cellspacing="0" cellpadding="0">
			<thead>
			<tr>
				<th>Added</th>
				<th>Person Name</th>
				<th>Person Contact</th>								
				<th>Start Date - End Date</th>					
				<th>Message</th>
				<th></th>
				<th></th>
			</tr>
			</thead>
			   <tbody>
			  {foreach from=$bookingData item=item}
			  <tr>
				<td>{$item.booking_added|date_format}</td>
				<td align="left">{$item.booking_person_name}</td>				
				<td align="left">{$item.booking_person_email} / {$item.booking_person_number}</td>	
				<td align="left">
					<a href="/website/booking/details.php?code={$item.booking_code}" class="{if $item.booking_status eq ''}{/if}{if $item.booking_status eq '0'}error{/if}{if $item.booking_status eq '1'}success{/if}">
						{$item.booking_startdate|date_format:"%A, %B %e, %Y"} till {$item.booking_enddate|date_format:"%A, %B %e, %Y"}
					</a>
				</td>
				<td align="left">{$item.booking_message}</td>	
				<td align="left"><button onclick="changeStatus('{$item.booking_code}', '{if $item.booking_status eq '1'}0{else}1{/if}'); return false;">{if $item.booking_status eq '1'}Unbook{else}Book{/if}</button></td>
				<td align="left"><button onclick="deleteitem('{$item.booking_code}'); return false;">Delete</button></td>
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

