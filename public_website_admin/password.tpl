<!DOCTYPE html><!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]--><!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]--><!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]--><!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]--><head>	<title>{$domainData.campaign_name} Management System</title>	<meta charset="utf-8">	<meta name="description" content="">	<meta name="viewport" content="width=device-width"><link rel="icon" type="image/x-icon" href="http://www.nolali.co.za/favicon.ico" /><link rel="icon" href="http://www.nolali.co.za/favicon.ico" type="image/x-icon">		{include_php file='includes/css.php'}</head><body class="account-bg"><div class="account-wrapper">	<div class="account-logo">		<a href="http://www.nolali.co.za/" target="_blank">			<img alt="Nolali - The Creative" src="http://{$domainData.campaign_domain_admin}/images/logo_light.png" width="200px" />		</a>	</div>    <div class="account-body">      <h3 class="account-body-title">{$domainData.campaign_name}</h3>      <h5 class="account-body-subtitle">Password recovery</h5>      <form class="form account-form" method="POST" action="/password.php">        <div class="form-group">          <input type="text" class="form-control" id="administrator_email" name="administrator_email" placeholder="Your Email" tabindex="1">        </div> <!-- /.form-group -->        <div class="form-group">          <button type="submit" class="btn btn-secondary btn-block btn-lg" tabindex="2">            Reset Password &nbsp; <i class="fa fa-refresh"></i>          </button>          {if isset($errormessage) && $errormessage neq ''}<br /><label for="administrator_email" class="placeholder error">{$errormessage}</label>{/if}		  {if isset($successmessage) && $successmessage neq ''}<br /><label for="administrator_email" class="placeholder success">{$successmessage}</label>{/if}		          </div> <!-- /.form-group -->        <div class="form-group">          <a href="/"><i class="fa fa-angle-double-left"></i> &nbsp;Back to Login</a>        </div> <!-- /.form-group -->      </form>    </div> <!-- /.account-body -->    <div class="account-footer">      <p>{$domainData.campaign_name} Management System</p>    </div> <!-- /.account-footer -->	  </div> <!-- /.account-wrapper -->{include_php file='includes/js.php'}</body></html>