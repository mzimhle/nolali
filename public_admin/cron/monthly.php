<?php
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Connection: close");

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';

/* Get the settings. */
$settings = parse_ini_file("config/settings.ini", true);

if(isset($settings[$_SERVER['HTTP_HOST']])) {
	$config = $settings[$_SERVER['HTTP_HOST']];
} else {
	echo 'Site configuration missing...';
	exit;
}
//include the Zend class for Authentification
require_once 'Zend/Session.php';
// Set up the namespace
$zfsession			= new Zend_Session_Namespace('CRON_SITE');
$zfsession->config	= $config;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- vendor css -->
<link href="/css/font-awesome/font-awesome.css" rel="stylesheet">
<link href="/css/ionicons/ionicons.css" rel="stylesheet">
<link href="/css/flag-icon.min.css" rel="stylesheet">
<link href="/css/datatable.css" rel="stylesheet">
<!-- Meta -->
<meta name="description" content="Yam Accounting Solution">
<meta name="author" content="Yam Accounting Solution">
<title>Yam Accounting Solution</title>
<!-- Meta -->
<!-- Slim CSS -->
<link rel="stylesheet" href="/css/slim.css">
<link href="/css/jquery.dataTables.css" rel="stylesheet">
<link href="/css/select2.min.css" rel="stylesheet">	  
<link rel="stylesheet" href="/css/jquery-ui.css">
<link href="/css/summernote-bs4.css" rel="stylesheet">
</head>
  <body>
	<div class="slim-header">
  <div class="container">
	<div class="slim-header-left">
	  <h2 class="slim-logo"><a href="/">YamAccounting</a></h2>
	</div><!-- slim-header-left -->
  </div><!-- container -->
