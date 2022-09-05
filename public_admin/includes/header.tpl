<div class="slim-header">
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
            {if isset($activeEntity)}
		  <span>{$activeEntity.account_name} - {$activeEntity.account_type|lower|ucfirst}{if isset($activeEntity)} ( {$activeEntity.entity_name} ){/if}</span>
            {else}          
		  <span>{$activeAccount.account_name} - {$activeAccount.account_type|lower|ucfirst}{if isset($activeEntity)} ( {$activeEntity.entity_name} ){/if}</span>
           {/if}
           <i class="fa fa-angle-down"></i>
		</a>
       
		<div class="dropdown-menu dropdown-menu-right">
		  <nav class="nav">
            <a href="/account/details.php?id={$activeAccount.account_id}" class="nav-link"><i class="icon ion-person"></i> Edit Account</a>
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
	  <li class="nav-item {if $currentPage eq ''}active{/if}">
		<a class="nav-link" href="/">
		  <i class="icon ion-ios-home-outline"></i>
		  <span>Dashboard</span>
		</a>
	  </li>
      {if $activeAccount.account_type eq 'SUPER' && !isset($activeEntity)}
	  <li class="nav-item {if $currentPage eq 'account'}active{/if}">
		<a class="nav-link" href="/account/">
		  <i class="icon ion-ios-analytics-outline"></i>
		  <span>Account</span>
		</a>
	  </li>      
      {/if}      
	  {if isset($activeAccount) && !isset($activeEntity)}
	  <li class="nav-item {if $currentPage eq 'entity'}active{/if}">
		<a class="nav-link" href="/entity/">
		  <i class="icon ion-ios-analytics-outline"></i>
		  <span>Entity</span>
		</a>
	  </li>
      <li class="nav-item {if $currentPage eq 'product'}active{/if}">
        <a class="nav-link" href="/product/">
		  <i class="icon ion-ios-chatboxes-outline"></i>
		  <span>Product</span>
		</a>
	  </li>       
      <li class="nav-item {if $currentPage eq 'invoice'}active{/if}">
        <a class="nav-link" href="/invoice/">
		  <i class="icon ion-ios-chatboxes-outline"></i>
		  <span>Invoice</span>
		</a>	
	  </li> 
	  <li class="nav-item {if $currentPage eq 'template'}active{/if}">
		<a class="nav-link" href="/template/">
		  <i class="icon ion-ios-analytics-outline"></i>
		  <span>Template</span>
		</a>
	  </li>
      {/if}
      {if isset($activeAccount) && isset($activeEntity)}
	  <li class="nav-item {if $currentPage eq 'template'}active{/if}">
		<a class="nav-link" href="/template/">
		  <i class="icon ion-ios-analytics-outline"></i>
		  <span>Template</span>
		</a>
	  </li>      
      <li class="nav-item {if $currentPage eq 'product'}active{/if}">
        <a class="nav-link" href="/product/">
		  <i class="icon ion-ios-chatboxes-outline"></i>
		  <span>Product</span>
		</a>
	  </li>      
      <li class="nav-item {if $currentPage eq 'invoice'}active{/if}">
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
      {/if}      
	</ul>
  </div><!-- container -->
</div><!-- slim-navbar -->
