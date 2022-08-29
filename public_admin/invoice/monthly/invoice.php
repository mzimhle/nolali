<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/** Standard includes*/
require_once 'config/database.php';
require_once 'config/smarty.php';
/*** Check for login */
require_once 'includes/auth.php';

require_once 'class/invoice.php';
require_once 'class/invoicemonthly.php';

$invoiceObject = new class_invoice();
$invoicemonthlyObject = new class_invoicemonthly();

if (!empty($_GET['id']) && $_GET['id'] != '') {
	
	$id = trim($_GET['id']);
	
	$invoicemonthlyData = $invoicemonthlyObject->getById($id);
	
	if($invoicemonthlyData) {
		$smarty->assign('invoicemonthlyData', $invoicemonthlyData);
	} else {
		header('Location: /invoice/monthly/');
		exit;	
	}
} else {
	header('Location: /invoice/monthly/');
	exit;
}

/* Setup Pagination. */
if(isset($_GET['action']) && trim($_GET['action']) == 'search') {

	$filter	= array();
	$csv	= 0;
	$start 	= isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'] : 0;
	$length	= isset($_REQUEST['iDisplayLength']) ? $_REQUEST['iDisplayLength'] : 20;

	if(isset($_REQUEST['filter_search']) && trim($_REQUEST['filter_search']) != '') $filter[] = array('filter_search' => trim($_REQUEST['filter_search']));
	$filter[] = array('filter_monthly' => $invoicemonthlyData['invoicemonthly_id']);

	$invoiceData = $invoicemonthlyObject->paginateInvoices($start, $length, $filter);

	$invoices = array();

	if($invoiceData) {
		for($i = 0; $i < count($invoiceData['records']); $i++) {

			$item = $invoiceData['records'][$i];
			$invoices[$i] = array(
				$item['invoice_file_pdf'] == '' ? ($item['invoice_file_html'] == '' ? $item['invoice_date_payment'] : '<a href="'.$zfsession->config['site'].$item['invoice_file_html'].'" target="_blank">'.$item['invoice_date_payment'].'</a>') : '<a href="'.$zfsession->config['site'].$item['invoice_file_pdf'].'" target="_blank">'.$item['invoice_date_payment'].'</a>',				
				$item['participant_name'].' '.$item['participant_surname'],
				$item['participant_cellphone'],
				'<span" '.((int)$item['invoice_paid'] == 1 ? 'class="success"' : 'class="error"').'>'.$item['invoice_code'].'</span>',
				'R '.number_format($item['invoice_amount_total'],2,",","."),
				'R '.number_format($item['invoice_amount_paid'],2,",","."),
				'R '.number_format($item['invoice_amount_due'],2,",","."),
				'<button type="button" class="btn" onclick="javascript:openInvoiceModal(\''.$item['invoice_id'].'\');">Send</button>'
			);
		}

		$response['sEcho']					= $_REQUEST['sEcho'];
		$response['iTotalRecords']			= $invoiceData['displayrecords'];		
		$response['iTotalDisplayRecords']	= $invoiceData['count'];
		$response['aaData']					= $invoices;
	} else {
		$response['result']		= false;
		$response['message']	= 'There are no items to show.';			
	}

	echo json_encode($response);
	die();
}

$smarty->display('invoice/monthly/invoice.tpl');

?>