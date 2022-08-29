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
			{if isset($categoryData)}
			<li class="breadcrumb-item active" aria-current="page">Edit</li>
			<li class="breadcrumb-item">{$categoryData.category_name}</li>
			{else}
			<li class="breadcrumb-item active" aria-current="page">Add</li>
			{/if}
			<li class="breadcrumb-item"><a href="/income/category/">Income Category</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Income Category</h6>
        </div><!-- slim-pageheader -->
        <div class="section-wrapper">
			<label class="section-title">{if isset($categoryData)}Update {$categoryData.category_name}{else}Add new income category{/if}</label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the income category</p>		
            <div class="row">
                <div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
                    {if isset($errors)}<div class="alert alert-danger" role="alert"><strong>{$errors}</strong></div>{/if}				
                    <form action="/income/category/details.php{if isset($categoryData)}?id={$categoryData.category_id}{/if}" method="POST">
                        <div class="row">					
                            <div class="col-sm-12">			  
                                <div class="form-group has-error">
                                    <label for="category_name">Name</label>
                                    <input type="text" id="category_name" name="category_name" class="form-control is-invalid" value="{if isset($categoryData)}{$categoryData.category_name}{/if}" />
                                    <code>Please add the name of the income category</code>									
                                </div>
                            </div>							
                        </div>
                        <div class="row">					
                            <div class="col-sm-12">			  
                                <div class="form-group has-error">
                                    <label for="category_code">Code</label>
                                    <input type="text" id="category_code" name="category_code" class="form-control is-invalid" value="{if isset($categoryData)}{$categoryData.category_code}{/if}" />
                                    <code>Please add the name of the income category</code>									
                                </div>
                            </div>							
                        </div>						
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-actions text">
                                    <input type="submit" value="{if !isset($categoryData)}Add{else}Update{/if}" class="btn btn-primary">
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
