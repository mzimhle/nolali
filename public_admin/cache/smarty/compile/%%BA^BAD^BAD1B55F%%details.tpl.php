<?php /* Smarty version 2.6.20, created on 2015-05-21 07:41:47
         compiled from website/booking/details.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nolali - The Creative</title>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</head>
<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content recruiter -->
  <div id="content">
    <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

  	<br />
	<div id="breadcrumb">
        <ul>
            <li><a href="/" title="Home">Home</a></li>
			<li><a href="/website/" title="Website">Website</a></li>
			<li><a href="#" title="Website"><span class="success"><?php echo $this->_tpl_vars['domainData']['campaign_name']; ?>
</span></a></li>
			<li><a href="/website/booking/" title="">Booking</a></li>
			<li><a href="/website/booking/" title="">View</a></li>
			<li><?php if (isset ( $this->_tpl_vars['bookingData'] )): ?>Edit booking<?php else: ?>Add a booking<?php endif; ?></li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2><?php if (isset ( $this->_tpl_vars['bookingData'] )): ?>Edit booking<?php else: ?>Add a new booking<?php endif; ?></h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="<?php if (isset ( $this->_tpl_vars['bookingData'] )): ?>/website/booking/item.php?code=<?php echo $this->_tpl_vars['bookingData']['booking_code']; ?>
<?php else: ?>#<?php endif; ?>" title="Item">Item</a></li>
        </ul>
    </div><!--tabs-->

	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/website/booking/details.php<?php if (isset ( $this->_tpl_vars['bookingData'] )): ?>?code=<?php echo $this->_tpl_vars['bookingData']['booking_code']; ?>
<?php endif; ?>" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
			<tr>
				<td>
					<h4 class="error">Person fullname:</h4><br />					
					<input type="text" id="booking_person_name" name="booking_person_name" size="40" value="<?php echo $this->_tpl_vars['bookingData']['booking_person_name']; ?>
" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['booking_person_name'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['booking_person_name']; ?>
</em><?php endif; ?>
				</td>
				<td>
					<h4 class="error">Person Email:</h4><br />					
					<input type="text" id="booking_person_email" name="booking_person_email" size="40" value="<?php echo $this->_tpl_vars['bookingData']['booking_person_email']; ?>
" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['booking_person_email'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['booking_person_email']; ?>
</em><?php endif; ?>
				</td>
				<td>
					<h4>Person Number:</h4><br />					
					<input type="text" id="booking_person_number" name="booking_person_number" size="40" value="<?php echo $this->_tpl_vars['bookingData']['booking_person_number']; ?>
" />
					<?php if (isset ( $this->_tpl_vars['errorArray']['booking_person_number'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['booking_person_number']; ?>
</em><?php endif; ?>
				</td>					
			</tr>
			<tr>
				<td valign="top">
					<h4>Person Area:</h4><br />					
					<input type="text" id="areapost_name" name="areapost_name" size="40" value="<?php echo $this->_tpl_vars['bookingData']['areapost_name']; ?>
" />
					<input type="hidden" id="areapost_code" name="areapost_code" size="40" value="<?php echo $this->_tpl_vars['bookingData']['areapost_code']; ?>
" />			
				</td>
				<td valign="top" colspan="2">
					<h4>Notes:</h4><br />
					<textarea cols="80" rows="3" id="booking_message" name="booking_message"><?php echo $this->_tpl_vars['bookingData']['booking_message']; ?>
</textarea>
				</td>		
			</tr>			
			<tr>
				<td>
					<h4 class="error">Start Date:</h4><br />
					<input type="text" name="booking_startdate" id="booking_startdate" value="<?php echo $this->_tpl_vars['bookingData']['booking_startdate']; ?>
" size="20"/>
					<?php if (isset ( $this->_tpl_vars['errorArray']['booking_startdate'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['booking_startdate']; ?>
</em><?php endif; ?>
				</td>
				<td colspan="2">
					<h4 class="error">End Date:</h4><br />
					<input type="text" name="booking_enddate" id="booking_enddate" value="<?php echo $this->_tpl_vars['bookingData']['booking_enddate']; ?>
" size="20"/>
					<?php if (isset ( $this->_tpl_vars['errorArray']['booking_enddate'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['booking_enddate']; ?>
</em><?php endif; ?>		
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
 <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</div>
<?php echo '
<script type="text/javascript">
function submitForm() {
	document.forms.detailsForm.submit();					 
}
			
$( document ).ready(function() {

	$( "#areapost_name" ).autocomplete({
		source: "/feeds/area.php",
		minLength: 2,
		select: function( event, ui ) {
		
			if(ui.item.id == \'\') {
				$(\'#areapost_name\').val(\'\');
				$(\'#areapost_code\').val(\'\');					
			} else { 
				$(\'#areapost_name\').val(ui.item.value);
				$(\'#areapost_code\').val(ui.item.id);									
			}									
		}
	});
	
	$( "#booking_startdate" ).datetimepicker({
	  defaultDate: "+1w",
	  dateFormat: \'yy-mm-dd\',
	  changeMonth: false,
	  numberOfMonths: 3,
	  onClose: function( selectedDate ) {
		$( "#booking_enddate" ).datetimepicker( "option", "minDate", selectedDate );
	  }
	});
	
	$( "#booking_enddate" ).datetimepicker({
	  defaultDate: "+1w",
	  dateFormat: \'yy-mm-dd\',
	  changeMonth: false,
	  numberOfMonths: 3,
	  onClose: function( selectedDate ) {
		$( "#booking_startdate" ).datetimepicker( "option", "maxDate", selectedDate );
	  }
	});
	
});		
</script>
'; ?>

<!-- End Main Container -->
</body>
</html>