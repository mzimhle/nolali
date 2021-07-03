<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}
		<title>{$domainData.campaign_company} | Admin</title>
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="linebreak"></p>			
			<div id="main">
				{if isset($level1)}
				<div class="col">
					{section name=id loop=$level1}
					<div class="article">
						<h4><a href="/admin/{$level1[id]}/">{$level1[id]|capitalize}</a></h4>
						<p class="short">Manage {$level1[id]} section.<a href="/admin/{$level1[id]}/">&raquo;</a></p>
					</div>
					{/section}					
				</div>
				{/if}
				{if isset($level2)}
				<div class="col">
					{section name=id loop=$level2}
					<div class="article">
						<h4><a href="/admin/{$level2[id]}/">{$level2[id]|capitalize}</a></h4>
						<p class="short">Manage {$level2[id]} section.<a href="/admin/{$level2[id]}/">&raquo;</a></p>
					</div>
					{/section}						
				</div>
				{/if}
				{if isset($level3)}
				<div class="col">
					{section name=id loop=$level3}
					<div class="article">
						<h4><a href="/admin/{$level3[id]}/">{$level3[id]|capitalize}</a></h4>
						<p class="short">Manage {$level3[id]} section.<a href="/admin/{$level3[id]}/">&raquo;</a></p>
					</div>
					{/section}					
				</div>			
				{/if}	
				{if isset($level4)}
				<div class="col">
					{section name=id loop=$level4}
					<div class="article">
						<h4><a href="/admin/{$level4[id]}/">{$level4[id]|capitalize}</a></h4>
						<p class="short">Manage {$level4[id]} section.<a href="/admin/{$level4[id]}/">&raquo;</a></p>
					</div>
					{/section}					
				</div>			
				{/if}				
			</div>
			{include_php file='includes/footer.php'}
		</div>
	</body>
</html>