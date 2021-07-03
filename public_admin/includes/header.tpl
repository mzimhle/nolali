<div id="header">
    <!-- Start Heading -->
        
    <div id="heading">
        <div id="ct_logo">

        </div>
       
    </div><!-- End Heading -->
	 {if isset($admin)}
    <!-- Start Top Nav -->
    <div id="topnav"> 
            <ul>
                <li><a href="/" title="Home" {if $page eq 'default.php' or $page eq ''} class="active"{/if}>Home</a></li>				
				<li><a href="/campaign/" title="Campaign" {if $page eq 'campaign'} class="active"{/if}>Campaign</a></li>
				<li><a href="/products/" title="Products" {if $page eq 'products'} class="active"{/if}>Products</a></li>
				<li><a href="/website/" title="Website" {if $page eq 'website'} class="active"{/if}>Website</a></li>
            </ul>
    </div><!-- End Top Nav -->
  <div class="clearer"><!-- --></div>
  {/if}
</div><!--header-->
{if isset($admin)}
    <div class="logged_in">
        <ul>
            <li><a href="/logout.php" title="Logout">Logout</a></li>
        </ul>
    </div><!--logged_in-->
	{/if}
  	<br />