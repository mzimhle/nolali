<?php
/* Smarty version 3.1.34-dev-7, created on 2022-09-05 19:28:04
  from 'C:\sites\nolali.loc\public_admin\login.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_631631a4ef65f4_42195299',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2bda26e6c6e974b33aff772a7eecb149384d21e2' => 
    array (
      0 => 'C:\\sites\\nolali.loc\\public_admin\\login.tpl',
      1 => 1661245946,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_631631a4ef65f4_42195299 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php include_once ('C:\sites\nolali.loc\public_admin\includes\meta.php');?>

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
		<?php if (isset($_smarty_tpl->tpl_vars['message']->value)) {?><div class="alert alert-danger" role="alert"><strong><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</strong></div><?php }?>
        <button type="submit" class="btn btn-primary btn-block btn-signin">Log in</button>
		</form>
      </div><!-- signin-box -->
    </div><!-- signin-wrapper -->
    <?php echo '<script'; ?>
 src="/library/javascript/jquery.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/library/javascript/popper.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/library/javascript/bootstrap.js"><?php echo '</script'; ?>
>
  </body>
</html>
<?php }
}
