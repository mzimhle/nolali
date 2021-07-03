<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

require_once 'config/database.php';
require_once 'config/smarty.php';

/* Check posted data. */
if(count($_POST) > 0) {
	
	require_once 'class/enquiry.php';
	
	$errorMessages		= array();
	$data 				= array();
	$formValid			= true;
	$success			= NULL;
	$areaByName			= NULL;
	$enquiryObject		= new class_enquiry();
	
	if(isset($_POST['enquiry_message']) && trim($_POST['enquiry_message']) == '') {
		$errorMessages[] = 'Please add a message.';
		$formValid = false;		
	}
	
	if(isset($_POST['enquiry_subject']) && trim($_POST['enquiry_subject']) == '') {
		$errorMessages[] = 'Please add a subject.';
		$formValid = false;		
	}	
	
	if(isset($_POST['enquiry_name']) && trim($_POST['enquiry_name']) == '') {
		$errorMessages[] = 'Please add your name.';
		$formValid = false;		
	}
	
	if(isset($_POST['enquiry_email']) && trim($_POST['enquiry_email']) != '') {
		if(!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', trim($_POST['enquiry_email']))) {
			$errorMessages[] = 'Please add a valid email address.';
			$formValid = false;
		}	
	} else {
		$errorMessages[] = 'Please add an email address.';
		$formValid = false;
	}

	if($formValid == true) {

		$data 	= array();	
		$data['enquiry_name'] 				= trim($_POST['enquiry_name']);
		$data['enquiry_email'] 				= trim($_POST['enquiry_email']);
		$data['enquiry_message']			= trim($_POST['enquiry_message']);
		
		$success  = $enquiryObject->insert($data);
		
		if($success) {
			require('Zend/Mail.php');
			
			$mail = new Zend_Mail();
			
			$smarty->assign('enquiryData', $data);	
			
			$message = $smarty->fetch('templates/enquiry.html');
			$mail->setFrom('info@nolali.co.za', 'Nolali - The Creative'); //EDIT!!											
			$mail->addTo($data['enquiry_email']);
			$mail->addTo('info@nolali.co.za');
			$mail->setSubject('Nolali - The Creative');
			$mail->setBodyHtml($message);			

			if(!$mail->send()) {
				$errorMessages[] = 'We could not send you an email, please try again.';
				$formValid = false;	
			}
		} else {
			$errorMessages[] = 'We could not save the email, please try again.';
			$formValid = false;			
		}
	}
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Nolali - The Creative</title>
<meta name="description" content="Affordable web design, development and hosting solutions for SME's and small business...">
<meta name="keywords" content="design, web design, web development, hosting, email, packages, affordable, prices">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="icon" href="/favicon.ico?v=2" />

<!-- BOOTSTRAP -->
<link rel="stylesheet" href="/css/bootstrap.min.css">

<!-- Elegant Icons -->
<link rel="stylesheet" href="/assets/elegant-icons/style.css">
<!--[if lte IE 7]><script src="/assets/elegant-icons/lte-ie7.js"></script><![endif]-->

<!-- CUSTOM STYLESHEETS -->
<link rel="stylesheet" href="/css/styles.css">
<link rel="stylesheet" href="/css/responsive.css">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>
<body>
<?php require_once 'header.php'; ?>
<!-- =========================
     SECTION 9 - CONTACT US  
============================== -->
<section class="contact-us" id="enquiry">
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h3 class="heading">Need any help? Contact us now!</h3>
			<!-- EXPANDED CONTACT FORM -->
			<div>
				<!-- FORM -->
				<form class="contact-form" id="contactForm" role="form" action="/contacts#enquiry" method="post">
					<!-- IF MAIL SENT SUCCESSFULLY -->
					<?php if(isset($success)) { ?>
					<h6 class="success">
						<span class="olored-text icon_check"></span> Thank you , <b><?php echo trim($_POST['enquiry_name']); ?></b>, Your message has been sent successfully. 
					</h6>
					<?php } ?>
					<!-- IF MAIL SENDING UNSUCCESSFULL -->
					<?php if(isset($errorMessages) && count($errorMessages) != 0) { ?>
					<h6 class="error">
						<?php for($i = 0; $i < count($errorMessages); $i++) { ?>
							<span class="colored-text icon_error-circle_alt"></span><?php echo $errorMessages[$i]; ?> <br />
						<?php } ?>
					</h6>
					<?php } ?>
					<div class="field-wrapper col-md-6">
						<input class="form-control input-box" id="enquiry_name" type="text" name="enquiry_name" placeholder="Your Full Name">
					</div>
					<div class="field-wrapper col-md-6">
						<input class="form-control input-box" id="enquiry_email" type="email" name="enquiry_email" placeholder="Your Email Address">
					</div>
					
					<div class="field-wrapper col-md-12">
						<input class="form-control input-box" id="enquiry_subject" type="text" name="enquiry_subject" placeholder="Subject">
					</div>
					
					<div class="field-wrapper col-md-12">
						<textarea class="form-control textarea-box" id="enquiry_message" rows="7" name="enquiry_message" placeholder="Your Message"></textarea>
					</div>
					
					<button class="btn standard-button" type="button" id="submitForm" name="submitForm" onclick="submitValidForm(); return false;" data-style="expand-left">Send Message</button>
				</form>
				<!-- /END FORM -->
			</div>
			
		</div>
	</div>
	
</div>

</section>
<?php require_once 'footer.php'; ?>
<script type="text/javascript">
// makes sure the whole site is loaded
jQuery(window).load(function() {

	$('#submitForm').click(function() {
		$( "#contactForm" ).submit();
	});

})
</script>
</body>
</html>