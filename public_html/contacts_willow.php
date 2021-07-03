<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

require_once 'config/database.php';
require_once 'config/smarty.php';
require_once 'global_functions.php';

/* Check posted data. */
if(count($_POST) > 1) {
	
	require_once 'class/enquiry.php';
	
	$errorMessages		= array();
	$data 				= array();
	$formValid			= true;
	$success			= NULL;
	$areaByName			= NULL;
	$enquiryObject		= new class_enquiry();
	
	if(isset($_POST['enquiry_comments']) && trim($_POST['enquiry_comments']) == '') {
		$errorMessages[] = 'Please add a comment.';
		$formValid = false;		
	}
		
	if(isset($_POST['enquiry_category']) && trim($_POST['enquiry_category']) == '') {
		$errorMessages[] = 'Please choose a category.';
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
		$data['enquiry_comments']			= trim($_POST['enquiry_comments']);
		$data['enquiry_reference']			= $enquiryObject->createReference();
		
		$success  = $enquiryObject->insert($data);
		
		if($success) {
			require('Zend/Mail.php');
			
			$mail = new Zend_Mail();
			
			$smarty->assign('enquiryData', $data);	
			
			$message = $smarty->fetch('templates/inquiry/enquiry.html');
			$mail->setFrom('info@willow-nettica.co.za', 'Willow Nettica Enquiry'); //EDIT!!											
			$mail->addTo($data['enquiry_email']);
			$mail->addTo('info@willow-nettica.co.za');
			$mail->setSubject('Willow Nettica Enquiry: '.trim($_POST['enquiry_category']));
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

	/* if we are here there are errors. */	
	$errors = count($errorMessages) > 0 ? implode('<br />', $errorMessages) : '';	
}	

$title = 'Willow Nettica - Get in touch with us and contact us';
$keywords = 'web, design, development, front-end, branding, content management, bulk email, bulk sms, html5, responsive';
$description = 'Willow-Nettica can be contacted by filling in the contact form below, we will then get back to you as soon as possible.';
include 'header.php';
?>
<!--
<link rel="stylesheet" type="text/css" href="/library/javascript/realperson/jquery.realperson.css"> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="/library/javascript/realperson/jquery.realperson.js"></script>
<script type="text/javascript">
	$(function() {
		$('#defaultReal').realperson();
	});
</script>
-->
<header class="conthead">
    <div class="topbar">
        <div class="row wrap">
            <div class="small-6 large-6 columns logobox"><a href="/"><img src="/img/logo_big.png" alt="Willow Nettica" alt="Willow Nettica" /></a></div>
            <nav class="small-6 large-6 columns topnav cl-effect-5">
                <ul class="inline-list linkside right">
                    <li><a data-menuanchor="home" href="/" class="homebtn"><span data-hover="Home">Home</span></a></li>
                    <li><a href="/services" class="servbtn"><span data-hover="Services">Services</span></a></li>
                    <li><a href="/portfolio" class="portbtn"><span data-hover="Portfolio">Portfolio</span></a></li>
                    <li><a href="/contacts" class="contbtn"><span data-hover="Contacts">Contacts</span></a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<section>
        <div class="htxt">
            <div class="row wrap">
            	<h1>Contact Details</h1>
            	<div class="small-12 medium-4 columns">
                    <div class="cicons locico">76 Sir Lowry Rd,<br />Cape Town,</div>
                	<div class="cicons">+27 73 564 0764</div>
               	</div>
               	<div class="small-12 medium-4 columns" style="text-align: center;">
					<div class="center small-left" style="margin: auto; width: 120px">
                    	<div class="cicons fbico"><a href="https://www.facebook.com/willownettica" target="_blank">Facebook</a></div>
                    	<div class="cicons twico"><a href="https://twitter.com/willownettica" target="_blank">Twitter</a></div>
                    </div>
                </div>
                <div class="small-12 medium-4 columns">
                	<div class="right small-left">
                		<div class="cicons inico"><a href="http://linkd.in/1bMcRiA" target="_blank">LinkedIn</a></div>
                    	<div class="cicons gico"><a href="https://plus.google.com/b/100325846078534250868/100325846078534250868/posts" target="_blank">Google +</a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="redbox">
            <div class="hstxt">
                <div class="row wrap">
                    <h2 class="white">Contact Us</h2>
                    <p class="formtxt white">Complete the form below to send us a quick email.</p>
					<?php 
						if(isset($formValid)) {
							if($formValid) {
								echo '<br /><p class="formtxt white">Thank you. Your enquiry was sent successfully, we will get back to you as soon as possible. This is your reference: <b>'.$data['enquiry_reference'].'</b></p>';
							} else {
								echo '<br /><p class="formtxt red">Errors! There were some errors in your enquiry, see below:</p>';
								echo '<br /><p class="formtxt red">'.$errors.'</p>';
							}
						}
					?>
                    <form id="contactForm" name="contactForm" action="/contacts" method="post">
                        <div class="small-12 medium-6 columns">
                            <input type="text" name="enquiry_name" id="enquiry_name" value="<?php if(isset($_POST['enquiry_name'])) {echo $_POST['enquiry_name'];} ?>" /><label>Enter your full name</label>
                            <input type="text" name="enquiry_email" id="enquiry_email" value="<?php if(isset($_POST['enquiry_email'])) {echo $_POST['enquiry_email'];} ?>" /><label>Enter your email address</label>
                            <div class="selectb" >
                                <select id="enquiry_category" name="enquiry_category">
                                    <option value="">Select Topic</option>
                                    <option <?php if(isset($_POST['enquiry_category']) && trim($_POST['enquiry_category']) == 'Support') {echo 'selected';} ?> value="Support">Support</option>
                                    <option <?php if(isset($_POST['enquiry_category']) && trim($_POST['enquiry_category']) == 'Get A Quote') {echo 'selected';} ?> value="Get A Quote">Get A Quote</option>
                                    <option <?php if(isset($_POST['enquiry_category']) && trim($_POST['enquiry_category']) == 'Design Query') {echo 'selected';} ?> value="Design Query">Design Query</option>
                                    <option <?php if(isset($_POST['enquiry_category']) && trim($_POST['enquiry_category']) == 'Just Saying Hi') {echo 'selected';} ?> value="Just Saying Hi">Just Saying Hi</option>
                                </select>
                            </div><label>Select inquiry type</label>
                        </div>
                        <div class="small-12 medium-6 columns">
                        	<textarea name="enquiry_comments" id="enquiry_comments"><?php if(isset($_POST['enquiry_comments'])) {echo $_POST['enquiry_comments'];} ?></textarea>
							<label>Message</label>
                        </div>
                        <div class="small-12 small-centered columns">
                        	<div class="allservbtn"><input type="submit" value="Send your message" /></div>
                        </div>
                    </form>                
                </div>
            </div>
        </div>
        <div class="lgreybox">
            <div class="map">
                <div data-interchange="[/imgmap.html, (small)], [/map.html, (medium)], [map.html, (large)]"></div>
            </div>
        </div>
<?php include 'footer.php'; ?>