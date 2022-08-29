
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
			<li class="breadcrumb-item"><a href="/invoice/booking/details.php?id={$invoiceData.invoice_id}">{$invoiceData.invoice_code}</a></li>
			{else}
			<li class="breadcrumb-item active" aria-current="page">Add</li>
			{/if}
			<li class="breadcrumb-item"><a href="/invoice/">Booking</a></li>
			<li class="breadcrumb-item"><a href="/invoice/">Invoice</a></li>
            <li class="breadcrumb-item"><a href="/">{$activeAccount.account_name}</a></li>
            <li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Bookings</h6>
        </div><!-- slim-pageheader -->
        <div class="section-wrapper card card-latest-activity mg-t-20">
			<label class="section-title">{if isset($invoiceData)}Details of {$invoiceData.invoice_code}{else}Add new bookings{/if}</label>
			<p class="mg-b-20 mg-sm-b-10">Below is where you add or update the booking</p>				
            <div class="row">
                <div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
                    {if isset($errors)}<div class="alert alert-danger" role="alert"><strong>{$errors}</strong></div>{/if}				
                    <form action="/invoice/booking/details.php{if isset($invoiceData)}?id={$invoiceData.invoice_id}{/if}" method="POST">
                        <div class="row">
                            <div class="col-sm-6">				
                                <div class="form-group has-error">
                                    <label for="bankentity_id">Bank Account</label>
                                    <select id="bankentity_id" name="bankentity_id" class="form-control is-invalid">
                                        <option value=""> -- Select -- </option>
                                        {html_options options=$bankentityPairs selected=$invoiceData.bankentity_id|default:''}
                                    </select>
                                    <code>Please select the bank account for this invoice</code>								
                                </div>
                            </div>
                            <div class="col-sm-6">				
                                <div class="form-group has-error">
                                    <label for="template_code">Make</label>
                                    <select class="form-control is-invalid" id="template_code" name="template_code">
                                        <option value=""> --- </option> 
                                        <option {if isset($invoiceData) and $invoiceData.template_code eq 'QUOTATION'}selected{/if} value="QUOTATION"> Quotation </option>
                                        <option {if isset($invoiceData) and $invoiceData.template_code eq 'INVOICE'}selected{/if} value="INVOICE"> Invoice </option>
                                    </select>
                                    <code>Please select the make of this invoice</code>								
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-10">				
                                <div class="form-group has-error">
                                    <label for="search_participant_name">Search participant</label>
                                    <input type="text" id="search_participant_name" name="search_participant_name" class="form-control is-invalid" value="{if isset($invoiceData)}{$invoiceData.participant_name} ( {$invoiceData.participant_cellphone} ){/if}" />	
                                    <input type="hidden" id="search_participant_id" name="search_participant_id" value="{if isset($invoiceData)}{$invoiceData.participant_id}{/if}" />	
                                    <code>Please select the participant this invoice belongs to</code>								
                                </div>
                            </div>
                            <div class="col-sm-2">				
                                <div class="form-group has-error">
                                    <label for="search_participant_name">&nbsp;</label><br />
									<input type="button" onclick="addParticipantModal(); return false;" value="New Participant" class="btn btn-secondary fr">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">				
                                <div class="form-group has-error">
                                    <label for="product_id">Search room</label>
                                    <input type="text" id="product_name" name="product_name" class="form-control is-invalid" value="{if isset($invoiceData)}{$invoiceData.product_name} at R {$invoiceData.price_amount|number_format:2:',':'.'} per night{/if}" />	
                                    <input type="hidden" id="price_id" name="price_id" value="{if isset($invoiceData)}{$invoiceData.price_id}{/if}" />	
                                    <code>Please select the room booked for this invoice</code>								
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">				
                                <div class="form-group has-error">
                                    <label for="product_id">Start Date</label>
                                    <input type="text" id="invoiceitem_date_start" name="invoiceitem_date_start" class="form-control is-invalid" value="{if isset($invoiceData)}{$invoiceData.invoiceitem_date_start}{/if}" />	
                                    <code>Please select the start date of this booking</code>								
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group has-error">
                                    <label for="product_id">End Date</label>
                                    <input type="text" id="invoiceitem_date_end" name="invoiceitem_date_end" class="form-control is-invalid" value="{if isset($invoiceData)}{$invoiceData.invoiceitem_date_end}{/if}" />
                                    <code>Please select the end date of this booking</code>	
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">	
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
        // Datepicker
        $('#invoiceitem_date_start').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
		  dateFormat: 'yy-mm-dd',
		  minDate : 0
        });		
        $('#invoiceitem_date_end').datepicker({
          showOtherMonths: true,
          selectOtherMonths: true,
		  dateFormat: 'yy-mm-dd',
		  minDate : 0
        });			
        $( "#product_name" ).autocomplete({
            source: "/feeds/room.php",
            minLength: 2,
            select: function( event, ui ) {
                if(ui.item.id == '') {
                    $('#product_name').html('');
                    $('#price_id').val('');					
                } else {
                    $('#product_name').val(ui.item.value);
                    $('#price_id').val(ui.item.id);
                }
                $('#product_name').val('');										
            }
        });		
    });
    </script>
    {/literal}
  </body>
</html>
