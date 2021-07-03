<div id="header">
	<div id="logo">
		<h1><a href="/admin/">{$domainData.campaign_company} Admin</a></h1>
	</div>
		{if isset($userData)}
		<span class="top_header_links"><a href="#">{$userData.administrator_name} {$userData.administrator_surname} </a> | <a href="/admin/logout.php">logout</a></span>
		{/if}
	<div class="clr"></div>
</div>