<?php /* Smarty version 2.6.20, created on 2015-06-18 23:10:20
         compiled from includes/header.tpl */ ?>
<div id="header">
    <!-- Start Heading -->
        
    <div id="heading">
        <div id="ct_logo">

        </div>
       
    </div><!-- End Heading -->
	 <?php if (isset ( $this->_tpl_vars['admin'] )): ?>
    <!-- Start Top Nav -->
    <div id="topnav"> 
            <ul>
                <li><a href="/" title="Home" <?php if ($this->_tpl_vars['page'] == 'default.php' || $this->_tpl_vars['page'] == ''): ?> class="active"<?php endif; ?>>Home</a></li>				
				<li><a href="/campaign/" title="Campaign" <?php if ($this->_tpl_vars['page'] == 'campaign'): ?> class="active"<?php endif; ?>>Campaign</a></li>
				<li><a href="/products/" title="Products" <?php if ($this->_tpl_vars['page'] == 'products'): ?> class="active"<?php endif; ?>>Products</a></li>
				<li><a href="/website/" title="Website" <?php if ($this->_tpl_vars['page'] == 'website'): ?> class="active"<?php endif; ?>>Website</a></li>
            </ul>
    </div><!-- End Top Nav -->
  <div class="clearer"><!-- --></div>
  <?php endif; ?>
</div><!--header-->
<?php if (isset ( $this->_tpl_vars['admin'] )): ?>
    <div class="logged_in">
        <ul>
            <li><a href="/logout.php" title="Logout">Logout</a></li>
        </ul>
    </div><!--logged_in-->
	<?php endif; ?>
  	<br />