<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>{$domainData.campaign_name} Management System</title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	{include_php file='includes/css.php'}
</head>
<body>
{include_php file='includes/header.php'}
<div class="container">
  <div class="content">
    <div class="content-container">
	<div class="content-header">
	<h2 class="content-header-title">Booking</h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="/booking/">Booking</a></li>
	<li><a href="#">{if isset($bookingData)}{$bookingData.booking_person_name} - {$bookingData.booking_person_email}{else}Add a booking{/if}</a></li>
	<li class="active">Details</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					{if isset($bookingData)}{$bookingData.booking_person_name} - {$bookingData.booking_person_email}{else}Add a booking{/if}
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/booking/details.php{if isset($bookingData)}?code={$bookingData.booking_code}{/if}" method="POST" data-validate="parsley" class="form parsley-form">
                <div class="form-group">
                  <label for="booking_person_name">Fullname</label>
                  <input type="text" id="booking_person_name" name="booking_person_name" class="form-control" data-required="true" value="{$bookingData.booking_person_name}" />
				{if isset($errorArray.booking_person_name)}<span class="error">{$errorArray.booking_person_name}</span>{/if}					  
                </div>
                <div class="form-group">
                  <label for="booking_person_email">Email Address</label>
                  <input type="text" id="booking_person_email" name="booking_person_email" class="form-control" data-required="true" value="{$bookingData.booking_person_email}" />
				{if isset($errorArray.booking_person_email)}<span class="error">{$errorArray.booking_person_email}</span>{/if}					  
                </div>
                <div class="form-group">
                  <label for="booking_person_number">Cellphone / Telephone Number</label>
                  <input type="text" id="booking_person_number" name="booking_person_number" class="form-control" value="{$bookingData.booking_person_number}" />
				{if isset($errorArray.booking_person_number)}<span class="error">{$errorArray.booking_person_number}</span>{/if}					  
                </div>
                <div class="form-group">
                  <label for="areapost_name">Area</label>
                  <input type="text" id="areapost_name" name="areapost_name" class="form-control" value="{$bookingData.areapost_name}" />
				  <input type="hidden" id="areapost_code" name="areapost_code" value="{$bookingData.areapost_code}" />
				{if isset($errorArray.booking_person_number)}<span class="error">{$errorArray.booking_person_number}</span>{/if}					  
                </div>	
                <div class="form-group">
                  <label for="booking_startdate">Start date and time</label>
                  <input type="text" id="booking_startdate" name="booking_startdate" class="form-control" data-required="true" value="{$bookingData.booking_startdate}" />
				{if isset($errorArray.booking_startdate)}<span class="error">{$errorArray.booking_startdate}</span>{/if}					  
                </div>
                <div class="form-group">
                  <label for="booking_enddate">End date and time</label>
                  <input type="text" id="booking_enddate" name="booking_enddate" class="form-control" data-required="true" value="{$bookingData.booking_enddate}" />
				{if isset($errorArray.booking_enddate)}<span class="error">{$errorArray.booking_enddate}</span>{/if}					  
                </div>				
                <div class="form-group">
					<label for="booking_message">Message / Note</label>
					<textarea id="booking_message" name="booking_message" class="form-control wysihtml5" rows="3">{$bookingData.booking_message}</textarea>
					{if isset($errorArray.booking_message)}<span class="error">{$errorArray.booking_message}</span>{/if}					  
                </div>				
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->
		<div class="col-sm-3">
			<div class="list-group">  
				<a class="list-group-item" href="/booking/">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				{if isset($bookingData)}					
				<a class="list-group-item" href="#">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a> 
				<a class="list-group-item" href="/booking/item.php?code={$bookingData.booking_code}">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Items
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				<a class="list-group-item" href="/booking/payment.php?code={$bookingData.booking_code}">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Payments
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>				
				<a class="list-group-item" href="/booking/generate.php?code={$bookingData.booking_code}">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Generate PDF Invoice
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>				
				{/if}
			</div> <!-- /.list-group -->
        </div>			
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}
{literal}
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	$( "#areapost_name" ).autocomplete({
		source: "/feeds/areapost.php",
		minLength: 2,
		select: function( event, ui ) {
			if(ui.item.id == '') {
				$('#areapost_name').html('');
				$('#areapost_code').val('');					
			} else {
				$('#areapost_name').html('<b>' + ui.item.value + '</b>');
				$('#areapost_code').val(ui.item.id);	
			}
			$('#areapost_name').val('');										
		}
	});
	
	$( "#booking_startdate" ).datetimepicker({
		defaultDate: "+1w",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		numberOfMonths: 3,
		onClose: function( selectedDate ) {
			$( "#booking_enddate" ).datetimepicker( "option", "minDate", selectedDate );
		}
	});
	
	$( "#booking_enddate" ).datetimepicker({
		defaultDate: "+1w",
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		numberOfMonths: 3,
		onClose: function( selectedDate ) {
			$( "#booking_startdate" ).datetimepicker( "option", "maxDate", selectedDate );
		}
	});	
});
</script>
{/literal}
</html>
