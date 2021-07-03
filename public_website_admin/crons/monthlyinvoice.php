<?php
//ini_set('max_execution_time', 300); //300 seconds = 5 minutes
ini_set('max_execution_time', 120); //300 seconds = 1 minute

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

//error_reporting(!E_NOTICE);

/* Check for login */
//require_once 'administration/includes/auth.php';

require_once 'class/_comm.php';
require_once 'class/client.php';
require_once 'class/clientproduct.php';
require_once 'class/invoice.php';
require_once 'class/invoiceitem.php';
require_once 'class/template.php';
require_once 'class/invoiceremind.php';
require_once 'pdfcrowd/pdfcrowd.php';

$commObject 			= new class_comm();
$clientObject 			= new class_client();
$clientproductObject 	= new class_clientproduct();
$invoiceObject 			= new class_invoice();
$invoiceitemObject		= new class_invoiceitem();
$templateObject		= new class_template();
$invoiceremindObject	= new class_invoiceremind();

$clientData = $clientObject->getCurrentPayingDayClient();

if($clientData) {
	
	$error = '';
	$error .= '<b><h3>'.date('Y-m-d h:i:s').'</h3></b>';
	
	/* Get invoice template */
	$templateData = $templateObject->getByParent('invoice', 'invoice');	
	
	if($templateData) {
		
		foreach($clientData as $item) {

			$error .= '===================<br />';
			$error .= '<b>'.$item['client_name'].'</b><br />';
			$error .= $item['clientcontact_email'].'<br />';
			$error .= $item['clientcontact_name'].'<br />';
			
			/* Get client products. */
			$clientproduct = $clientproductObject->getForInvoicing($item['client_code'], 'monthly');

			if($clientproduct) {

				$attachment = '';
				
				$error .= 'Client products available:<br />';
				
				/* Invoice insert. */
				$total = 0;
				$notes = '';
				
				foreach($clientproduct as $clientitem) {
					$total += $clientitem['price_amount'];				
					$notes .= $clientitem['clientproduct_notes'].'. ';		
				}
				
				$tempData['invoice_total']	= $total;
				
				$tempData 	= array();	
				$tempData['invoice_code']					= $invoiceObject->createCode();
				$tempData['invoice_reference']			= $invoiceObject->createReference();
				$tempData['clientcontact_code']			= trim($item['clientcontact_code']);					
				$tempData['invoice_make']				= 'invoice';
				$tempData['invoice_type']					= 'monthly';
				$tempData['invoice_payment_date']	= date('Y-m-d h:i:s');	
				$tempData['invoice_notes']					= $notes;
				$tempData['template_code']				= $templateData['template_code'];
				$tempData['client_code']					= $item['client_code'];
				$tempData['company_code']				= $item['company_code'];
				$tempData['invoice_file']					= '/media/'.$item['company_reference'].'/invoices/'.$item['client_reference'].'/'.$tempData['invoice_code'].'/'.$tempData['invoice_code'].'.html';
				$tempData['invoice_paid']					= 0;
				$tempData['invoice_paid_date']			= null;
				
				/* Insert invoice. */
				$success = $invoiceObject->insert($tempData);

				if($success) {

					foreach($clientproduct  as $product) {
						$invoiceitemdata = array();
						$invoiceitemdata['invoiceitem_name']				= $product['price_name'];
						$invoiceitemdata['invoiceitem_description']		= $product['price_description'];
						$invoiceitemdata['invoiceitem_price']				= $product['price_amount'];
						$invoiceitemdata['invoice_code']						= $tempData['invoice_code'];
						
						$invoiceitemObject->insert($invoiceitemdata);
					
						$error .= 'Item: '.$product['price_name'].' - R '.$product['price_amount'].'<br />';										
					}
					
					$invoiceData = $invoiceObject->getByCode($success);

					if($invoiceData) {
						
						$invoiceitemsData = $invoiceitemObject->getByInvoice($success);		
						
						if($invoiceitemsData) {
							
							$total = 0;
							
							foreach($invoiceitemsData as $itemlist) {
								$total += $itemlist['invoiceitem_price'];				
							}
							
							$invoiceData['invoice_total']	= $total;
							
							$data						= array();
							$data['invoice_total']	= $total;
							
							$where 	= $invoiceObject->getAdapter()->quoteInto('invoice_code = ?', $invoiceData['invoice_code']);
							$success 	= $invoiceObject->update($data, $where);
						
							$smarty->assign('client', $item);
							$smarty->assign('invoiceData', $invoiceData);
							$smarty->assign('invoiceitemsData', $invoiceitemsData);
							$smarty->assign('paymentDate', $invoiceData['invoice_payment_date']);

							$html = $smarty->fetch(ltrim($invoiceData['template_file'], '/'));

							/* Save file. */
							$directory	= $_SERVER['DOCUMENT_ROOT'].'/media/'.$invoiceData['company_reference'].'/invoices/'.$invoiceData['client_reference'].'/'.$invoiceData['invoice_code'].'/';
							$filename	= $directory.$invoiceData['invoice_code'].'.html';
							$pdffile		= $directory.$invoiceData['invoice_code'].'.pdf';
							
							/* Create directory. */
							if(!is_dir($directory)) mkdir($directory, 0777, true);
								
							if(file_put_contents($filename, $html)) {
												
								$error .= '<a href="http://www.collop.co.za/media/'.$invoiceData['company_reference'].'/invoices/'.$invoiceData['client_reference'].'/'.$invoiceData['invoice_code'].'/'.$invoiceData['invoice_code'].'.html" target="_blank">View linked Invoice</a><br />';
								$error .= 'Invoice saved to database and inserted to database.<br />';
								
								try {
									/* Create pdf file. */
									$pdfObject	= new Pdfcrowd("willow_nettica", "6be184b78c92a8da33964db13d079b6e");
									
									$error .= '..... creating pdf invoice...<br />';	
									
									$pdfdata = $pdfObject->convertFile($filename);
									
									if(file_put_contents($pdffile, $pdfdata)) {
										
										$attachment = $_SERVER['DOCUMENT_ROOT'].str_replace('.html', '.pdf', $tempData['invoice_file']);						
										$error .= 'PDF successfully created.<br />';
										
										/* Send Email. */ 
										$emailData = $templateObject->getByParent('standard', 'automated');
										
										if($emailData) {
											$attachments = array();
											$attachments[] = array('name' => $invoiceData['invoice_reference'].'.pdf', 'path' => $attachment);
											$commcode = $commObject->sendInvoice($emailData['template_code'], 'Invoice for month of '.date('F Y'), $item['clientcontact_code'], $invoiceData, $attachments);
											
											if($commcode) {
												$error .= '<b>Email successfully sent</b><br />';
												
												/* Add invoice reminder record. */
												$data = null; 
												$data = array();
												$data['invoice_code'] 		= $invoiceData['invoice_code'];
												$data['clientcontact_code']	= $item['clientcontact_code'];
												$data['_comm_code'] 		= $commcode;
												
												$invoiceremindObject->insert($data);
											} else {
												$error .= '<b>Email WAS NOT sent</b><br />';
											}
										} else {
											$error .= '<b>No template for sending email created. But invoice generated.</b><br />';
											$attachment = '';										
										}
									} else {
										$error .= '<b>Could not create PDF</b><br />';
										$attachment = '';
									}
								} catch(PdfcrowdException $e) {
									$error .= "<b>Pdfcrowd Error: " . $e->getMessage().'</b><br />';
									$attachment = '';
								}				
							} else {
								$error = 'Could not upload file: '.$filename.'<br />';
								$attachment = '';
							}							
							
						} else {
							$error .= 'Items have not been add / found.<br />';
							$attachment = '';								
						}
					} else {
						$error .= 'Could not retrieve invoice.<br />';
						$attachment = '';			
					}
				} else {
					$error .= 'Could not retrieve invoice.<br />';
					$attachment = '';			
				}				
			}
			$error .= "===================<br /><br />";			
		}
		
		$commObject->sendAdmin('Monthly Invoices - '.date('F Y'), $error);	
		echo $error;
	}
}