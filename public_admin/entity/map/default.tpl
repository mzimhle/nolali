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
			<li class="breadcrumb-item active" aria-current="page">Map</li>            
            <li class="breadcrumb-item"><a href="/">{$entityData.entity_name}</a></li>
            <li class="breadcrumb-item"><a href="/entity/">Entities</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
          </ol>
          <h6 class="slim-pagetitle">Map Entity</h6>
        </div><!-- slim-pageheader -->
        <ul class="nav nav-activity-profile mg-t-20">
			<li class="nav-item">
				<a href="/entity/details.php?id={$entityData.entity_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Details</a>
			</li>
			<li class="nav-item">
				<a href="/entity/map/?id={$entityData.entity_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> MAP</a>
			</li>
        </ul>		
        <div class="section-wrapper card card-latest-activity mg-t-20">
			<label class="section-title">Entity Map</label>
            <p class="mg-b-20 mg-sm-b-20">Click on the location of the entity</p>
            <div class="row">
                <div class="col-md-12">
                {if isset($errors)}<div class="alert alert-danger" role="alert"><strong>{$errors}</strong></div>{/if}				
                <form action="/entity/map/?id={$entityData.entity_id}" method="POST">
                    <div class="row">
                        <div class="col-sm-6">			  
                            <div class="form-group has-error">
                                <label for="entity_map_latitude">Map Latitude</label>
                                <input type="text" id="entity_map_latitude" name="entity_map_latitude" class="form-control is-invalid" value="{if isset($entityData)}{$entityData.entity_map_latitude}{/if}" />
                                <code>Please add the latitude</code>								
                            </div>
                        </div>
                        <div class="col-sm-6">			  
                            <div class="form-group has-error">
                                <label for="entity_map_longitude">Map Longitude</label>
                                <input type="text" id="entity_map_longitude" name="entity_map_longitude" class="form-control is-invalid" value="{if isset($entityData)}{$entityData.entity_map_longitude}{/if}" />
                                <code>Please add the longitude</code>								
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
                </div>
            </div>
		  <!-- table-wrapper -->
        </div><!-- section-wrapper -->		
      </div><!-- container -->
    </div><!-- slim-mainpanel -->
	{include_php file="{$DOCUMENTROOT}/includes/footer.php"}
  </body>
</html>
