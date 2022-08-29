
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
			{if isset($sectionData)}
			<li class="breadcrumb-item active" aria-current="page">Edit</li>
			<li class="breadcrumb-item">{$sectionData.section_name}</li>
			{else}
			<li class="breadcrumb-item active" aria-current="page">Add</li>
			{/if}
			<li class="breadcrumb-item"><a href="/income/section/">Income Section</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Income Section</h6>
        </div><!-- slim-pageheader -->
        <div class="section-wrapper">
			<label class="section-title">{if isset($sectionData)}Update {$sectionData.section_name}{else}Add new Income Section{/if}</label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the Income Section</p>		
          <div class="row">
			<div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
            {if isset($errors)}<div class="alert alert-danger" role="alert"><strong>{$errors}</strong></div>{/if}				
            <form action="/income/section/details.php{if isset($sectionData)}?id={$sectionData.section_id}{/if}" method="POST">
                <div class="row">	
                    <div class="col-sm-6">			  
                        <div class="form-group has-error">
                            <label for="section_name">Name</label>
                            <input type="text" id="section_name" name="section_name" class="form-control is-invalid" value="{if isset($sectionData)}{$sectionData.section_name}{/if}" />
                            <code>Please add the name of the Income Section</code>									
                        </div>
                    </div>				
                    <div class="col-sm-6">			  
                        <div class="form-group has-error">
                            <label for="category_id">Category</label>
                            <select id="category_id" name="category_id" class="form-control is-invalid">
							<option value=""> -- Select a section -- </option>
                            {html_options options=$categoryPairs selected=$sectionData.category_id|default:''}
                            </select>
                            <code>Please add the category of the Income Section</code>									
                        </div>
                    </div>
				</div>
				<div class="row">	
                    <div class="col-sm-6">			  
                        <div class="form-group">
                            <label for="section_direction">Direction</label>
                            <select id="section_direction" name="section_direction" class="form-control">
							<option value="0" {if isset($sectionData) && $sectionData.section_direction eq '0'}SELECTED{/if}> Subtraction </option>							
							<option value="1" {if isset($sectionData) && $sectionData.section_direction eq '1'}SELECTED{/if}> Addition </option>							
                            </select>
                            <code>Please add the name of the Income Section</code>									
                        </div>
                    </div>					
                    <div class="col-sm-6">			  
                        <div class="form-group">
                            <label for="section_calculated">Calculated</label>
                            <select id="section_calculated" name="section_calculated" class="form-control">
							<option value="0" {if isset($sectionData) && $sectionData.section_calculated eq '0'}SELECTED{/if}> No </option>
							<option value="1" {if isset($sectionData) && $sectionData.section_calculated eq '1'}SELECTED{/if}> Yes </option>
                            </select>
                            <code>Please add the name of the Income Section</code>									
                        </div>
                    </div>			
                </div>
				<div class="row">	
                    <div class="col-sm-12">			  
                        <div class="form-group">
                            <label for="section_code">Code</label>
                            <input type="text" id="section_code" name="section_code" class="form-control" value="{if isset($sectionData)}{$sectionData.section_code}{/if}" />
                            <code>Please add the code of the Income Section</code>									
                        </div>
                    </div>									
                </div>				
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-actions text">
                            <input type="submit" value="{if !isset($sectionData)}Add{else}Update{/if}" class="btn btn-primary">
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
