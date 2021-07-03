<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nolali - The Creative</title>
{include_php file='includes/css.php'}
{include_php file='includes/javascript.php'} 
</head>
<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content Section -->
  <div id="content">
    {include_php file='includes/header.php'}
  	<div id="breadcrumb">
        <ul>
            <li><a href="/" title="Home">Home</a></li>
			<li><a href="/website/" title="Website">Website</a></li>
        </ul>
	</div><!--breadcrumb-->  
  <div class="inner">  
   <h2>Campaign</h2>	

	<div class="section">
		Select campaign:
		<select id="campaign_code" name="campaign_code">
			<option value=""> ---- </option>
			{html_options options=$campaignPairs selected=$domainData.campaign_code}
		</select>
	</div>
	{if isset($domainData)}	   
  <div class="clearer"><!-- --></div>
  <h2>Campaign Administration Accounts</h2>	
  <div class="clearer"><!-- --></div>
  <div class="section">
  	<a href="/website/accounts/" title="Manage Accounts"><img src="/images/users.gif" alt="Manage Accounts" height="50" width="50" /></a>
  	<a href="/website/accounts/" title="Manage Accounts" class="title">Manage Accounts</a>
  </div>  
  <div class="clearer"><!-- --></div>
  <h2>Campaign Pages</h2>
  {if isset($level1)}
  {foreach from=$level1 item=item name=level1}
  <div class="section{if $smarty.foreach.level1.index neq '0'} mrg_left_50{/if}">
  	<a href="/website/{$item._product_page_link}/" title="{$item._product_name}"><img src="/images/users.gif" alt="{$item._product_name}" height="50" width="50" /></a>
  	<a href="/website/{$item._product_page_link}/" title="Manage {$item._product_page_link}" class="title">{$item._product_name}</a>
  </div> 
  {/foreach}
  {/if}
    <div class="clearer"><!-- --></div>   
  {if isset($level2)}
  {foreach from=$level2 item=item name=level2}
  <div class="section{if $smarty.foreach.level2.index neq '0'} mrg_left_50{/if}">
  	<a href="/website/{$item._product_page_link}/" title="{$item._product_name}"><img src="/images/users.gif" alt="{$item._product_name}" height="50" width="50" /></a>
  	<a href="/website/{$item._product_page_link}/" title="Manage {$item._product_page_link}" class="title">{$item._product_name}</a>
  </div> 
  {/foreach}
  {/if}
  <div class="clearer"><!-- --></div>   
  {if isset($level3)}
  {foreach from=$level3 item=item name=level3}
  <div class="section{if $smarty.foreach.level3.index neq '0'} mrg_left_50{/if}">
  	<a href="/website/{$item._product_page_link}/" title="{$item._product_name}"><img src="/images/users.gif" alt="{$item._product_name}" height="50" width="50" /></a>
  	<a href="/website/{$item._product_page_link}/" title="Manage {$item._product_page_link}" class="title">{$item._product_name}</a>
  </div> 
  {/foreach}
  {/if}  
  <div class="clearer"><!-- --></div> 
  {if isset($level4)}
  {foreach from=$level4 item=item name=level4}
  <div class="section{if $smarty.foreach.level4.index neq '0'} mrg_left_50{/if}">
  	<a href="/website/{$item._product_page_link}/" title="{$item._product_name}"><img src="/images/users.gif" alt="{$item._product_name}" height="50" width="50" /></a>
  	<a href="/website/{$item._product_page_link}/" title="Manage {$item._product_page_link}" class="title">{$item._product_name}</a>
  </div> 
  {/foreach}
  {/if}    
    </div><!--inner-->
	{/if}
  </div><!-- End Content Section -->
	
 {include_php file='includes/footer.php'}

{literal}
<script type="text/javascript">

$( document ).ready(function() {

	$('#campaign_code').change(function() {
	
		var campaigncode	= $('#campaign_code :selected').val();
		
		$.ajax({
			type: "GET",
			url: "default.php",
			data: "campaigncode="+campaigncode,
			dataType: "html",
			success: function(items){
				window.location.href = window.location.href;
			}
		});
		
	});
	
});

</script>
{/literal}
</div>
<!-- End Main Container -->
</body>
</html>