</div><!-- slim-header -->
    <div class="slim-mainpanel">
      <div class="container">
        <div class="slim-pageheader">
			<ol class="breadcrumb slim-breadcrumb">
				<li class="breadcrumb-item active" aria-current="page">Monthly Invoices</li>
				<li class="breadcrumb-item"><a href="/">Cron Job</a></li>
				<li class="breadcrumb-item"><a href="/">Home</a></li>
			</ol>
			<h6 class="slim-pagetitle">Monthly Invoices</h6>
        </div><!-- slim-pageheader -->
        <div class="section-wrapper card card-latest-activity mg-t-20">
			<label class="section-title">Monthly invoices for <?php echo date('Y-m-d'); ?></label>
			<p class="mg-b-20 mg-sm-b-10">Below is the list of invoices that have been generated today.</p>		
            <div class="row">
                <div class="col-md-12 col-lg-12 mg-t-20 mg-md-t-0-force">
                    <form action="/invoice/monthly/item.php?id=1" method="POST">		  
                        <table class="table table-bordered" width="100%">	
                            <thead>
                                <tr>								
                                    <td width="100%">Output</td>
                                </tr>
                            </thead>
                            <tbody>
								<tr>
									<?php
									
									require_once 'class/invoicemonthly.php';
										
									$invoicemonthlyObject	= new class_invoicemonthly();

									$invoicemonthlyData = $invoicemonthlyObject->getForTodayList();

									if($invoicemonthlyData) {

										require_once 'class/invoice.php';
										require_once 'class/_comm.php';
										
										$invoiceObject	= new class_invoice();	
										$commObject		= new class_comm();
										
										foreach($invoicemonthlyData as $item) {
											$output = '==============================================<br />';
											// Create invoice with this invoice.
											$data							= array();								
											$data['template_code']		    = 'INVOICE';	
											$data['invoice_type']		    = 'MONTHLY';	
											$data['invoice_date_payment']   = date('Y-m-d');
											$data['participant_id']         = $item['participant_id'];   
											$data['bankentity_id']         	= $item['bankentity_id']; 
											$data['invoicemonthly_id']		= $item['invoicemonthly_id'];
											$data['invoice_code']			= $invoiceObject->createCode($item['entity_code']);
											$success						= $invoiceObject->insert($data);

											if($success) {
												$output .= '<span class="success">INVOICE: '.$success.' : Added</span><br />';
												/// Get created invoice
												$invoiceData = $invoiceObject->getForTodayIdMonthly($success, $item['invoicemonthly_id']);
												/// Check if the file is there for the template.
												if(is_file($zfsession->config['path'].'/'.ltrim($invoiceData['template_file'], '/'))) {
													$output .= '<span class="success">INVOICE: '.$success.' : Invoice file exists</span><br />';
													/* Add the smarty variables. */		
													$smarty->assign('invoiceitemData', $item['items']);
													/* Get the invoice information. */
													$smarty->assign('invoiceData', $invoiceData);
													/* Fetch the file. */
													$html = $smarty->fetch($zfsession->config['path'].'/'.ltrim($invoiceData['template_file'], '/'));
													$html = str_replace('[mediapath]', $zfsession->config['site'].'/media/template/'.strtolower($invoiceData['template_id']).'/media/', $html);
													/* Save file. */
													$directory	= $zfsession->config['path'].'/media/invoice/'.$invoiceData['invoice_id'].'/';
													$filename	= $directory.$invoiceData['invoice_id'].'.html';
													$pdffile	= $directory.$invoiceData['invoice_id'].'.pdf';
													/* Create directory. */
													if(!is_dir($directory)) mkdir($directory, 0777, true);

													if(file_put_contents($filename, $html)) {
														$output .= '<span class="success">INVOICE: '.$success.' : HTML File created</span><br />';
														/* Update file in invoice. */	
														$data						= array();
														$data['invoice_file_html']	= '/media/invoice/'.$invoiceData['invoice_id'].'/'.$invoiceData['invoice_id'].'.html';
														/* Update html file. */
														$where	= $invoiceObject->getAdapter()->quoteInto('invoice_id = ?', $invoiceData['invoice_id']);
														$invoiceObject->update($data, $where);
														$output .= '<span class="success">INVOICE: '.$success.' : HTML File updated on the database</span><br />';
														try {
															/* Create pdf file. */
															$pdfdata = $invoiceObject->_PDFCROWD->_PDF->convertFile($filename);							
															$output .= '<span class="success">INVOICE: '.$success.' : PDF FILE created</span><br />';
															/* Upload the pdf data. */
															if(file_put_contents($pdffile, $pdfdata)) {
																$output .= '<span class="success">INVOICE: '.$success.' : PDF FILE saved in file system</span><br />';
																/* Update file in invoice. */	
																$data						= array();
																$data['invoice_file_pdf']	= '/media/invoice/'.$invoiceData['invoice_id'].'/'.$invoiceData['invoice_id'].'.pdf';
																/* Update pdf file. */
																$where	= $invoiceObject->getAdapter()->quoteInto('invoice_id = ?', $invoiceData['invoice_id']);
																$invoiceObject->update($data, $where);
																$output .= '<span class="success">INVOICE: '.$success.' : PDF FILE saved in database</span><br />';
																$invoiceData['invoice_file_html']	= '/media/invoice/'.$invoiceData['invoice_id'].'/'.$invoiceData['invoice_id'].'.html';
																$invoiceData['invoice_file_pdf'] 	= '/media/invoice/'.$invoiceData['invoice_id'].'/'.$invoiceData['invoice_id'].'.pdf';
															} else {
																$output .= '<span class="error">INVOICE: '.$success.' : Could not create pdf</span><br />';
															}
														} catch(Exception $e)  {
															$output .= '<span class="error">INVOICE: '.$success.' : Pdfcrowd Error: Could not create PDF file.</span><br />';
														}				
													} else {
														$output .= '<span class="error">INVOICE: '.$success.' : Could not upload file: '.$filename.'</span><br />';	
													}			
												} else {
													$output .= '<span class="error">INVOICE: '.$success.' : Invoice template does not exist</span><br />';		
												}

												if(isset($pdffile) && is_file($pdffile)) {
													/* Get invoice template */
													$templateData = $commObject->_template->getByEntity($item['entity_id'], 'EMAIL', 'MESSAGE_INVOICE');

													if($templateData) {
														$recipient							= array();
														$recipient['recipient_id'] 			= $invoiceData['invoice_id'];
														$recipient['recipient_name'] 		= $invoiceData['participant_name'];
														$recipient['recipient_cellphone'] 	= $invoiceData['participant_cellphone'];
														$recipient['recipient_email']		= $invoiceData['participant_email'];
														$recipient['recipient_type']		= 'INVOICE';
														$recipient['recipient_from_name']	= $invoiceData['company_name'];
														$recipient['recipient_from_email']	= $invoiceData['company_contact_email'];
														$recipient['recipient_message']		= '';
														$recipient['recipient_media'] 		= $zfsession->config['site'].'/media/template/'.strtolower($invoiceData['template_id']).'/media/';
														/* Add attachment. */
														$attach		= array();
														$attach[]	= $zfsession->config['path'].$invoiceData['invoice_file_pdf'];
														/* Check if all is good. */
														if($commObject->sendEMAIL(array_merge($invoiceData, $recipient, $templateData), $attach)) {
															$output .= '<span class="success">INVOICE: '.$success.' : Email was successfully sent</span><br />';
														} else {
															$output .= '<span class="error">INVOICE: '.$success.' : Email was not sent, please try again or request developer</span><br />';
														}
													} else {
														$output .= '<span class="error">INVOICE: '.$success.' : There is no tempate for sending the mail.</span><br />';															
													}
												} else {
													$output .= '<span class="error">INVOICE: '.$success.' : PDF FILE not created to send out email</span><br />';	
												}
											} else {
												// Delete the invoice.
											}
										}
										echo '<td>'.$output.'</td>';
									}
									?>
								</tr>
                            </tbody>
                        </table>
                        <br />			
                    </form>
                </div><!-- col-4 -->
            </div><!-- row -->
        </div><!-- section-wrapper -->
      </div><!-- container -->
    </div><!-- slim-mainpanel -->
  </body>
</html>