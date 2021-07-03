<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<title>{$domainData.campaign_company} | Admin | Participants</title>
		{include_php file='includes/css.php'}
		{include_php file='includes/javascript.php'}	
	</head>
	<body>
		<div id="wrapper">
			{include_php file='includes/header.php'}
			{include_php file='includes/menu.php'}
			<p class="breadcrum">
				<a class="first" href="/admin/">Home</a> &raquo; 
				<a href="/admin/participants/">Participants</a> &raquo; 
				<a href="#">{if isset($participantData)}Edit participant{else}Add a participant{/if}</a>
			</p>
			<p class="linebreak"></p>
			<div id="main">
				<form id="detailsForm" name="detailsForm" action="/admin/participants/details.php{if isset($participantData)}?code={$participantData.participant_code}{/if}" method="post">
				<div class="col">
					<div class="article">
						<h4><a href="#" class="error">Name</a></h4>					
						<p class="short">
							<input type="text" name="participant_name" id="participant_name" value="{$participantData.participant_name}" size="32"/>
							{if isset($errorArray.participant_name)}<br /><em class="error">{$errorArray.participant_name}</em>{/if}
						</p>						
					</div>	
					<div class="article">
						<h4><a href="#" class="error">Email</a></h4>					
						<p class="short">
							<input type="text" name="participant_email" id="participant_email" value="{$participantData.participant_email}" size="32"/>
							{if isset($errorArray.participant_email)}<br /><em class="error">{$errorArray.participant_email}</em>{/if}
						</p>						
					</div>					
					<div class="article">
						<h4><a href="#" class="error">Area / City / Town</a></h4>					
						<p class="short">
							<input type="text" name="areapost_name" id="areapost_name" value="{$participantData.areapost_name}" size="32"/>				
							<input type="hidden" name="areapost_code" id="areapost_code" value="{$participantData.areapost_code}" size="32"/>		
							<br /><em class="success areapostnameselected">{$errorArray.areapost_name|default:"No area selected"}</em>
							{if isset($errorArray.areapost_code)}<br /><em class="error">{$errorArray.areapost_code}</em>{/if}
						</p>						
					</div>					
					<div class="article">
						<p class="short">
							<a class="link" href="javascript:submitForm();">Save Details</a>
							<br /><br />
							{if isset($success)}<span class="success">Your details have been updated.</span>{/if}
						</p>
					</div>						
				</div>				
				<div class="col">
					<div class="article">
						<h4><a href="#" class="error">Surname</a></h4>					
						<p class="short">
							<input type="text" name="participant_surname" id="participant_surname" value="{$participantData.participant_surname}" size="32"/>				
							{if isset($errorArray.participant_surname)}<br /><em class="error">{$errorArray.participant_surname}</em>{/if}
						</p>						
					</div>
					<div class="article">
						<h4><a href="#">Cellphone</a></h4>					
						<p class="short">
							<input type="text" name="participant_cellphone" id="participant_cellphone" value="{$participantData.participant_cellphone}" size="32"/>
							{if isset($errorArray.participant_cellphone)}<br /><em class="error">{$errorArray.participant_cellphone}</em>{/if}
						</p>						
					</div>						
				</div>	
				</form>
				<div class="col">
					<div class="article">
						<h4><a href="#">Participant Details</a></h4>
						<p class="short line">
							Book your participants who will be staying in your guest house.
						</p>
					</div>				
				</div>					
				<div class="clr"></div>
			</div>
			{include_php file='includes/footer.php'}
		</div>
		{literal}
		<script type="text/javascript">
		function submitForm() {
			document.forms.detailsForm.submit();					 
		}
		$( document ).ready(function() {
			$( "#areapost_name" ).autocomplete({
				source: "/feeds/area.php",
				minLength: 2,
				select: function( event, ui ) {
				
					if(ui.item.id == '') {
						$('#areapost_name').html('');
						$('#areapost_code').val('');					
						$('.areapostnameselected').html('');
					} else {
						$('#areapost_name').html(ui.item.value);
						$('.areapostnameselected').html('<b>' + ui.item.value + '</b>');						
						$('#areapost_code').val(ui.item.id);	
					}
					$('#areapost_name').val('');										
				}
			});
		});		
		</script>
		{/literal}			
	</body>
</html>