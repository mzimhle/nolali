<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	{include_php file="{$DOCUMENTROOT}/includes/meta.php"}
  </head>
  <body>
    <div class="signin-wrapper">
      <div class="signin-box">
        <h2 class="slim-logo">
			<img src="/images/logo.png?v=1" class="center" />
		</h2>
        <h2 class="signin-title-primary">Hello Administrator!</h2>
        <h3 class="signin-title-secondary">Sign in to continue.</h3>
		<form method="POST" action="login.php">
        <div class="form-group">
          <input type="text" name="account_user" id="account_user" class="form-control" placeholder="Enter your username">
        </div><!-- form-group -->
        <div class="form-group">
          <input type="password" name="account_password" id="account_password" class="form-control" placeholder="Enter your password">
        </div><!-- form-group -->
		{if isset($message)}<div class="alert alert-danger" role="alert"><strong>{$message}</strong></div>{/if}
        <button type="submit" class="btn btn-primary btn-block btn-signin">Log in</button>
		</form>
      </div><!-- signin-box -->
    </div><!-- signin-wrapper -->
    <script src="/library/javascript/jquery.js"></script>
    <script src="/library/javascript/popper.js"></script>
    <script src="/library/javascript/bootstrap.js"></script>
  </body>
</html>
