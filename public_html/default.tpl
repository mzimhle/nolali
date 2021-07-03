<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Business Lounge - Tenders, Trade Leads, Business Listings and Jobs</title>
<meta name="keywords" content="business, tenders, business listings, entrepreneurs, jobs">
<meta name="description" content="Business Lounge offers business opportunities to corporates, entrepreneurs and SME’s from South Africa. Covering tenders, trade leads, business listings, jobs and more prospects to grow your business...">          
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="21 days">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta property="og:title" content="Business Lounge"> 
<meta property="og:image" content="http://www.bizlounge.co.za/images/logo.png"> 
<meta property="og:url" content="http://www.bizlounge.co.za">
<meta property="og:site_name" content="Business Lounge">
<meta property="og:type" content="website">
<meta property="og:description" content="Business Lounge offers business opportunities to corporates, entrepreneurs and SME’s from South Africa. Covering tenders, trade leads, business listings, jobs and more prospects to grow your business.">
<link rel="icon" type="image/x-icon" href="/favicon.ico?ver=2" />
{include_php file='includes/css.php'}
</head>
<body>
{include_php file='includes/header.php'}
{include_php file='includes/menu.php'}
<section class="container">
	<div class="row">
    	<div class="col-xs-12 col-md-3">
        	<!-- /// short list box /// -->
			<div class="tenderbox eachbox rightdarkborder">		
				<div class="titles">
					<h1>Job Short list</h1>
				</div>				
				<div class="infolist cf">
					<p>Make a list of all jobs you are interested in to view/apply for later on. If you are logged in, they will be available event after you log out and back in at a later stage.</p>
					<ul class="remove_pad_style" id="shortlist_ul">
						{foreach from=$shortlistdata item=item name=fooshort}
							<li id="short_{$item.job_code}">
								<a href="#" onclick="removeShortlistjob('{$item.job_code}'); return false;" alt="Remove job" title="Remove job"><span class="fa fa-cog"></span></a>
								<a href="/job/{$item.job_url}/{$item.job_code}" alt="Shortlisted job - {$item.job_title}" title="Shortlisted job - {$item.job_title}">{$item.job_title}</a>
							</li>
						{foreachelse}
						<span class="redhighlight">There are currently no shortlisted jobs.</span>
						{/foreach}
					</ul>										
				</div>				
			</div>
			<div class="newsbox eachbox rightdarkborder">
				<div class="titles stitle">
					<h2>Filter</h2>
				</div>
				<div class="bigform bisform">
					<form action="/" method="POST" role="form" name="formFilter" id="formFilter">
					   <label>By Title:</label>
					   <input type="text" class="form-control" id="filter_title" name="filter_title" value="{$filters.filters_title}" />
					   <label>By Type:</label><br />
					   <input type="checkbox" class="form-control" name="filter_type[]" value="permanent" {if isset($filters.filters_type) and in_array('permanent', $filters.filters_type)} checked {/if} />Permanent
					   <div class="clearboth"></div>
					   <input type="checkbox" class="form-control" name="filter_type[]" value="contract" {if isset($filters.filters_type) and in_array('contract', $filters.filters_type)} checked {/if} />Contract
					   <div class="clearboth"></div>
					   <input type="checkbox" class="form-control" name="filter_type[]" value="temp" {if isset($filters.filters_type) and in_array('temp', $filters.filters_type)} checked {/if} />Temporary
					   <div class="clearboth"></div>					   
					   <input type="checkbox" class="form-control" name="filter_type[]" value="parttime" {if isset($filters.filters_type) and in_array('parttime', $filters.filters_type)} checked {/if} />Part Time
					   <div class="clearboth"></div>
					   <input type="checkbox" class="form-control" name="filter_type[]" value="graduate" {if isset($filters.filters_type) and in_array('graduate', $filters.filters_type)} checked {/if} />Graduate
					   <div class="clearboth"></div>
					   <input type="checkbox" class="form-control" name="filter_type[]" value="casual" {if isset($filters.filters_type) and in_array('casual', $filters.filters_type)} checked {/if} />Casual
					   <div class="clearboth"></div>
					   <input type="checkbox" class="form-control" name="filter_type[]" value="internship" {if isset($filters.filters_type) and in_array('internship', $filters.filters_type)} checked {/if} />Internship
					   <div class="clearboth"></div>
					   <label>By Province:</label>
					   <select class="form-control" id="filter_province" name="filter_province">
							<option value=""> --- </option>
							<option {if $filters.filters_province eq 'Eastern Cape'} selected {/if} value="Eastern Cape">Eastern Cape</option>
							<option {if $filters.filters_province eq 'Free State'} selected {/if}  value="Free State">Free State</option>
							<option {if $filters.filters_province eq 'Gauteng'} selected {/if} value="Gauteng">Gauteng</option>
							<option {if $filters.filters_province eq 'KwaZulu-Natal'} selected {/if} value="KwaZulu-Natal">KwaZulu-Natal</option>
							<option {if $filters.filters_province eq 'Limpopo'} selected {/if} value="Limpopo">Limpopo</option>
							<option {if $filters.filters_province eq 'Mpumalanga'} selected {/if} value="Mpumalanga">Mpumalanga</option>
							<option {if $filters.filters_province eq 'North West'} selected {/if} value="North West">North West</option>
							<option {if $filters.filters_province eq 'Northern Cape'} selected {/if} value="Northern Cape">Northern Cape</option>
							<option {if $filters.filters_province eq 'Western Cape'} selected {/if} value="Western Cape">Western Cape</option>
					   </select>
					   <div class="clearboth"></div>
					   <label>By Category:</label>
					   <select class="form-control" id="filter_category" name="filter_category">
							<option value=""> --- </option>
							{html_options options=$categorypairs selected=$filters.filters_category}
					   </select>					   
					   <div class="clearboth"></div>
					   <button onclick="submitFilter();" class="btn" name="btnFilter" id="btnFilter">Filter</button>
					   <button class="btn btn-md btn-save fr" onclick="clearFilter();" name="btnFilter">Clear</button>
					</form>
				</div>
			</div>
			{include_php file='includes/ad_long_horizontal.php'}
        </div>	
    	<div class="col-xs-12 col-md-5 db-gutter-right">
			<!-- /// TENDER BOX /// -->
			<div class="tenderbox eachbox">
				<p style="font-size: 14px !important;">There are <span class="redhighlight">{$paginator->totalItemCount}</span> jobs in <span class="redhighlight">{$paginator->pageCount}</span> pages that have been found. {if isset($filters.filters_title)}Searching for <i><span class="redhighlight">"{$filters.filters_title}"</span></i>.{/if}{if isset($filters.category.category_name)}Category being searched for is the <i><span class="redhighlight">"{$filters.category.category_name}</span></i>.{/if}{if isset($filters.type)}Types being searched for <i><span class="redhighlight">"{$filters.type|capitalize}"</span></i>. {/if}{if isset($filters.filters_province)}Province searched in is <i><span class="redhighlight">"{$filters.filters_province|capitalize}"</span></i>.{/if}</p>
				{capture name="pagination"}				
				{if $paginator->firstPageInRange neq $paginator->lastPageInRange}
				<div class="pagibox">
					<ul class="pagination pagination-sm">
						{if $paginator->current gt 1 }
						  <li><a href="/jobs/{$paginator->previous}"><span class="fa fa-chevron-left"></span></a></li>
						  {/if}
						  {foreach from=$paginator->pagesInRange item=page}
						  <li {if $page eq $paginator->current} class="active" {/if}><a href="/jobs/{$page}">{$page}</a></li>
						  {/foreach}
						  {if $paginator->current lt $paginator->lastPageInRange}
						  <li><a href="/jobs/{$paginator->next}"><span class="fa fa-chevron-right"></span></a></li>
						  {/if}
					</ul>
				</div>
				{/if}
				{/capture}
				{$smarty.capture.pagination|replace:'?&amp;':'?'}
				{foreach from=$jobItems item=item name=foo}
				<dl class="cf {if $smarty.foreach.foo.index is even}dldark{else}dllight{/if}">
					<dt><a href="/job/{$item.job_url}/{$item.job_code}">{$item.job_title}</a></dt>
					<dd>{$item.job_page|normal_text|strip_tags|truncate:150} in {$item.job_area}</dd>
					<dd><span class="bluehighlight">{$item.job_type|capitalize}</span> - <b>{$item.category_name}</b></dd>
					<dd class="iconbox">
						<span class="minicons pdate" data-toggle="tooltip" title="Date Added">{$item.job_added|date_format}</span>						
						<span class="fl" data-toggle="tooltip" title="Facebook Share">
							<a href='javascript:void(0);' onclick="openWindow_fb_share('http://www.facebook.com/share.php?u=http://www.willowvine.co.za/job/{$item.job_url}/{$item.job_code}');" title="Share this job on facebook: {$item.job_title|normal_text}">
							<img src="/images/facebook_share_up.png" title="Share this tender on facebook: {$item.job_title|normal_text}" />
							</a>							
						</span>
						<span class="fl" style="margin-left: 5px;" data-toggle="tooltip" title="Twitter Share">
							<a href="https://twitter.com/share" class="twitter-share-button" data-text="@willowvine job - {$item.job_title|normal_text}" data-related="willowvine" data-count="none">Twitter Share</a>
							{literal}
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
							{/literal}
						</span>
						<span class="fl" style="margin-left: 5px;" data-toggle="tooltip" title="Email to my friend">
						<a data-related="willowvine" data-count="none" class="small_blue_bg_dark_btn fl" title="Share job with a friend" alt="Share job with a friend" href='#' onclick="showShare('{$item.job_title|normal_text} in {$item.areapost_name|trim}', '{$item.job_code}'); return false;">
							<span id="share_job">Share with a friend</span>								
						</a>
						</span>						
						<span class="fl{if in_array($item.job_code, $shortlist)} hide{/if}" style="margin-left: 5px;" data-toggle="tooltip" title="Add to my shortlist" id="shortjob_{$item.job_code}">
							<a data-related="willowvine" data-count="none" class="small_blue_bg_dark_btn fl" title="Shortlist job" alt="Shortlist job" href='#' onclick="shortlistJob('{$item.job_code}', '{$item.job_title}', '/job/{$item.job_url}/{$item.job_code}'); return false;">
								<span id="share_job">Shortlist</span>								
							</a>
						</span>											
					</dd>					
				</dl>
				{/foreach}
			</div>
			<div class="clearboth"></div>
			{$smarty.capture.pagination}
		</div>
        <div class="col-xs-12 col-md-4 no-gutter-left">
			<div class="eachbox visible-md visible-lg">
				<a href="http://www.willow-nettica.com/" target="_blank"><img src="/images/willow_ad.jpg" title="Willow-Nettica" alt="Willow-Nettica"></a>
			</div>
			{include_php file='includes/register.php'}			
        </div>	
    </div>
</section>
{include_php file='includes/footer.php'}
</body>
</html>