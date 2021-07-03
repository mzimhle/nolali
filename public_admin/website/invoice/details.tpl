<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nolali - The Creative</title>
{include_php file='includes/css.php'}
{include_php file='includes/javascript.php'}
<script type="text/javascript" language="javascript" src="default.js"></script>
</head>
<body>
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content recruiter -->
  <div id="content">
    {include_php file='includes/header.php'}
  	<br />
	<div id="breadcrumb">
        <ul>
            <li><a href="/" title="Home">Home</a></li>
			<li><a href="/website/" title="Website">Website</a></li>
			<li><a href="#" title="Website"><span class="success">{$domainData.campaign_name}</span></a></li>
			<li><a href="/website/invoice/" title="">Invoice</a></li>
			<li>{if isset($invoiceData)}REF#{$invoiceData.invoice_code}{else}Add an invoice{/if}</li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2>{if isset($invoiceData)}Edit Campaign Invoice{else}Add a Campaign Invoice{/if}</h2>
    <div id="sidetabs">
        <ul > 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="{if isset($invoiceData)}/website/invoice/item.php?code={$invoiceData.invoice_code}{else}#{/if}" title="Items">Items</a></li>
			<li><a href="{if isset($invoiceData)}/website/invoice/payment.php?code={$invoiceData.invoice_code}{else}#{/if}" title="Payment">Payments</a></li>
        </ul>
    </div><!--tabs-->

	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/website/invoice/details.php{if isset($invoiceData)}?code={$invoiceData.invoice_code}{/if}" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form"> 		  
          <tr>
            <td class="left_col error">
				<h4>Full name:</h4><br />
				<input type="text" name="invoice_person_name" id="invoice_person_name" value="{$invoiceData.invoice_person_name}" size="40"/>
				{if isset($errorArray.invoice_person_name)}<br /><em class="error">{$errorArray.invoice_person_name}</em>{/if}
			</td>
            <td class="left_col error">
				<h4>Emal address:</h4><br />
				<input type="text" name="invoice_person_email" id="invoice_person_email" value="{$invoiceData.invoice_person_email}" size="40"/>
				{if isset($errorArray.invoice_person_email)}<br /><em class="error">{$errorArray.invoice_person_email}</em>{/if}
			</td>
            <td class="left_col">
				<h4>Number:</h4><br />
				<input type="text" name="invoice_person_number" id="invoice_person_number" value="{$invoiceData.invoice_person_number}" size="40"/>
				{if isset($errorArray.invoice_person_number)}<br /><em class="error">{$errorArray.invoice_person_number}</em>{/if}
			</td>				
          </tr>		
          <tr>
            <td class="left_col error" valign="top">
				<h4>Make:</h4><br />
				<select id="invoice_make" name="invoice_make">
					<option value=""> ---------------- </option>
					<option value="ESTIMATE" {if $invoiceData.invoice_make eq 'ESTIMATE'}SELECTED{/if}> Cost Estimate </option>
					<option value="INVOICE" {if $invoiceData.invoice_make eq 'INVOICE'}SELECTED{/if}> Invoice </option>
					<option value="QUOTATION" {if $invoiceData.invoice_make eq 'QUOTATION'}SELECTED{/if}> Quotation </option>
				</select>
				{if isset($errorArray.invoice_make)}<br /><em class="error">{$errorArray.invoice_make}</em>{/if}
			</td>
			<td class="left_col" colspan="2">
				<h4>Notes:</h4><br />
				<textarea name="invoice_notes" id="invoice_notes" rows="3" cols="80">{$invoiceData.invoice_notes}</textarea>
			</td>				
          </tr>
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="javascript:submitForm();" class="blue_button mrg_left_147 fl"><span>Save &amp; Complete</span></a>   
        </div>
    <div class="clearer"><!-- --></div>
    </div><!--inner-->
 </div> 	
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 {include_php file='includes/footer.php'}
</div>
{literal}
<script type="text/javascript" language="javascript">
function submitForm() {
	document.forms.detailsForm.submit();					 
}
</script>
{/literal}
<!-- End Main Container -->
</body>
</html>
