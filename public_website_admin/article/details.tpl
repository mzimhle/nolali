<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>{$domainData.campaign_name} Management System</title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	{include_php file='includes/css.php'}
</head>
<body>
{include_php file='includes/header.php'}
<div class="container">
  <div class="content">
    <div class="content-container">
	<div class="content-header">
	<h2 class="content-header-title">Articles</h2>
	<ol class="breadcrumb">
	<li><a href="/">Home</a></li>
	<li><a href="/article/">Articles</a></li>
	<li><a href="#">{if isset($articleData)}{$articleData.article_name}{else}Add a article{/if}</a></li>
	<li class="active">Details</li>
	</ol>
	</div>	
      <div class="row">
        <div class="col-sm-9">
          <div class="portlet">
            <div class="portlet-header">
              <h3>
                <i class="fa fa-tasks"></i>
					{if isset($articleData)}{$articleData.article_name}{else}Add a article{/if}
              </h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
              <form id="validate-basic" action="/article/details.php{if isset($articleData)}?code={$articleData.article_code}{/if}" method="POST" data-validate="parsley" class="form parsley-form">
                <div class="form-group">
                  <label for="article_name">Name</label>
                  <input type="text" id="article_name" name="article_name" class="form-control" data-required="true" value="{$articleData.article_name}" />
				{if isset($errorArray.article_name)}<span class="error">{$errorArray.article_name}</span>{/if}					  
                </div>			
                <div class="form-group">
					<label for="article_description">Description</label>
					<textarea id="article_description" name="article_description" class="form-control" rows="3">{$articleData.article_description}</textarea>
					{if isset($errorArray.article_description)}<span class="error">{$errorArray.article_description}</span>{/if}					  
                </div>
                <div class="form-group">
					<label for="article_page">Page</label>
					<textarea id="article_page" name="article_page" class="form-control" rows="20">{$articleData.article_page}</textarea>
					{if isset($errorArray.article_page)}<span class="error">{$errorArray.article_page}</span>{/if}					  
                </div>				
                <div class="form-group"><button type="submit" class="btn btn-primary">Validate and Submit</button></div>
              </form>
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col -->
		<div class="col-sm-3">
			<div class="list-group">  
				<a class="list-group-item" href="/article/">
				  <i class="fa fa-asterisk"></i> &nbsp;&nbsp;List
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>
				{if isset($articleData)}					
				<a class="list-group-item" href="#">
				  <i class="fa fa-book"></i> &nbsp;&nbsp;Details
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a> 
				<a class="list-group-item" href="/article/image.php?code={$articleData.article_code}">
				  <i class="fa fa-file"></i> &nbsp;&nbsp;Add Images
				  <i class="fa fa-chevron-right list-group-chevron"></i>
				</a>				
				{/if}
			</div> <!-- /.list-group -->
        </div>			
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}
<script type="text/javascript" language="javascript" src="/library/javascript/nicedit/nicEdit.js"></script>	
{literal}
<script type="text/javascript" language="javascript">
$(document).ready(function() {			
	new nicEditor({
		iconsPath	: '/library/javascript/nicedit/nicEditorIcons.gif',
		buttonList 	: ['bold','italic','underline','left','center', 'ol', 'ul', 'xhtml', 'fontFormat', 'fontFamily', 'fontSize', 'unlink', 'link', 'strikethrough', 'superscript', 'subscript', 'upload'],
		uploadURI : '/library/javascript/nicedit/nicUpload.php',
	}).panelInstance('article_page');				
});

function submitForm() {
	nicEditors.findEditor('article_page').saveContent();
	document.forms.detailsForm.submit();					 
}

</script>
{/literal}
</html>
