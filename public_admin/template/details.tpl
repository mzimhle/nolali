
<!DOCTYPE html>
<html lang="en">
  <head>
	{include_php file="{$DOCUMENTROOT}/includes/meta.php"}
  </head>
  <body>
	{include_php file="{$DOCUMENTROOT}/includes/header.php"}
    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
			<ol class="breadcrumb slim-breadcrumb">
			{if isset($templateData)}
			<li class="breadcrumb-item active" aria-current="page">Details</li>
			<li class="breadcrumb-item">{$templateData.template_code}</li>
			{else}
			<li class="breadcrumb-item active" aria-current="page">Add template</li>
			{/if}
            <li class="breadcrumb-item"><a href="/template/">Templates</a></li>
            {if isset($activeAccount)}
            <li class="breadcrumb-item"><a href="#">{$activeAccount.account_name}</a></li>
            {/if}
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Templates</h6>
        </div><!-- slim-pageheader -->
        <div class="section-wrapper">
			<label class="section-title">{if isset($templateData)}Update {$templateData.template_code}{else}Add new template{/if}</label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add/update the template</p>		
          <div class="row">
			<div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
            {if isset($errors)}<div class="alert alert-danger" role="alert"><strong>{$errors}</strong></div>{/if}				
            <form id="validate-basic" action="/template/details.php{if isset($templateData)}?id={$templateData.template_id}{/if}" method="POST" data-validate="parsley" class="form parsley-form" enctype="multipart/form-data">						
				{if !isset($templateData)}
                <div class="row">
                    <div class="col-sm-3">				
                        <div class="form-group has-error">
                            <label for="template_category" class="text-danger"><b>Category</b></label>
                            <select id="template_category" name="template_category" class="form-control" {if isset($templateData)}readonly{/if}>
                                <option value="EMAIL" {if isset($templateData) and $templateData.template_category eq 'EMAIL'}selected{/if}> EMAIL </option>
                                <option value="SMS" {if isset($templateData) and $templateData.template_category eq 'SMS'}selected{/if}> SMS </option>
                                <option value="TEMPLATE" {if isset($templateData) and $templateData.template_category eq 'TEMPLATE'}selected{/if}> TEMPLATE </option>
                            </select>	
                        </div>
                    </div>
                    <div class="col-sm-9">					
                        <div class="form-group has-error">
                            <label for="template_code" class="text-danger"><b>Unique Code</b></label>
                            <input type="text" id="template_code" name="template_code" class="form-control" data-required="true" value="{if isset($templateData)}{$templateData.template_code}{/if}" />								
                        </div>
                    </div>
                </div>
                {else}
                <div class="form-group">							
                    <label for="template_category">Category</label><br />
                    {$templateData.template_category}<br /><br />
                    <label for="template_code">Code</label><br />
                    {$templateData.template_code}<br /><br />						
                </div>
                <input type="hidden" id="template_category" name="template_category" value="{$templateData.template_category}" />
                <input type="hidden" id="template_code" name="template_code" value="{$templateData.template_code}	" />
                {/if}
                <div class="form-group SMS has-error">
                    <label for="template_message" class="text-danger"><b>Message</b></label>
                    <textarea id="template_message" name="template_message" class="form-control" rows="5">{if isset($templateData)}{$templateData.template_message}{/if}</textarea>
                    <code class="smalltext error" id="template_count">0 characters entered.</code><br />			  
                </div>				
                <div class="form-group EMAIL has-error">
                    <label for="template_subject" class="text-danger"><b>Subject</b></label>
                    <input type="text" id="template_subject" name="template_subject" class="form-control" value="{if isset($templateData)}{$templateData.template_subject}{/if}" />									
                </div>				
                <div class="form-group TEMPLATE">
                    <label for="htmlfile">Upload HTML / HTM file</label>
                    <input type="file" id="htmlfile" name="htmlfile" class="form-control" />	
                    {if isset($templateData)}
                        {if $templateData.template_file neq ''}
                            <br />
                            <p>
                                <a href="/template/view.php?id={$templateData.template_id}" target="_blank">{$config.site}{$templateData.template_file}</a>
                            </p>
                        {/if}
                    {/if}
                </div>
                <div class="form-group TEMPLATE">
                    <label for="mediafiles">Media upload</label>
                    <input type="file" id="mediafiles[]" name="mediafiles[]" multiple class="form-control" />
                    <code>N.B.: Upload only eot, woff, ttf, svg, css, jpg, jpeg, png or gif images</code>	
                </div>		
                <div class="row">
                    <div class="col-md-6">	
                        <div class="form-actions text">
                            <input type="submit" value="{if !isset($templateData)}Add{else}Update{/if}" class="btn btn-primary">
                        </div>
                    </div>
                </div>				
			</form>
            </div><!-- col-4 -->
          </div><!-- row -->
        </div><!-- section-wrapper -->
      </div><!-- container -->
    </div><!-- slim-mainpanel -->
	{include_php file="{$DOCUMENTROOT}/includes/footer.php"}
    <script src="/library/javascript/jquery.js"></script>
    <script src="/library/javascript/popper.js"></script>
    <script src="/library/javascript/bootstrap.js"></script>
    <script src="/library/javascript/jquery.cookie.js"></script>
{literal}
<script type="text/javascript">
$( document ).ready(function() {
	$("#template_category").change(function() {
	  categoryChange(); 
	  return false;
	});
	categoryChange();
	messageCount();
});

function messageCount() {
	$("#template_message").keyup(function () {
		var i = $("#template_message").val().length;
		$("#template_count").html(i+' characters entered.');
		if (i > 140) {
			$('#template_count').removeClass('success');
			$('#template_count').addClass('error');
		} else if(i == 0) {
			$('#template_count').removeClass('success');
			$('#template_count').addClass('error');
		} else {
			$('#template_count').removeClass('error');
			$('#template_count').addClass('success');
		} 
	});	
	return false;
}

function categoryChange() {
	var category = $( "#template_category" ).val();
	
	if(category == 'EMAIL') {
		$(".SMS").hide();
		$(".EMAIL").show();
		$(".TEMPLATE").show();
		messageCount();
	} else if(category == 'SMS') {
		$(".SMS").show();
		$(".EMAIL").hide();
		$(".TEMPLATE").hide();
	} else if(category == 'TEMPLATE') {
		$(".SMS").hide();
		$(".EMAIL").hide();
		$(".TEMPLATE").show();
	}
	return false;
}
</script>
{/literal}	
  </body>
</html>
