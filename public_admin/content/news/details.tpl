
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
			<li class="breadcrumb-item">{$contentData.content_name|truncate:30:"..."}</li>
			{else}
			<li class="breadcrumb-item active" aria-current="page">Add</li>
			{/if}			
			<li class="breadcrumb-item"><a href="/">News</a></li>	
			<li class="breadcrumb-item"><a href="/">{$activeEntity.entity_name}</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">News</h6>
        </div><!-- slim-pageheader -->
        {if isset($contentData)}
		<ul class="nav nav-activity-profile mg-t-20">
			<li class="nav-item">
				<a href="/content/news/details.php?id={$contentData.content_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Details</a>
			</li>
			<li class="nav-item">
				<a href="/content/news/media.php?id={$contentData.content_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Media</a>
			</li>		
		</ul><br />
        {/if}		
        <div class="section-wrapper">
			<label class="section-title">{if isset($contentData)}Update {$contentData.content_name}{else}Add new content{/if}</label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the news</p>				
          <div class="row">
			<div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
            {if isset($errors)}<div class="alert alert-danger" role="alert"><strong>{$errors}</strong></div>{/if}				
            <form action="/content/news/details.php{if isset($contentData)}?id={$contentData.content_id}{/if}" method="POST">
                <div class="row">					
                    <div class="col-sm-12">			  
                        <div class="form-group has-error">
                            <label for="content_name">Name</label>
                            <input type="text" id="content_name" name="content_name" class="form-control" value="{if isset($contentData)}{$contentData.content_name}{/if}" />
                            <code>Please add title of the news</code>									
                        </div>
                    </div>				
				</div>               
                <div class="row">					
                    <div class="col-sm-12">			  
                        <div class="form-group has-error">
                            <label for="content_url">URL of the news</label>
                            <input type="text" id="content_url" name="content_url" class="form-control" value="{if isset($contentData)}{$contentData.content_url}{/if}" />
                            <code>Please add the name of the news</code>									
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