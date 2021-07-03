<?php /* Smarty version 2.6.20, created on 2015-06-04 18:32:18
         compiled from booking/default.tpl */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $this->_tpl_vars['campaign']['campaign_name']; ?>
 - Make a booking</title>
	<meta name="keywords" content="online booking, guest house, make a booking, south africa, thornton cape town, bed and breakfast, western cape, accomodation">
	<meta name="description" content="<?php echo $this->_tpl_vars['campaign']['campaign_name']; ?>
 allows you to make bookings online as well as allows you to see which dates are available.">          
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
 allows you to make bookings online as well as allows you to see which dates are available.">
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/css.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/javascript.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

	<link rel="stylesheet" type="text/css" href="/library/javascript/fullcalendar-1.6.2/fullcalendar.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="/library/javascript/fullcalendar-1.6.2/fullcalendar.print.css" media="screen" />
	<script type="text/javascript" language="javascript" src="/library/javascript/fullcalendar-1.6.2/fullcalendar.min.js"></script>
	<script type="text/javascript" language="javascript" src="/feeds/bookings.php"></script>
	<script type="text/javascript" language="javascript" src="/library/javascript/date.js"></script>
</head> 
<body>
<div id="wrap">
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/header.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
	
	<div id="main">
		<p>Please select the days you would like to book by simply dragging on top of them from start to finish.</p>
		<div id='calendar'></div>
	</div>
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/sidebar.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
	
	<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "includes/footer.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>
		
</div>
<?php echo '
<script type="text/javascript" language="javascript">		
$(document).ready(function() {
	
	var calendar = $(\'#calendar\').fullCalendar({
		header: {
			left: \'prev,next today\',
			center: \'title\',
			right: \'month\'
		},
		selectable: true,
		selectHelper: true,
		select: function(start, end, allDay) {
			
			var check = $.fullCalendar.formatDate(start,\'yyyy-MM-dd\');
			var today = $.fullCalendar.formatDate(new Date(),\'yyyy-MM-dd\');			
			
			if(check < today) {
				alert(\'You cannot book past dates.\')
			} else {
				var startdate = new Date(start);
				var enddate = new Date(end);			
				window.location.href = \'/booking/details.php?startdate=\'+startdate.format(\'yyyy-mm-dd\')+\'&enddate=\'+enddate.format(\'yyyy-mm-dd\');
			}
		},
		editable: true,
		events: bookings
	});
});
</script>
'; ?>

</body>
</html>