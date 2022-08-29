
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
			{if isset($invoiceData)}
			<li class="breadcrumb-item active" aria-current="page">Edit</li>
			<li class="breadcrumb-item"><a href="/invoice/details.php?id={$invoiceData.invoice_id}">{$invoiceData.invoice_code}</a></li>
			{else}
			<li class="breadcrumb-item active" aria-current="page">Add</li>
			{/if}
			<li class="breadcrumb-item"><a href="/invoice/">Ad Hoc</a></li>
			<li class="breadcrumb-item"><a href="/invoice/">Invoice</a></li>
            <li class="breadcrumb-item"><a href="/">{$activeAccount.account_name}</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Invoice</h6>
        </div><!-- slim-pageheader -->
        {if isset($invoiceData)}
		<ul class="nav nav-activity-profile mg-t-20">
			<li class="nav-item">
				<a href="/invoice/details.php?id={$invoiceData.invoice_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Details</a>
			</li>
			<li class="nav-item">
				<a href="/invoice/item.php?id={$invoiceData.invoice_id}" class="nav-link"><i class="icon ion-ios-redo tx-purple"></i> Items</a>
			</li>		
		</ul>
        {/if}
        <div class="section-wrapper card card-latest-activity mg-t-20">
			<label class="section-title">{if isset($invoiceData)}Details of {$invoiceData.invoice_code}{else}Add new invoice{/if}</label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the invoice</p>				
            <div class="row">
                <div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
                    {if isset($errors)}<div class="alert alert-danger" role="alert"><strong>{$errors}</strong></div>{/if}				
                    <form action="/invoice/details.php{if isset($invoiceData)}?id={$invoiceData.invoice_id}{/if}" method="POST">
                        <div class="row">
                            <div class="col-sm-4">			
                                <div class="form-group has-error">
                                    <label for="invoice_date_payment">Expiry Date</label>
									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">
												<i class="icon ion-calendar tx-16 lh-0 op-6"></i>
											</div>
										</div>
										<input type="text" class="form-control" id="invoice_date_payment" name="invoice_date_payment" value="{if isset($invoiceData)}{$invoiceData.invoice_date_payment}{/if}" readonly />
									</div>
									<code>Please select expiry date of invoice</code>
                                </div>
                            </div>
                            {if !isset($entity)}
                            <div class="col-sm-8">
                                <div class="form-group has-error">
                                    <label for="search_entity_name">Search for entity</label>
                                    <input type="text" id="search_entity_name" name="search_entity_name" class="form-control is-invalid" value="{if isset($invoiceData)}{$invoiceData.entity_name} ( {$invoiceData.entity_contact_cellphone} ){/if}" />	
                                    <input type="hidden" id="search_entity_id" name="search_entity_id" value="{if isset($invoiceData)}{$invoiceData.entity_id}{/if}" />	
                                    <code>Please select owner of the invoice</code>
                                </div>
                            </div>
                            {else}
                            <div class="col-sm-5">
                                <div class="form-group has-error">
                                    <label for="search_participant_name">Search for participant</label>
                                    <input type="text" id="search_participant_name" name="search_participant_name" class="form-control is-invalid" value="{if isset($invoiceData)}{$invoiceData.participant_name} ( {$invoiceData.participant_cellphone} ){/if}" />
                                    <input type="hidden" id="search_participant_id" name="search_participant_id" value="{if isset($invoiceData)}{$invoiceData.participant_id}{/if}" />	
                                    <code>Select owner of the invoice</code>
                                </div>
                            </div>
                            <div class="col-md-3">	
                                <div class="form-group has-error">
                                    <label for="search_participant_name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type="button" value="{if !isset($invoiceData)}Add{else}Change{/if} participant" class="btn btn-primary form-control" onclick="addParticipantModal(); return false;">
                                </div>
                            </div>                            
                            {/if}
                        </div>						
                        <div class="row">
                            <div class="col-md-12">	
                                <div class="form-actions text">
                                    <input type="submit" value="{if !isset($invoiceData)}Add{else}Update{/if}" class="btn btn-primary">
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
    {literal}
    <script type="text/javascript">
    $(document).ready(function() {	
        // Datepicker
        $('#invoice_date_payment').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
		  dateFormat: 'yy-mm-dd',
		  minDate : 0
        });
		// Feed	        
        {/literal}{if !isset($entity)}{literal}	
        $( "#search_entity_name" ).autocomplete({
            source: "/feeds/entity.php",
            minLength: 2,
            select: function( event, ui ) {
                if(ui.item.id == '') {
                    $('#search_entity_name').html('');
                    $('#search_entity_id').val('');					
                } else {
                    $('#search_entity_name').val(ui.item.value);
                    $('#search_entity_id').val(ui.item.id);
                }
                $('#search_entity_name').val('');										
            }
        });
        {/literal}{else}{literal}
        $( "#search_participant_name" ).autocomplete({
            source: "/feeds/participant.php",
            minLength: 2,
            select: function( event, ui ) {
                if(ui.item.id == '') {
                    $('#search_participant_name').html('');
                    $('#search_participant_id').val('');					
                } else {
                    $('#search_participant_name').val(ui.item.value);
                    $('#search_participant_id').val(ui.item.id);
                }
                $('#search_participant_name').val('');										
            }
        });
        {/literal}{/if}{literal}
        
    });
    </script>
    {/literal}
  </body>
</html>
