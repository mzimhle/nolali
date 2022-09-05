
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
			<li class="breadcrumb-item"><a href="/">Gallery</a></li>	
			<li class="breadcrumb-item"><a href="/">{$activeEntity.entity_name}</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Gallery</h6>
        </div><!-- slim-pageheader -->
        {if isset($contentData)}
		<ul class="nav nav-activity-profile mg-t-20">
			<li class="nav-item">
				<a href="/content/gallery/details.php?id={$contentData.content_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Details</a>
			</li>
			<li class="nav-item">
				<a href="/content/gallery/media.php?id={$contentData.content_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Media</a>
			</li>		
		</ul><br />
        {/if}		
        <div class="section-wrapper">
			<label class="section-title">{if isset($contentData)}Update {$contentData.content_name}{else}Add new content{/if}</label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the gallery</p>				
          <div class="row">
			<div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
            {if isset($errors)}<div class="alert alert-danger" role="alert"><strong>{$errors}</strong></div>{/if}				
            <form action="/content/gallery/details.php{if isset($contentData)}?id={$contentData.content_id}{/if}" method="POST">
                <div class="row">					
                    <div class="col-sm-12">			  
                        <div class="form-group has-error">
                            <label for="content_name">Name</label>
                            <input type="text" id="content_name" name="content_name" class="form-control" value="{if isset($contentData)}{$contentData.content_name}{/if}" />
                            <code>Please add the name of the gallery</code>									
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
  </body>
</html>
