<?php /* Smarty version 2.6.20, created on 2015-06-18 20:59:11
         compiled from campaign/details.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'campaign/details.tpl', 16, false),array('function', 'html_options', 'campaign/details.tpl', 109, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nolali - The Creative</title>
<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/css.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/javascript.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<?php echo '
<script type="text/javascript">
var map;
var marker;

function mapa()
{
	var opts = {\'center\': new google.maps.LatLng('; ?>
<?php echo ((is_array($_tmp=@$this->_tpl_vars['campaignData']['campaign_latitude'])) ? $this->_run_mod_handler('default', true, $_tmp, "-33.9285481685662") : smarty_modifier_default($_tmp, "-33.9285481685662")); ?>
, <?php echo ((is_array($_tmp=@$this->_tpl_vars['campaignData']['campaign_longitude'])) ? $this->_run_mod_handler('default', true, $_tmp, "18.42681884765625") : smarty_modifier_default($_tmp, "18.42681884765625")); ?>
<?php echo '), \'zoom\':14, \'mapTypeId\': google.maps.MapTypeId.SATELLITE }
	map = new google.maps.Map(document.getElementById(\'mapdiv\'),opts);
	
	'; ?>
<?php if ($this->_tpl_vars['campaignData']['campaign_latitude'] != '' && $this->_tpl_vars['campaignData']['campaign_longitude'] != ''): ?><?php echo '
	marker = new google.maps.Marker({
		position: new google.maps.LatLng('; ?>
<?php echo $this->_tpl_vars['campaignData']['campaign_latitude']; ?>
, <?php echo $this->_tpl_vars['campaignData']['campaign_longitude']; ?>
<?php echo '),
		map: map
	});
	'; ?>
<?php endif; ?><?php echo '
	google.maps.event.addListener(map,\'click\',function(event) {
		
		//call function to create marker
		if (marker) {
			marker.setMap(null);
			marker = null;
		}
		
		document.getElementById(\'campaign_latitude\').value = event.latLng.lat();
		document.getElementById(\'campaign_longitude\').value = event.latLng.lng();
		marker = new google.maps.Marker({
			position: event.latLng,
			map: map
		});
	})
}
</script>
'; ?>

</head>
<body onload="mapa()">
<!-- Start Main Container -->
<div id="container">
    <!-- Start Content recruiter -->
  <div id="content">
    <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/header.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

  	<br />
	<div id="breadcrumb">
        <ul>
            <li><a href="/" title="Home">Home</a></li>
			<li><a href="/campaign/" title="">Campaign</a></li>
			<li><?php if (isset ( $this->_tpl_vars['campaignData'] )): ?>Edit campaign<?php else: ?>Add a campaign<?php endif; ?></li>
        </ul>
	</div><!--breadcrumb--> 
  
	<div class="inner"> 
      <h2><?php if (isset ( $this->_tpl_vars['campaignData'] )): ?><?php echo $this->_tpl_vars['campaignData']['campaign_company']; ?>
<?php else: ?>Add a new campaign<?php endif; ?></h2>
    <div id="sidetabs">
        <ul> 
            <li class="active"><a href="#" title="Details">Details</a></li>
			<li><a href="<?php if (isset ( $this->_tpl_vars['campaignData'] )): ?>/campaign/package.php?code=<?php echo $this->_tpl_vars['campaignData']['campaign_code']; ?>
<?php else: ?>#<?php endif; ?>" title="Package">Package</a></li>
        </ul>
    </div><!--tabs-->
	<div class="detail_box">
      <form id="detailsForm" name="detailsForm" action="/campaign/details.php<?php if (isset ( $this->_tpl_vars['campaignData'] )): ?>?code=<?php echo $this->_tpl_vars['campaignData']['campaign_code']; ?>
<?php endif; ?>" method="post">
        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="form">
			<tr>
				<td colspan="3" class="heading">Details</td>
			</tr>
			<tr>
				<td>
					<h4 class="error">Name:</h4><br />
					<input type="text" name="campaign_name" id="campaign_name" value="<?php echo $this->_tpl_vars['campaignData']['campaign_name']; ?>
" size="40"/>
					<?php if (isset ( $this->_tpl_vars['errorArray']['campaign_name'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['campaign_name']; ?>
</em><?php else: ?><br /><em>Shown on website</em><?php endif; ?>
				</td>	
				<td>
					<h4 class="error">Company Name:</h4><br />
					<input type="text" name="campaign_company" id="campaign_company" value="<?php echo $this->_tpl_vars['campaignData']['campaign_company']; ?>
" size="40"/>
					<?php if (isset ( $this->_tpl_vars['errorArray']['campaign_company'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['campaign_company']; ?>
</em><?php else: ?><br /><em>Registered company name</em><?php endif; ?>
				</td>	
				<td>
					<h4>Company Registration Number:</h4><br />
					<input type="text" name="campaign_registration_number" id="campaign_registration_number" value="<?php echo $this->_tpl_vars['campaignData']['campaign_registration_number']; ?>
" size="40"/><br /><em>As per CIPRO</em>
				</td>					
          </tr>	  
			<?php if (isset ( $this->_tpl_vars['campaignData'] )): ?>
          <tr>
            <td>
				<h4>Campaign Code:</h4><br />
				<?php echo $this->_tpl_vars['campaignData']['campaign_code']; ?>

			</td>	
            <td>
				<h4>Directory:</h4><br />
				<?php echo $this->_tpl_vars['campaignData']['campaign_directory']; ?>

			</td>	
            <td>
				<h4>Campaign Type:</h4><br />
				<?php echo $this->_tpl_vars['campaignData']['campaigntype_name']; ?>

			</td>	
          </tr>			  
			<?php else: ?>
          <tr>
            <td colspan="3">
				<h4>Campaign Type:</h4><br />
				<select id="campaigntype_code" name="campaigntype_code">
				<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['campaigntypePairs'],'selected' => $this->_tpl_vars['campaignData']['campaign_code']), $this);?>

				</select>
				<?php if (isset ( $this->_tpl_vars['errorArray']['campaigntype_code'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['campaigntype_code']; ?>
</em><?php endif; ?>
			</td>	
          </tr>				
		  <?php endif; ?>
          <tr>	
            <td>
				<h4 class="error">Domain:</h4><br />
				<input type="text" name="campaign_domain" id="campaign_domain" value="<?php echo $this->_tpl_vars['campaignData']['campaign_domain']; ?>
" size="40"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['campaign_domain'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['campaign_domain']; ?>
</em><?php endif; ?>
			</td>
            <td>
				<h4 class="error">Admin Domain:</h4><br />
				<input type="text" name="campaign_domain_admin" id="campaign_domain_admin" value="<?php echo $this->_tpl_vars['campaignData']['campaign_domain_admin']; ?>
" size="40"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['campaign_domain_admin'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['campaign_domain_admin']; ?>
</em><?php endif; ?>
			</td>			
			<td>
				<h4>Area / City / Suburb:</h4><br />
				<input type="text" name="areapost_name" id="areapost_name" value="<?php echo $this->_tpl_vars['campaignData']['areapost_name']; ?>
" size="40" />
				<input type="hidden" name="areapost_code" id="areapost_code" value="<?php echo $this->_tpl_vars['campaignData']['areapost_code']; ?>
" /><br />
				<span class="success" id="selectedarea"><?php echo $this->_tpl_vars['campaignData']['areapost_name']; ?>
</span>
				<?php if (isset ( $this->_tpl_vars['errorArray']['areapost_code'] )): ?><span class="error"><?php echo $this->_tpl_vars['errorArray']['areapost_code']; ?>
<span><?php endif; ?>			
			</td>
          </tr>			  
          <tr>
            <td>
				<h4 class="error">Contact Name:</h4><br />
				<input type="text" name="campaign_contact_name" id="campaign_contact_name" value="<?php echo $this->_tpl_vars['campaignData']['campaign_contact_name']; ?>
" size="40"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['campaign_contact_name'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['campaign_contact_name']; ?>
</em><?php endif; ?>
			</td>	
            <td>
				<h4 class="error">Contact Surname:</h4><br />
				<input type="text" name="campaign_contact_surname" id="campaign_contact_surname" value="<?php echo $this->_tpl_vars['campaignData']['campaign_contact_surname']; ?>
" size="40"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['campaign_contact_surname'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['campaign_contact_surname']; ?>
</em><?php endif; ?>
			</td>	
            <td>
				<h4 class="error">Email:</h4><br />
				<input type="text" name="campaign_email" id="campaign_email" value="<?php echo $this->_tpl_vars['campaignData']['campaign_email']; ?>
" size="40"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['campaign_email'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['campaign_email']; ?>
</em><?php endif; ?>
			</td>			
          </tr>	
          <tr>
            <td>
				<h4>Telephone:</h4><br />
				<input type="text" name="campaign_telephone" id="campaign_telephone" value="<?php echo $this->_tpl_vars['campaignData']['campaign_telephone']; ?>
" size="40"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['campaign_telephone'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['campaign_telephone']; ?>
</em><?php endif; ?>
			</td>	
            <td>
				<h4>Cell:</h4><br />
				<input type="text" name="campaign_cell" id="campaign_cell" value="<?php echo $this->_tpl_vars['campaignData']['campaign_cell']; ?>
" size="40"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['campaign_cell'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['campaign_cell']; ?>
</em><?php endif; ?>
			</td>	
            <td>
				<h4>Fax:</h4><br />
				<input type="text" name="campaign_fax" id="campaign_fax" value="<?php echo $this->_tpl_vars['campaignData']['campaign_fax']; ?>
" size="40"/>
				<?php if (isset ( $this->_tpl_vars['errorArray']['campaign_fax'] )): ?><br /><em class="error"><?php echo $this->_tpl_vars['errorArray']['campaign_fax']; ?>
</em><?php endif; ?>
			</td>	
          </tr>
          <tr>
            <td>
				<h4>Social Media - Facebook:</h4><br />
				<input type="text" name="campaign_facebook" id="campaign_facebook" value="<?php echo $this->_tpl_vars['campaignData']['campaign_facebook']; ?>
" size="40"/>
			</td>	
            <td>
				<h4>Social Media - Twitter:</h4><br />
				<input type="text" name="campaign_twitter" id="campaign_twitter" value="<?php echo $this->_tpl_vars['campaignData']['campaign_twitter']; ?>
" size="40"/>
			</td>	
            <td>
				<h4>Social Media - Google+:</h4><br />
				<input type="text" name="campaign_google" id="campaign_google" value="<?php echo $this->_tpl_vars['campaignData']['campaign_google']; ?>
" size="40"/>
			</td>	
          </tr>
          <tr>
            <td>
				<h4>Social Media - LinkedIn:</h4><br />
				<input type="text" name="campaign_linkedIn" id="campaign_linkedIn" value="<?php echo $this->_tpl_vars['campaignData']['campaign_linkedIn']; ?>
" size="40"/>
			</td>	
            <td colspan="2">
				<h4>Social Media - Blog:</h4><br />
				<input type="text" name="campaign_blog" id="campaign_blog" value="<?php echo $this->_tpl_vars['campaignData']['campaign_blog']; ?>
" size="40"/>
			</td>	
          </tr>
		  <tr>
            <td valign="top" colspan="3">
				<h4>Address:</h4><br />
				<input type="text" name="campaign_address" id="campaign_address" value="<?php echo $this->_tpl_vars['campaignData']['campaign_address']; ?>
" size="120"/>
			</td>			  
		  </tr>
          <tr>
            <td valign="top">
				<h4>Latitude:</h4><br />
				<input type="text" name="campaign_latitude" id="campaign_latitude" value="<?php echo $this->_tpl_vars['campaignData']['campaign_latitude']; ?>
" size="30" readonly />
				<h4>Longitude:</h4>
				<input type="text" name="campaign_longitude" id="campaign_longitude" value="<?php echo $this->_tpl_vars['campaignData']['campaign_longitude']; ?>
" size="30" readonly />				
			</td>	
			<td colspan="2">
				<div id="mapdiv" style="width: 500px; height: 380px;"></div>				
			</td>
		  </tr>
          <tr>
            <td>
				<h4>Bank Name:</h4><br />
				<input type="text" name="campaign_bankaccount_bank" id="campaign_bankaccount_bank" value="<?php echo $this->_tpl_vars['campaignData']['campaign_bankaccount_bank']; ?>
" size="40"/>
			</td>	
            <td>
				<h4>Bank Account Holder:</h4><br />
				<input type="text" name="campaign_bankaccount_holder" id="campaign_bankaccount_holder" value="<?php echo $this->_tpl_vars['campaignData']['campaign_bankaccount_holder']; ?>
" size="40"/>
			</td>	
            <td>
				<h4>Bank Account Number:</h4><br />
				<input type="text" name="campaign_bankaccount_number" id="campaign_bankaccount_number" value="<?php echo $this->_tpl_vars['campaignData']['campaign_bankaccount_number']; ?>
" size="40"/>
			</td>	
          </tr>
          <tr>
            <td>
				<h4>Bank Account Branch Code:</h4><br />
				<input type="text" name="campaign_bankaccount_branchcode" id="campaign_bankaccount_branchcode" value="<?php echo $this->_tpl_vars['campaignData']['campaign_bankaccount_branchcode']; ?>
" size="40"/>
			</td>	
            <td colspan="2">
				<h4>Vat (only % decimal):</h4><br />
				<input type="text" name="campaign_vat" id="campaign_vat" value="<?php echo $this->_tpl_vars['campaignData']['campaign_vat']; ?>
" size="10"/>
			</td>	
          </tr>			  
        </table>
      </form>
	</div>
    <div class="clearer"><!-- --></div>
        <div class="mrg_top_10">
          <a href="/campaign/" class="button cancel mrg_left_147 fl"><span>Cancel</span></a>
          <a href="javascript:submitForm();" class="blue_button mrg_left_20 fl"><span>Save &amp; Complete</span></a>   
        </div>
    <div class="clearer"><!-- --></div>
    </div><!--inner-->
 </div> 	
<!-- End Content recruiter -->
 </div><!-- End Content recruiter -->
 <?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => 'includes/footer.php', 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

</div>
<?php echo '
<script type="text/javascript" language="javascript">
function submitForm() {
	document.forms.detailsForm.submit();					 
}

$( document ).ready(function() {

	$( "#areapost_name" ).autocomplete({
		source: "/feeds/area.php",
		minLength: 2,
		select: function( event, ui ) {
		
			if(ui.item.id == \'\') {
				$(\'#areapost_name\').html(\'\');
				$(\'#areapost_code\').val(\'\');					
			} else {
				$(\'#areapost_name\').html(\'<b>\' + ui.item.value + \'</b>\');
				$(\'#areapost_code\').val(ui.item.id);									
			}
			
			$(\'#areapost_name\').val(\'\');										
		}
	});
});
</script>
'; ?>

<!-- End Main Container -->
</body>
</html>