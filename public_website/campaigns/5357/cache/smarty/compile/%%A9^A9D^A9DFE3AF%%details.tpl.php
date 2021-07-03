<?php /* Smarty version 2.6.20, created on 2015-06-04 22:01:31
         compiled from booking/details.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'booking/details.tpl', 44, false),array('function', 'html_options', 'booking/details.tpl', 72, false),)), $this); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datuma Guest House - Make a booking and add your details</title>
	<meta name="keywords" content="online booking, guest house, make a booking, south africa, thornton cape town, bed and breakfast, western cape, accomodation">
	<meta name="description" content="<?php echo $this->_tpl_vars['campaign']['campaign_name']; ?>
 allows you to make bookings online but then you need to give us your contact details, we will get back to you as soon as possible.">          
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="21 days">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta property="og:title" content="<?php echo $this->_tpl_vars['campaign']['campaign_name']; ?>
"> 
	<meta property="og:image" content="http://<?php echo $this->_tpl_vars['campaign']['campaign_domain']; ?>
/images/logo.png"> 
	<meta property="og:url" content="http://<?php echo $this->_tpl_vars['campaign']['campaign_domain']; ?>
">
	<meta property="og:site_name" content="<?php echo $this->_tpl_vars['campaign']['campaign_name']; ?>
">
	<meta property="og:type" content="website">
	<meta property="og:description" content="<?php echo $this->_tpl_vars['campaign']['campaign_name']; ?>
 allows you to make bookings online but then you need to give us your contact details, we will get back to you as soon as possible.">
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/css.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/javascript.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
</head>
<body>
<div id="wrap">
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/header.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
	
	<div id="main">
		<h2><?php echo $this->_tpl_vars['campaign']['campaign_name']; ?>
 bookings</h2>		
		<p>For any bookings please fill in the below form and we will get back to you as soon as you have confirmed your email address.</p>
		<?php if (isset ( $this->_tpl_vars['success'] )): ?>
		<p class="success">Thank you for submitting a booking, we will get back to you as soon as possible, you will however get a confirmation email to confirm your email address as being valid, from there on we will process your booking</p>
		<?php endif; ?>
		<div class="clear"></div>
		<div class="line-hor"></div>
		<div id="contact-area">			
			<form method="post" action="/booking/details.php?startdate=<?php echo $this->_tpl_vars['startdate']; ?>
&enddate=<?php echo $this->_tpl_vars['enddate']; ?>
" name="detailsForm" id="detailsForm">
				<table>
					<tr>
						<td class="left">
							<label for="booking_startdate">Start Date:</label>
							<?php if (isset ( $this->_tpl_vars['errorArray']['booking_startdate'] )): ?><em class="error"><?php echo $this->_tpl_vars['errorArray']['booking_startdate']; ?>
</em><?php endif; ?>
						</td>
						<td>
							<span class="success"><?php echo ((is_array($_tmp=$this->_tpl_vars['startdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</span>
							<input type="hidden" value="<?php echo $this->_tpl_vars['startdate']; ?>
" id="booking_startdate" name="booking_startdate" />
						</td>
					</tr>
					<tr>
						<td class="left">
							<label for="booking_enddate">End Date:</label>
							<?php if (isset ( $this->_tpl_vars['errorArray']['booking_enddate'] )): ?><em class="error"><?php echo $this->_tpl_vars['errorArray']['booking_enddate']; ?>
</em><?php endif; ?>
						</td>
						<td>
							<span class="success"><?php echo ((is_array($_tmp=$this->_tpl_vars['enddate'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</span>
							<input type="hidden" value="<?php echo $this->_tpl_vars['enddate']; ?>
" id="booking_enddate" name="booking_enddate" />
						</td>
					</tr>
					<tr>
						<td class="left" colspan="2">
							<div class="line-hor"></div>
							<div class="clear"></div>								
						</td>
					</tr>
					<tr>
						<td class="left">
							<label for="product_code">Our Suites :</label>
							<?php if (isset ( $this->_tpl_vars['errorArray']['product_code'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['product_code']; ?>
</em><?php endif; ?>
						</td>
						<td>
							<select id="product_code" name="product_code">
								<option value=""> --- </option>
								<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['productPairs']), $this);?>

							</select>
						</td>
					</tr>
					<tr>
						<td class="left">
							<label for="productitem_code">Rooms :</label>
							<?php if (isset ( $this->_tpl_vars['errorArray']['productitem_code'] )): ?><em class="error"><?php echo $this->_tpl_vars['errorArray']['productitem_code']; ?>
</em><?php endif; ?>
						</td>
						<td id="productitemtypetd">
							<select name="productitem_code" id="productitem_code">
								<option value="">Please select a suite first.</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="left">
							<label for="_price_code">Room Prices :</label>
							<?php if (isset ( $this->_tpl_vars['errorArray']['_price_code'] )): ?><em class="error"><?php echo $this->_tpl_vars['errorArray']['_price_code']; ?>
</em><?php endif; ?>
						</td>
						<td id="pricetd">
							<select name="_price_code" id="_price_code">
								<option value="">Please select a room first.</option>
							</select>
						</td>
					</tr>					
					<tr>
						<td class="left" valign="top">
							<label for="booking_message">Message / Request:</label>
							<?php if (isset ( $this->_tpl_vars['errorArray']['booking_message'] )): ?><em class="error"><?php echo $this->_tpl_vars['errorArray']['booking_message']; ?>
</em><?php else: ?><em>(Optional)</em><?php endif; ?>
						</td>
						<td><textarea name="booking_message" id="booking_message" rows="20" cols="20"><?php echo $this->_tpl_vars['bookingData']['booking_message']; ?>
</textarea></td>
					</tr>
					<tr>
						<td class="left" colspan="2">
							<div class="line-hor"></div>
							<div class="clear"></div>								
						</td>
					</tr>	
					<tr>
						<td class="left">
							<label for="booking_person_name">Full Name :</label>
							<?php if (isset ( $this->_tpl_vars['errorArray']['booking_person_name'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['booking_person_name']; ?>
</em><?php endif; ?>
						</td>
						<td>
							<input type="text" id="booking_person_name" name="booking_person_name" value="<?php echo $this->_tpl_vars['bookingData']['booking_person_name']; ?>
" />
						</td>
					</tr>
					<tr>
						<td class="left">
							<label for="booking_person_email">Email :</label>
							<?php if (isset ( $this->_tpl_vars['errorArray']['booking_person_email'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['booking_person_email']; ?>
</em><?php endif; ?>
						</td>
						<td>
							<input type="text" id="booking_person_email" name="booking_person_email" value="<?php echo $this->_tpl_vars['bookingData']['booking_person_email']; ?>
" />
						</td>
					</tr>
					<tr>
						<td class="left">
							<label for="booking_person_number">Telephone / Cellphone :</label>
							<?php if (isset ( $this->_tpl_vars['errorArray']['booking_person_number'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['booking_person_number']; ?>
</em><?php else: ?><em>e.g. 0815987412</em><?php endif; ?>
						</td>
						<td>
							<input type="text" id="booking_person_number" name="booking_person_number" value="<?php echo $this->_tpl_vars['bookingData']['booking_person_number']; ?>
" />
						</td>
					</tr>					
					<tr>
						<td class="left">
							<label for="areapost_name">City / Town:</label>
							<?php if (isset ( $this->_tpl_vars['errorArray']['areapost_code'] )): ?><em class="error"><?php echo $this->_tpl_vars['errorArray']['areapost_code']; ?>
</em><?php endif; ?>
						</td>
						<td>
							<input type="text" name="areapost_name" id="areapost_name" value="<?php echo $this->_tpl_vars['bookingData']['areapost_name']; ?>
" />
							<input type="hidden" name="areapost_code" id="areapost_code" value="<?php echo $this->_tpl_vars['bookingData']['areapost_code']; ?>
" />
						</td>
					</tr>
					<tr>
						<td valign="top"><?php if (isset ( $this->_tpl_vars['errorArray']['booking_captcha'] )): ?><br /><em class="error">Incorrect characters entered, please try again.</em><?php endif; ?></td>
						<td>
							<div id="captcha-area"><?php echo $this->_tpl_vars['captchahtml']; ?>
</div>	
						</td>
					</tr>
				</table>
				<br /><br />						
				<input type="submit" name="submit" value="Submit" class="submit-button" />
			</form>		
		</div>
	</div>
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/sidebar.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
	
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/footer.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
		
</div>
<?php echo '
<script type="text/javascript">
function submitForm() {
	document.forms.detailsForm.submit();					 
}

$( document ).ready(function() {
		
	$(\'#product_code\').change(function() {	
		getItem();
	});
	
	$(\'#productitem_code\').change(function() {	
		getPrice();
	});
	
	$( "#areapost_name" ).autocomplete({
		source: "/feeds/areapost.php",
		minLength: 2,
		select: function( event, ui ) {
		
			if(ui.item.id == \'\') {
				$(\'#areapost_code\').val(\'\');					
			} else { 
				$(\'#areapost_code\').val(ui.item.id);									
			}
			
			$(\'#areapost_name\').val(\'\');										
		}
	});	
});	

function getPrice() {
	var productitem	= $(\'#productitem_code :selected\').val();
	
	if(productitem != \'\') {
		$.ajax({
			type: "GET",
			url: "/booking/details.php",
			data: "'; ?>
startdate=<?php echo $this->_tpl_vars['startdate']; ?>
&enddate=<?php echo $this->_tpl_vars['enddate']; ?>
<?php echo '&productitem_code_search="+productitem,
			dataType: "html",
			success: function(items){
				$(\'#_price_code\').html(items);
			}
		});
	}
}

function getItem() {
	var product	= $(\'#product_code :selected\').val();
	
	if(product != \'\') {
		$.ajax({
			type: "GET",
			url: "/booking/details.php",
			data: "'; ?>
startdate=<?php echo $this->_tpl_vars['startdate']; ?>
&enddate=<?php echo $this->_tpl_vars['enddate']; ?>
<?php echo '&product_code_search="+product,
			dataType: "html",
			success: function(items){
				//show table
				$(\'#productitem_code\').html(items);
			}
		});
	}
}	
</script>
'; ?>

</body>
</html>