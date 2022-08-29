
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
			{if isset($invoicemonthlyData)}
			<li class="breadcrumb-item active" aria-current="page">Edit</li>
			<li class="breadcrumb-item"><a href="/invoice/monthly/details.php?id={$invoicemonthlyData.invoicemonthly_id}">#{$invoicemonthlyData.invoicemonthly_id}</a></li>
			{else}
			<li class="breadcrumb-item active" aria-current="page">Add</li>
			{/if}
			<li class="breadcrumb-item"><a href="/invoice/monthly/">Monthly</a></li>
			<li class="breadcrumb-item"><a href="/invoice/monthly/">Invoice</a></li>
            <li class="breadcrumb-item"><a href="/">{$activeAccount.account_name}</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Monthly invoice</h6>
        </div><!-- slim-pageheader -->
        {if isset($invoicemonthlyData)}
		<ul class="nav nav-activity-profile mg-t-20">
			<li class="nav-item">
				<a href="/invoice/monthly/details.php?id={$invoicemonthlyData.invoicemonthly_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Details</a>
			</li>
			<li class="nav-item">
				<a href="/invoice/monthly/item.php?id={$invoicemonthlyData.invoicemonthly_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Items</a>
			</li>
			<li class="nav-item">
				<a href="/invoice/monthly/invoice.php?id={$invoicemonthlyData.invoicemonthly_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Invoices</a>
			</li>		
		</ul>
        {/if}
        <div class="section-wrapper card card-latest-activity mg-t-20">
			<label class="section-title">{if isset($invoicemonthlyData)}Details of #{$invoicemonthlyData.invoicemonthly_id}{else}Add new monthly invoice{/if}</label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the monthly invoice</p>		
            <div class="row">
                <div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
                    {if isset($errors)}<div class="alert alert-danger" role="alert"><strong>{$errors}</strong></div>{/if}				
                    <form action="/invoice/monthly/details.php{if isset($invoicemonthlyData)}?id={$invoicemonthlyData.invoicemonthly_id}{/if}" method="POST">
                        <div class="row">
                            <div class="col-sm-6">				
                                <div class="form-group has-error">
                                    <label for="bankentity_id">Bank Account</label>
                                    <select id="bankentity_id" name="bankentity_id" class="form-control is-invalid">
                                        <option value=""> -- Select -- </option>
                                        {html_options options=$bankentityPairs selected=$invoicemonthlyData.bankentity_id|default:''}
                                    </select>
                                    <code>Please select the bank account for this monthly invoice</code>								
                                </div>
                            </div>
                            <div class="col-sm-6">			
                                <div class="form-group has-error">
                                    <label for="invoicemonthly_date">Payment Date</label>
                                    <input type="text" id="invoicemonthly_date" name="invoicemonthly_date" class="form-control is-invalid"   value="{if isset($invoicemonthlyData)}{$invoicemonthlyData.invoicemonthly_date}{/if}" />		
                                    <code>Please add the date this monthly invoice will expire by</code>								
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">				
                                <div class="form-group has-error">
                                    <label for="participant_name">Search participant</label>
                                    <input type="text" id="participant_name" name="participant_name" class="form-control is-invalid" value="{if isset($invoicemonthlyData)}{$invoicemonthlyData.participant_name} {$invoicemonthlyData.participant_surname} ( {$invoicemonthlyData.participant_cellphone} ){/if}" />	
                                    <input type="hidden" id="participant_id" name="participant_id" value="{if isset($invoicemonthlyData)}{$invoicemonthlyData.participant_id}{/if}" />	
                                    <code>Please select the participant this invoicemonthly belongs to</code>								
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">	
                                <div class="form-actions text">
                                    <input type="submit" value="{if !isset($invoicemonthlyData)}Add{else}Update{/if}" class="btn btn-primary">
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
    <script src="/library/javascript/jquery-ui.min.js"></script>
    <script src="/library/javascript/popper.js"></script>
    <script src="/library/javascript/bootstrap.js"></script>
    <script src="/library/javascript/jquery.cookie.js"></script>
    <script src="/library/javascript/summernote-0.8.18-dist/summernote-bs4.min.js"></script>
    {literal}
    <script type="text/javascript">
    $(document).ready(function() {
        // Summernote editor
        $('#invoicemonthly_text').summernote({
          height: 150,
          tooltip: false
        })
        $( "#participant_name" ).autocomplete({
            source: "/feeds/participant.php",
            minLength: 2,
            select: function( event, ui ) {
                if(ui.item.id == '') {
                    $('#participant_name').html('');
                    $('#participant_id').val('');					
                } else {
                    $('#participant_name').val(ui.item.value);
                    $('#participant_id').val(ui.item.id);
                }
                $('#participant_name').val('');										
            }
        });	
    });
    </script>
    {/literal}
  </body>
</html>
