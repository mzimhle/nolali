<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		<title>{$domainData.campaign_company} | Login</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			<div class="content">
				<div class="col">
					<h2>{$domainData.campaign_company} Admin Login</h2>
					<form id="loginForm" name="loginForm" method="post" target="" action="login.php">
						<div>Username:</div><br />
						<input name="username" type="text" id="username" size="35" maxlength="100" value="" /><br /><br />						
						<div>Password:</div><br />
						<input name="password" type="password" id="password" size="35" maxlength="100" value="" />						
						<div class="clr"></div><br />			
						<a class="link" href="#" onclick="document.forms.loginForm.submit();">LOGIN</a>
						<br /><br /><span class="error">{$message}</span><br />
					</form>
				</div>					
				<div class="clr"></div>
			</div>
			{include_php file='includes/footer.php'}
		</div>
	</body>
</html>