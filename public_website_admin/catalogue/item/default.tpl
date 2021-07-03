<!DOCTYPE html><!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]--><!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]--><!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]--><!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]--><head>	<title>{$domainData.campaign_name} Management System</title>	<meta charset="utf-8">	<meta name="description" content="">	<meta name="viewport" content="width=device-width">	{include_php file='includes/css.php'}</head><body>{include_php file='includes/header.php'}<div class="container">  <div class="content">    <div class="content-container">	<div class="content-header">		<h2 class="content-header-title">Items</h2>		<ol class="breadcrumb">		<li><a href="/">Home</a></li>		<li class="active"><a href="/catalogue/item/">Items</a></li>		</ol>	</div>	  	<div class="row">        <div class="col-md-12">		<button class="btn btn-secondary fr" type="button" onclick="link('/catalogue/item/details.php'); return false;">Add a new Item</button><br/ ><br />          <div class="portlet">            <div class="portlet-header">              <h3>                <i class="fa fa-hand-o-up"></i>                Item List              </h3>            </div> <!-- /.portlet-header -->			              <div class="portlet-content">           			              <div class="table-responsive">              <table                 class="table table-striped table-bordered table-hover table-highlight"                 data-provide="datatable"                 data-display-rows="30"                data-info="true"                data-search="true"                data-length-change="false"                data-paginate="true"              >					<thead>						<tr>							<th></th>							<th data-sortable="true">Name</th>							<th data-sortable="true">Product</th>							<th></th>													</tr>					</thead>											   <tbody>				  {foreach from=$productitemData item=item}				  <tr>					<td>						{if $item.productitemimage_path neq ''}						<a href="http://{$domainData.campaign_domain}/{$item.productitemimage_path}/tny_{$item.productitemimage_code}{$item.productitemimage_extension}">							<img src="http://{$domainData.campaign_domain}/{$item.productitemimage_path}/tny_{$item.productitemimage_code}{$item.productitemimage_extension}" width="60" />						</a>						{else}							<img src="http://www.mailbok.co.za/images/no-image.jpg" width="60" />						{/if}											</td>						<td><a href="/catalogue/item/details.php?code={$item.productitem_code}">{$item.productitem_name}</a></td>						<td>{$item.product_name}</td>						<td>						<button onclick="deleteModal('{$item.productitem_code}', '', 'default'); return false;" class="btn btn-danger">Delete</button>					</td>				  </tr>				{foreachelse}				<tr><td colspan="6">No items have been added yet</td></tr>				  {/foreach}				  </tbody>                </table>              </div> <!-- /.table-responsive -->            </div> <!-- /.portlet-content -->          </div> <!-- /.portlet -->        </div> <!-- /.col -->	  </div> <!-- /.content --></div> <!-- /.container -->{include_php file='includes/footer.php'}{include_php file='includes/javascript.php'}</html>