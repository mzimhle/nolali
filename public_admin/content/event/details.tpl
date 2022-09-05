
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	{include_php file="{$DOCUMENTROOT}/includes/meta.php"}
    <link href="/css/summernote-bs4.css" rel="stylesheet">
  </head>
  <body>
	{include_php file="{$DOCUMENTROOT}/includes/header.php"}
    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
			<ol class="breadcrumb slim-breadcrumb">
			{if isset($contentData)}
			<li class="breadcrumb-item active" aria-current="page">Edit</li>
			<li class="breadcrumb-item">{$contentData.content_name}</li>
			{else}
			<li class="breadcrumb-item active" aria-current="page">Add</li>
			{/if}			
			<li class="breadcrumb-item"><a href="/">Event</a></li>	
			<li class="breadcrumb-item"><a href="/">{$activeEntity.entity_name}</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Event</h6>
        </div><!-- slim-pageheader -->
        {if isset($contentData)}
		<ul class="nav nav-activity-profile mg-t-20">
			<li class="nav-item">
				<a href="/content/event/details.php?id={$contentData.content_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Details</a>
			</li>
			<li class="nav-item">
				<a href="/content/event/media.php?id={$contentData.content_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Media</a>
			</li>		
		</ul><br />
        {/if}		
        <div class="section-wrapper">
			<label class="section-title">{if isset($contentData)}Update {$contentData.content_name}{else}Add new content{/if}</label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the event</p>				
          <div class="row">
			<div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
            {if isset($errors)}<div class="alert alert-danger" role="alert"><strong>{$errors}</strong></div>{/if}				
            <form action="/content/event/details.php{if isset($contentData)}?id={$contentData.content_id}{/if}" method="POST">
                <div class="row">					
                    <div class="col-sm-12">			  
                        <div class="form-group has-error">
                            <label for="content_name">Name</label>
                            <input type="text" id="content_name" name="content_name" class="form-control" value="{if isset($contentData)}{$contentData.content_name}{/if}" />
                            <code>Please add the name of the event</code>									
                        </div>
                    </div>				
				</div>
                <div class="row">					
                    <div class="col-sm-6">			  
                        <div class="form-group has-error">
                            <label for="content_date_start">Start Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                    </div>
                                </div>                            
                            <input type="text" id="content_date_start" name="content_date_start" class="form-control" readonly value="{if isset($contentData)}{$contentData.content_date_start|date_format:'%Y-%m-%d'}{/if}" />
                            </div>
                            <code>Please add the date for the event to show from</code>									
                        </div>
                    </div>	
                    <div class="col-sm-6">			  
                        <div class="form-group has-error">
                            <label for="content_date_end">End Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="icon ion-calendar tx-16 lh-0 op-6"></i>
                                    </div>
                                </div>                            
                            <input type="text" id="content_date_end" name="content_date_end" class="form-control" readonly value="{if isset($contentData)}{$contentData.content_date_end|date_format:'%Y-%m-%d'}{/if}" />
                            </div>
                            <code>Please add the date for the event to end at</code>									
                        </div>
                    </div>	                    
				</div>     
                <div class="row">					
                    <div class="col-sm-6">			  
                        <div class="form-group has-error">
                            <label for="content_time_start">Start Time</label>     
                            <select id="content_time_start" name="content_time_start" class="form-control">
                            <option value=""> --- Choose start time --- </option>
                            <option value="08:00" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '08:00'}selected{/if}> 08:00 </option>
                            <option value="08:30" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '08:30'}selected{/if}> 08:30 </option>
                            <option value="09:00" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '09:00'}selected{/if}> 09:00 </option>
                            <option value="09:30" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '09:30'}selected{/if}> 09:30 </option>
                            <option value="10:00" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '10:00'}selected{/if}> 10:00 </option>                           
                            <option value="10:30" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '10:30'}selected{/if}> 10:30 </option>
                            <option value="11:00" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '11:00'}selected{/if}> 11:00 </option>
                            <option value="11:30" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '11:30'}selected{/if}> 11:30 </option>
                            <option value="12:00" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '12:00'}selected{/if}> 12:00 </option>
                            <option value="12:30" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '12:30'}selected{/if}> 12:30 </option>
                            <option value="13:00" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '13:00'}selected{/if}> 13:00 </option>
                            <option value="13:30" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '13:30'}selected{/if}> 13:30 </option>
                            <option value="14:00" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '14:00'}selected{/if}> 14:00 </option>
                            <option value="14:30" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '14:30'}selected{/if}> 14:30 </option>
                            <option value="15:00" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '15:00'}selected{/if}> 15:00 </option>
                            <option value="15:30" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '15:30'}selected{/if}> 15:30 </option>
                            <option value="16:00" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '16:00'}selected{/if}> 16:00 </option>
                            <option value="16:30" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '16:30'}selected{/if}> 16:30 </option>
                            <option value="17:00" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '17:00'}selected{/if}> 17:00 </option>
                            <option value="17:30" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '17:30'}selected{/if}> 17:30 </option>
                            <option value="18:00" {if isset($contentData) && $contentData.content_date_start|date_format:'%H:%M' eq '18:00'}selected{/if}> 18:00 </option>
                            </select>
                            <code>Please add the time for the event to show from</code>									
                        </div>
                    </div>	
                    <div class="col-sm-6">			  
                        <div class="form-group has-error">
                            <label for="content_time_end">End Time</label>                        
                           <select id="content_time_end" name="content_time_end" class="form-control">
                            <option value=""> --- Choose start time --- </option>
                            <option value="08:00" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '08:00'}selected{/if}> 08:00 </option>
                            <option value="08:30" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '08:30'}selected{/if}> 08:30 </option>
                            <option value="09:00" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '09:00'}selected{/if}> 09:00 </option>
                            <option value="09:30" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '09:30'}selected{/if}> 09:30 </option>
                            <option value="10:00" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '10:00'}selected{/if}> 10:00 </option>                           
                            <option value="10:30" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '10:30'}selected{/if}> 10:30 </option>
                            <option value="11:00" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '11:00'}selected{/if}> 11:00 </option>
                            <option value="11:30" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '11:30'}selected{/if}> 11:30 </option>
                            <option value="12:00" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '12:00'}selected{/if}> 12:00 </option>
                            <option value="12:30" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '12:30'}selected{/if}> 12:30 </option>
                            <option value="13:00" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '13:00'}selected{/if}> 13:00 </option>
                            <option value="13:30" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '13:30'}selected{/if}> 13:30 </option>
                            <option value="14:00" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '14:00'}selected{/if}> 14:00 </option>
                            <option value="14:30" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '14:30'}selected{/if}> 14:30 </option>
                            <option value="15:00" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '15:00'}selected{/if}> 15:00 </option>
                            <option value="15:30" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '15:30'}selected{/if}> 15:30 </option>
                            <option value="16:00" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '16:00'}selected{/if}> 16:00 </option>
                            <option value="16:30" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '16:30'}selected{/if}> 16:30 </option>
                            <option value="17:00" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '17:00'}selected{/if}> 17:00 </option>
                            <option value="17:30" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '17:30'}selected{/if}> 17:30 </option>
                            <option value="18:00" {if isset($contentData) && $contentData.content_date_end|date_format:'%H:%M' eq '18:00'}selected{/if}> 18:00 </option>
                            </select>
                            <code>Please add the time for the event to end at</code>									
                        </div>
                    </div>	                    
				</div>
                <div class="row">					
                    <div class="col-sm-6">			  
                        <div class="form-group">
                            <label for="content_map_longitude">Longitude</label>                          
                            <input type="text" id="content_map_longitude" name="content_map_longitude" class="form-control" value="{if isset($contentData)}{$contentData.content_map_longitude}{/if}" />
                            <code>Add line of longitude for the location of the event</code>									
                        </div>
                    </div>	
                    <div class="col-sm-6">			  
                        <div class="form-group">
                            <label for="content_map_latitude">Latitude</label>                       
                            <input type="text" id="content_map_latitude" name="content_map_latitude" class="form-control" value="{if isset($contentData)}{$contentData.content_map_latitude}{/if}" />
                            <code>Add line of latitude for the location of the event</code>										
                        </div>
                    </div>	                    
				</div>                 
				<div class="row">
                    <div class="col-sm-12">			  
                        <div class="form-group">
                            <label for="content_text">Description</label>
                            <textarea id="content_text" name="content_text" class="form-control wysihtml5" rows="20">{if isset($contentData)}{$contentData.content_text}{/if}</textarea>
                            <code>Add description of the content</code>									
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-actions text">
                            <input type="submit" value="{if !isset($contentData)}Add{else}Update{/if}" class="btn btn-primary" />
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
    <script src="/library/javascript/summernote-0.8.18-dist/summernote-bs4.min.js"></script>
    {literal}
    <script type="text/javascript">
    $(document).ready(function() {
        // Summernote editor
        $('#content_text').summernote({
          height: 500,
          tooltip: false
        })
    });
        // Datepicker
        $('#content_date_start').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
		  dateFormat: 'yy-mm-dd',
		  minDate : 0
        });
        // Datepicker
        $('#content_date_end').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
		  dateFormat: 'yy-mm-dd',
		  minDate : 0
        });        
    </script>
    {/literal}	
  </body>
</html>
