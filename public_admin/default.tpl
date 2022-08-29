<!DOCTYPE html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	{include_php file="{$DOCUMENTROOT}/includes/meta.php"}
    <!-- Meta -->
    <meta name="description" content="Share Manager">
    <meta name="author" content="Share Manager">
    <title>Share Manager</title>
  </head>
  <body class="dashboard-4">
	{include_php file="{$DOCUMENTROOT}/includes/header.php"}
    <div class="slim-mainpanel">
      <div class="container pd-t-50">  
        <div class="row">
          <div class="col-lg-12">
            <h3 class="tx-inverse mg-b-15">Welcome back administrator!</h3>
            <p class="mg-b-20">Welcome to the Yam Accounting Solution backend system, here you will be able to over see all activities by all clients</p>
			<form action="/" method="POST">
				<div class="row">	
					<div class="col-sm-6">			  
						<div class="form-group has-error">
							<label for="account_id">Account</label>
							<select id="account_id" name="account_id" class="form-control is-invalid">
							<option value=""> -- Select an account -- </option>
							{html_options options=$accountPairs selected=$account|default:''}
							</select>
							<code>Please add the account of the entity</code>								
						</div>
					</div>						
					<div class="col-md-6">					
						<div class="form-group">
							<label>Select Entity</label>
							<select class="form-control" id="entity_id" name="entity_id">
								<option value=""> --- Select an entity --- </option>
							</select>
						</div>
					</div>				
				</div>
				<div class="form-actions text-left">
					<input type="submit" value="Select" class="btn btn-primary" />
				</div>	
			</form>			
          </div><!-- col-6 -->
        </div><!-- row -->	
		<hr />
		</div><!-- container -->
    </div><!-- slim-mainpanel -->
	{include_php file="{$DOCUMENTROOT}/includes/footer.php"}
	{literal}
	<script type="text/javascript">
		$(document).ready(function() {
			changeEntity();
			$("#account_id").change(function() {
				changeEntity();
			});			
		});

		function changeEntity() {
			$.ajax({
				type: "GET",
				url: "default.php",
				data: "getentity="+$('#account_id').val(),
				dataType: "html",
				success: function(html){
					$('#entity_id').html(html);
				}
			});
		}
	</script>
	{/literal}
  </body>
</html>
