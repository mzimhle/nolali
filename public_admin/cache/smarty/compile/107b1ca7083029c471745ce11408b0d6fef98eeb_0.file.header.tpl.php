<?php
/* Smarty version 3.1.34-dev-7, created on 2022-09-07 00:20:27
  from 'C:\sites\nolali.loc\public_admin\includes\header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_6317c7ab0d32e8_66320438',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '107b1ca7083029c471745ce11408b0d6fef98eeb' => 
    array (
      0 => 'C:\\sites\\nolali.loc\\public_admin\\includes\\header.tpl',
      1 => 1662413115,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6317c7ab0d32e8_66320438 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="slim-header">
  <div class="container">
	<div class="slim-header-left">
	  <h2 class="slim-logo">
		<a href="/">
			<img src="/images/header_logo.png" class="center" />
		</a>
	  </h2>
	</div><!-- slim-header-left -->
	<div class="slim-header-right">
	  <div class="dropdown dropdown-c">
		<a href="#" class="logged-user" data-toggle="dropdown">
            <?php if (isset($_smarty_tpl->tpl_vars['activeEntity']->value)) {?>
		  <span><?php echo $_smarty_tpl->tpl_vars['activeEntity']->value['account_name'];?>
 - <?php echo ucfirst(mb_strtolower($_smarty_tpl->tpl_vars['activeEntity']->value['account_type'], 'UTF-8'));
if (isset($_smarty_tpl->tpl_vars['activeEntity']->value)) {?> ( <?php echo $_smarty_tpl->tpl_vars['activeEntity']->value['entity_name'];?>
 )<?php }?></span>
            <?php } else { ?>          
		  <span><?php echo $_smarty_tpl->tpl_vars['activeAccount']->value['account_name'];?>
 - <?php echo ucfirst(mb_strtolower($_smarty_tpl->tpl_vars['activeAccount']->value['account_type'], 'UTF-8'));
if (isset($_smarty_tpl->tpl_vars['activeEntity']->value)) {?> ( <?php echo $_smarty_tpl->tpl_vars['activeEntity']->value['entity_name'];?>
 )<?php }?></span>
           <?php }?>
           <i class="fa fa-angle-down"></i>
		</a>
       
		<div class="dropdown-menu dropdown-menu-right">
		  <nav class="nav">
            <a href="/account/details.php?id=<?php echo $_smarty_tpl->tpl_vars['activeAccount']->value['account_id'];?>
" class="nav-link"><i class="icon ion-person"></i> Edit Account</a>
			<a href="/logout.php" class="nav-link"><i class="icon ion-forward"></i> Log Out</a>
		  </nav>
		</div><!-- dropdown-menu -->
	  </div><!-- dropdown -->
	</div><!-- header-right -->
  </div><!-- container -->
</div><!-- slim-header -->
<div class="slim-navbar">
  <div class="container">
	<ul class="nav">
	  <li class="nav-item <?php if ($_smarty_tpl->tpl_vars['currentPage']->value == '') {?>active<?php }?>">
		<a class="nav-link" href="/">
		  <i class="icon ion-ios-home-outline"></i>
		  <span>Dashboard</span>
		</a>
	  </li>
      <?php if ($_smarty_tpl->tpl_vars['activeAccount']->value['account_type'] == 'SUPER' && !isset($_smarty_tpl->tpl_vars['activeEntity']->value)) {?>
	  <li class="nav-item <?php if ($_smarty_tpl->tpl_vars['currentPage']->value == 'account') {?>active<?php }?>">
		<a class="nav-link" href="/account/">
		  <i class="icon ion-ios-analytics-outline"></i>
		  <span>Account</span>
		</a>
	  </li>      
      <?php }?>      
	  <?php if (isset($_smarty_tpl->tpl_vars['activeAccount']->value) && !isset($_smarty_tpl->tpl_vars['activeEntity']->value)) {?>
	  <li class="nav-item <?php if ($_smarty_tpl->tpl_vars['currentPage']->value == 'entity') {?>active<?php }?>">
		<a class="nav-link" href="/entity/">
		  <i class="icon ion-ios-analytics-outline"></i>
		  <span>Entity</span>
		</a>
	  </li>
      <li class="nav-item <?php if ($_smarty_tpl->tpl_vars['currentPage']->value == 'product') {?>active<?php }?>">
        <a class="nav-link" href="/product/">
		  <i class="icon ion-ios-chatboxes-outline"></i>
		  <span>Product</span>
		</a>
	  </li>       
      <li class="nav-item <?php if ($_smarty_tpl->tpl_vars['currentPage']->value == 'invoice') {?>active<?php }?>">
        <a class="nav-link" href="/invoice/">
		  <i class="icon ion-ios-chatboxes-outline"></i>
		  <span>Invoice</span>
		</a>	
	  </li> 
	  <li class="nav-item <?php if ($_smarty_tpl->tpl_vars['currentPage']->value == 'template') {?>active<?php }?>">
		<a class="nav-link" href="/template/">
		  <i class="icon ion-ios-analytics-outline"></i>
		  <span>Template</span>
		</a>
	  </li>
      <?php }?>
      <?php if (isset($_smarty_tpl->tpl_vars['activeAccount']->value) && isset($_smarty_tpl->tpl_vars['activeEntity']->value)) {?>
	  <li class="nav-item <?php if ($_smarty_tpl->tpl_vars['currentPage']->value == 'template') {?>active<?php }?>">
		<a class="nav-link" href="/template/">
		  <i class="icon ion-ios-analytics-outline"></i>
		  <span>Template</span>
		</a>
	  </li>      
      <li class="nav-item <?php if ($_smarty_tpl->tpl_vars['currentPage']->value == 'product') {?>active<?php }?>">
        <a class="nav-link" href="/product/">
		  <i class="icon ion-ios-chatboxes-outline"></i>
		  <span>Product</span>
		</a>
	  </li>      
      <li class="nav-item <?php if ($_smarty_tpl->tpl_vars['currentPage']->value == 'invoice') {?>active<?php }?>">
        <a class="nav-link" href="/invoice/">
		  <i class="icon ion-ios-chatboxes-outline"></i>
		  <span>Invoice</span>
		</a>	
	  </li>
    <li class="nav-item with-sub ">
    <a class="nav-link" href="#" data-toggle="dropdown">
      <i class="icon ion-ios-chatboxes-outline"></i>
      <span>Content</span>
    </a>
    <div class="sub-item">
      <ul>
        <li><a href="/content/article/">Article</a></li>
        <li><a href="/content/announcement/">Announcement</a></li>
        <li><a href="/content/event/">Event</a></li>
        <li><a href="/content/gallery/">Gallery</a></li>
        <li><a href="/content/news/">News</a></li>
      </ul>
    </div>	
    </li>  
    <li class="nav-item with-sub ">
    <a class="nav-link" href="#" data-toggle="dropdown">
      <i class="icon ion-ios-chatboxes-outline"></i>
      <span>Commodity</span>
    </a>
    <div class="sub-item">
      <ul>
        <li><a href="/commodity/booking/">Booking</a></li>
        <li><a href="/commodity/catalog/">Catalog</a></li>
        <li><a href="/commodity/enquiry/">Enquiries</a></li>
        <li><a href="/commodity/participant/">Participant</a></li>
        <li><a href="/commodity/bulk-sms/">Bulk SMS</a></li>
        <li><a href="/commodity/bulk-email/">Bulk Email</a></li>
      </ul>
    </div>	
    </li>     
      <?php }?>      
	</ul>
  </div><!-- container -->
</div><!-- slim-navbar -->
<?php }
}
