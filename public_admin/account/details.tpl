
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	{include_php file="{$DOCUMENTROOT}/includes/meta.php"}	
  </head>
  <body>
	{include_php file="{$DOCUMENTROOT}/includes/header.php"}
    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
			<ol class="breadcrumb slim-breadcrumb">
			{if isset($accountData)}
			<li class="breadcrumb-item active" aria-current="page">Details</li>
			<li class="breadcrumb-item">{$accountData.account_name}</li>
			{else}
			<li class="breadcrumb-item active" aria-current="page">Add account</li>
			{/if}
			<li class="breadcrumb-item"><a href="/account/">Accounts</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Accounts</h6>
        </div><!-- slim-pageheader -->
        <div class="section-wrapper card card-latest-activity mg-t-20">
			<label class="section-title">{if isset($accountData.account_id)}Update {$accountData.account_name}{else}Add new account{/if}</label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the account</p>		
          <div class="row">
			<div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
            {if isset($errors)}<div class="alert alert-danger" role="alert"><strong>{$errors}</strong></div>{/if}				
                <form action="/account/details.php{if isset($accountData)}?id={$accountData.account_id}{/if}" method="POST">
                    <div class="row">
                        <div class="col-sm-6">			  
                            <div class="form-group has-error">
                                <label for="account_name">Name</label>
                                <input type="text" id="account_name" name="account_name" class="form-control" value="{if isset($accountData)}{$accountData.account_name}{/if}" />
                                <code>Please add the name of the account holder.</code>								
                            </div>
                        </div>
                        <div class="col-sm-6">		
                            <div class="form-group has-error">
                                <label for="account_cellphone">Cellphone</label>
                                <input type="text" id="account_cellphone" name="account_cellphone" class="form-control" value="{if isset($accountData)}{$accountData.account_cellphone}{/if}" />	
                            <code>Please add the cellphone number of the account</code>							
                            </div>
                        </div>
                    </div>	
                    <div class="row">
                        <div class="col-sm-6">		
                            <div class="form-group">
                                <label for="account_password">Password</label>
                                <input type="password" id="account_password" name="account_password" class="form-control" value="{if isset($accountData)}{$accountData.account_password}{/if}" />
                                <code>Please add the password of the account</code>	
                            </div>
                        </div>
                        <div class="col-sm-6">		
                            <div class="form-group">
                                <label for="account_password_2">Retype Password</label>
                                <input type="password" id="account_password_2" name="account_password_2" class="form-control" value="{if isset($accountData)}{$accountData.account_password}{/if}" />	
                                <code>Please retype the password of the account</code>	
                            </div>
                        </div>					
                    </div>	
                    <div class="row">
                        <div class="col-sm-6">		
                            <div class="form-group has-error">
                                <label for="account_email">Email</label>
                                <input type="text" id="account_email" name="account_email" class="form-control" value="{if isset($accountData)}{$accountData.account_email}{/if}" /><code>Please add the email address of the account</code>		 
                            </div>
                        </div>	
                        <div class="col-sm-6">		
                            <div class="form-group">
                                <label for="account_reference">Account Reference Number</label>
                                <input type="text" id="account_reference" name="account_reference" class="form-control" value="{if isset($accountData.account_reference)}{$accountData.account_reference}{/if}" readonly disabled />	  
                            </div>
                        </div>					
                    </div>
                    <div class="row">
                        <div class="col-md-6">	
                            <div class="form-actions text">
                                <input type="submit" value="{if !isset($accountData)}Add{else}Update{/if}" class="btn btn-primary">
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
