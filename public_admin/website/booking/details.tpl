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
    <!-- Start Content recruiter -->
  <div id="content">
    {include_php file='includes/header.php'}
  	<br />
	<div id="breadcrumb">
        <ul>
            <li><a href="/" title="Home">Home</a></li>
			<li><a href="/website/" title="Website">Website</a></li>
			<li><a href="#" title="Website"><span class="success">{$domainData.campaign_name}</span></a></li>
			<li><a href="/website/booking/" title="">Booking</a></li>
			<li><a href="/website/booking/" title="">View</a></li>
			<li>{if isset($bookingData)}Edit booking{else}Add a booking{/if}</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{if isset($bookingData)}Edit booking{else}Add a new booking{/if}</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="{if isset($bookingData)}/website/booking/item.php?code={$bookingData.booking_code}{else}#{/if}" title="Item">Item</a></li>
        </ul>
    </div><!--tabs-->

	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/website/booking/details.php{if isset($bookingData)}?code={$bookingData.booking_code}{/if}" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
			<tr>
				<td>
					<h4 class="error">Person fullname:</h4><br />					
					<input type="text" id="booking_person_name" name="booking_person_name" size="40" value="{$bookingData.booking_person_name}" />
					{if isset($errorArray.booking_person_name)}<br /><em class="error">{$errorArray.booking_person_name}</em>{/if}
				</td>
				<td>
					<h4 class="error">Person Email:</h4><br />					
					<input type="text" id="booking_person_email" name="booking_person_email" size="40" value="{$bookingData.booking_person_email}" />
					{if isset($errorArray.booking_person_email)}<br /><em class="error">{$errorArray.booking_person_email}</em>{/if}
				</td>
				<td>
					<h4>Person Number:</h4><br />					
					<input type="text" id="booking_person_number" name="booking_person_number" size="40" value="{$bookingData.booking_person_number}" />
					{if isset($errorArray.booking_person_number)}<br /><em class="error">{$errorArray.booking_person_number}</em>{/if}
				</td>					
			</tr>
			<tr>
				<td valign="top">
					<h4>Person Area:</h4><br />					
					<input type="text" id="areapost_name" name="areapost_name" size="40" value="{$bookingData.areapost_name}" />
					<input type="hidden" id="areapost_code" name="areapost_code" size="40" value="{$bookingData.areapost_code}" />			
				</td>
				<td valign="top" colspan="2">
					<h4>Notes:</h4><br />
					<textarea cols="80" rows="3" id="booking_message" name="booking_message">{$bookingData.booking_message}</textarea>
				</td>		
			</tr>			
			<tr>
				<td>
					<h4 class="error">Start Date:</h4><br />
					<input type="text" name="booking_startdate" id="booking_startdate" value="{$bookingData.booking_startdate}" size="20"/>
					{if isset($errorArray.booking_startdate)}<br /><em class="error">{$errorArray.booking_startdate}</em>{/if}
				</td>
				<td colspan="2">
					<h4 class="error">End Date:</h4><br />
					<input type="text" name="booking_enddate" id="booking_enddate" value="{$bookingData.booking_enddate}" size="20"/>
					{if isset($errorArray.booking_enddate)}<br /><em class="error">{$errorArray.booking_enddate}</em>{/if}		
				</td>				
          </tr>	  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="javascript:submitForm();" class="blue_button mrg_left_147 fl"><span>Save &amp; Complete</span></a>   
        </div>
    <div class="clearer"><!-- --></div>
    </div><!--inner-->
 </div> 	
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 {include_php file='includes/footer.php'}
</div>
{literal}
<script type="text/javascript">
function submitForm() {
	document.forms.detailsForm.submit();					 
}
			
$( document ).ready(function() {

	$( "#areapost_name" ).autocomplete({
		source: "/feeds/area.php",
		minLength: 2,
		select: function( event, ui ) {
		
			if(ui.item.id == '') {
				$('#areapost_name').val('');
				$('#areapost_code').val('');					
			} else { 
				$('#areapost_name').val(ui.item.value);
				$('#areapost_code').val(ui.item.id);									
			}									
		}
	});
	
	$( "#booking_startdate" ).datetimepicker({
	  defaultDate: "+1w",
	  dateFormat: 'yy-mm-dd',
	  changeMonth: false,
	  numberOfMonths: 3,
	  onClose: function( selectedDate ) {
		$( "#booking_enddate" ).datetimepicker( "option", "minDate", selectedDate );
	  }
	});
	
	$( "#booking_enddate" ).datetimepicker({
	  defaultDate: "+1w",
	  dateFormat: 'yy-mm-dd',
	  changeMonth: false,
	  numberOfMonths: 3,
	  onClose: function( selectedDate ) {
		$( "#booking_startdate" ).datetimepicker( "option", "maxDate", selectedDate );
	  }
	});
	
});		
</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
