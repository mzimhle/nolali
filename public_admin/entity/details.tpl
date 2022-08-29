
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
			{if isset($entityData)}
			<li class="breadcrumb-item active" aria-current="page">Details</li>
			<li class="breadcrumb-item">{$entityData.entity_name}</li>
			{else}
			<li class="breadcrumb-item active" aria-current="page">Add entity</li>
			{/if}
			<li class="breadcrumb-item"><a href="/entity/">Entities</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Entities</h6>
        </div><!-- slim-pageheader -->
        {if isset($entityData)}
        <ul class="nav nav-activity-profile mg-t-20">
			<li class="nav-item">
				<a href="/entity/details.php?id={$entityData.entity_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Details</a>
			</li>
			<li class="nav-item">
				<a href="/entity/map/?id={$entityData.entity_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> MAP</a>
			</li>	  
        </ul>
        {/if}
        <div class="section-wrapper card card-latest-activity mg-t-20">
			<label class="section-title">{if isset($entityData)}Update {$entityData.entity_name}{else}Add new entity{/if}</label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the entity</p>		
          <div class="row">
			<div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
            {if isset($errors)}<div class="alert alert-danger" role="alert"><strong>{$errors}</strong></div>{/if}				
                <form action="/entity/details.php{if isset($entityData)}?id={$entityData.entity_id}{/if}" method="POST">
                    <div class="row">
                        <div class="col-sm-12">			  
                            <div class="form-group has-error">
								<label for="account_id">Account</label>
								<select id="account_id" name="account_id" class="form-control is-invalid">
								<option value=""> -- Select an account -- </option>
								{html_options options=$accountPairs selected=$entityData.account_id|default:''}
								</select>
								<code>Please add the account of the entity</code>								
                            </div>
                        </div>						
                    </div>				
                    <div class="row">
                        <div class="col-sm-4">			  
                            <div class="form-group has-error">
                                <label for="entity_name">Name</label>
                                <input type="text" id="entity_name" name="entity_name" class="form-control is-invalid" value="{if isset($entityData)}{$entityData.entity_name}{/if}" />
                                <code>Please add the name</code>								
                            </div>
                        </div>
                        <div class="col-sm-4">			  
                            <div class="form-group has-error">
                                <label for="entity_contact_email">Email Address</label>
                                <input type="text" id="entity_contact_email" name="entity_contact_email" class="form-control is-invalid" value="{if isset($entityData)}{$entityData.entity_contact_email}{/if}" />
                                <code>Please add the email address</code>								
                            </div>
                        </div>
                        <div class="col-sm-4">			  
                            <div class="form-group has-error">
                                <label for="entity_contact_cellphone">Cellphone Number</label>
                                <input type="text" id="entity_contact_cellphone" name="entity_contact_cellphone" class="form-control is-invalid" value="{if isset($entityData)}{$entityData.entity_contact_cellphone}{/if}" />
                                <code>Please add the cellphone number</code>								
                            </div>
                        </div>							
                    </div>
                    <div class="row">
                        <div class="col-sm-4">			  
                            <div class="form-group">
                                <label for="entity_url">Website</label>
                                <input type="text" id="entity_url" name="entity_url" class="form-control" value="{if isset($entityData)}{$entityData.entity_url}{/if}" />
                                <code>Please add the website</code>								
                            </div>
                        </div>
                        <div class="col-sm-4">			  
                            <div class="form-group">
                                <label for="entity_map_latitude">Map Latitude</label>
                                <input type="text" id="entity_map_latitude" name="entity_map_latitude" class="form-control" value="{if isset($entityData)}{$entityData.entity_map_latitude}{/if}" />
                                <code>Please add the latitude</code>								
                            </div>
                        </div>
                        <div class="col-sm-4">			  
                            <div class="form-group">
                                <label for="entity_map_longitude">Map Longitude </label>
                                <input type="text" id="entity_map_longitude" name="entity_map_longitude" class="form-control" value="{if isset($entityData)}{$entityData.entity_map_longitude}{/if}" />
                                <code>Please add the longitude</code>								
                            </div>
                        </div>							
                    </div>
                    <div class="row">
                        <div class="col-sm-12">			  
                            <div class="form-group has-error">
                                <label for="entity_address_physical">Physical Address</label>
                                <input type="text" id="entity_address_physical" name="entity_address_physical" class="form-control is-invalid" value="{if isset($entityData)}{$entityData.entity_address_physical}{/if}" />
                                <code>Please add the physical address</code>								
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">			  
                            <div class="form-group">
                                <label for="entity_address_postal">Postal Address</label>
                                <input type="text" id="entity_address_postal" name="entity_address_postal" class="form-control" value="{if isset($entityData)}{$entityData.entity_address_postal}{/if}" />
                                <code>Please add the postal address</code>								
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">			  
                            <div class="form-group">
                                <label for="entity_number_registration">CIPRO Registration Number</label>
                                <input type="text" id="entity_number_registration" name="entity_number_registration" class="form-control" value="{if isset($entityData)}{$entityData.entity_number_registration}{/if}" />
                                <code>Please add the registration number</code>								
                            </div>
                        </div>
                        <div class="col-sm-4">			  
                            <div class="form-group">
                                <label for="entity_number_tax">Tax Number</label>
                                <input type="text" id="entity_number_tax" name="entity_number_tax" class="form-control" value="{if isset($entityData)}{$entityData.entity_number_tax}{/if}" />
                                <code>Please add the tax number</code>								
                            </div>
                        </div>
                        <div class="col-sm-4">			  
                            <div class="form-group">
                                <label for="entity_number_vat">Vat Number</label>
                                <input type="text" id="entity_number_vat" name="entity_number_vat" class="form-control" value="{if isset($entityData)}{$entityData.entity_number_vat}{/if}" />
                                <code>Please add the vat number</code>								
                            </div>
                        </div>							
                    </div>
                    <div class="row">
                        <div class="col-md-6">	
                            <div class="form-actions text">
                                <input type="submit" value="{if !isset($entityData)}Add{else}Update{/if}" class="btn btn-primary">
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
