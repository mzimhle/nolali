<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<title>{$domainData.campaign_name} Management System</title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	{include_php file='includes/css.php'}
  <!-- Plugin CSS -->
  <link rel="stylesheet" href="/library/javascript/plugins/fullcalendar/fullcalendar.css">	
</head>
<body>
{include_php file='includes/header.php'}
<div class="container">
  <div class="content">
    <div class="content-container">  
      <div class="row">
        <div class="col-md-12">
          <div class="portlet">
            <div class="portlet-header">
              <h3><i class="fa fa-calendar"></i>Full Calendar</h3>
            </div> <!-- /.portlet-header -->
            <div class="portlet-content">
				<div id="full-calendar"></div> <!-- /#full-calendar -->             
            </div> <!-- /.portlet-content -->
          </div> <!-- /.portlet -->
        </div> <!-- /.col-md-8 -->
      </div> <!-- /.row -->
    </div> <!-- /.content-container -->
  </div> <!-- /.content -->
</div> <!-- /.container -->
<script type="text/javascript" language="javascript" src="/feeds/calendar.php"></script>
{include_php file='includes/footer.php'}
{include_php file='includes/javascript.php'}
</html>
