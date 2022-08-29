<?php
ini_set('max_execution_time', 1200); //300 seconds = 5 minutes
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');
/*** Standard includes */
require_once 'config/database.php';
require_once 'config/smarty.php';
/** Check for login */
require_once 'includes/auth.php';
/* Class files */
require_once 'class/participant.php';
/* Class objects. */
$participantObject  = new class_participant(); 

if(isset($_GET['delete_id'])) {
	
	$errorArray				= array();
	$errorArray['error']	= '';
	$errorArray['result']	= 0;	
	$formValid				= true;
	$code					= trim($_GET['delete_id']);
		
	if($errorArray['error']  == '' && $errorArray['result']  == 0 ) {
	
		$data					= array();
		$data['participant_deleted']	= $status;
		
		$where		= $participantObject->getAdapter()->quoteInto('participant_id = ?', $code);
		$success	= $participantObject->update($data, $where);	

		if($success) {
			$errorArray['error']	= '';
			$errorArray['result']	= 1;			
		} else {
			$errorArray['error']	= 'Could not update, please try again.';
			$errorArray['result']	= 0;				
		}
	}

	echo json_encode($errorArray);
	exit;
}

/* Setup Pagination. */
if(isset($_GET['action']) && trim($_GET['action']) == 'search') {

	$filter	= array();
	$csv	= 0;
	$start 	= isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'] : 0;
	$length	= isset($_REQUEST['iDisplayLength']) ? $_REQUEST['iDisplayLength'] : 20;

	if(isset($_REQUEST['filter_search']) && trim($_REQUEST['filter_search']) != '') $filter[] = array('filter_search' => trim($_REQUEST['filter_search']));
	if(isset($_REQUEST['filter_csv']) && trim($_REQUEST['filter_csv']) != '') $filter[] = array('filter_csv' => trim($_REQUEST['filter_csv']));
    $csv = isset($_REQUEST['filter_csv']) ? (int)trim($_REQUEST['filter_csv']) : 0;

    if(!$csv) {
        $participantData = $participantObject->paginate($start, $length, $filter);
    } else {
        $participantData = $participantObject->getCSV($filter);
        // if($csv == 1) {
		if($csv == -1) {
            $data = '';
            if($participantData) {
                $data = implode(',', $participantData);
            }
            $participantObject->download_send_headers("participant_export_" . date("Y-m-d") . ".csv");
            echo $data;
            die();
        } else {
            $participant = array();
            $row = "Company, Title, Name, Surname, Cellphone, Fax, Email Address\r\n";
            if($participantData) {
                for($i = 0; $i < count($participantData); $i++) {
                    $item = $participantData[$i];

                    $participant[$i] = array(
                        str_replace(',', ' ',$item['company_name']),
                        str_replace(',', ' ',$item['title_name']),
                        str_replace(',', ' ',$item['participant_name']),
                        str_replace(',', ' ',$item['participant_surname']),
                        str_replace(',', ' ',$item['participant_cellphone']),
                        str_replace(',', ' ',$item['participant_email'])
                    );
                }
                foreach ($participant as $data) {
                    $row .= implode(', ', $data)."\r\n";
                }			
            }
            $participantObject->download_send_headers("participant_export_" . date("Y-m-d") . ".csv");
            echo $row;
            die();
        }
    }

	$participants = array();

	if($participantData) {
		for($i = 0; $i < count($participantData['records']); $i++) {
			$item = $participantData['records'][$i];
			$participants[$i] = array(
				'<a href="javascript:addParticipantModal('.$item['participant_id'].');" class="'.((int)$item['participant_active'] == 1 ? 'success' : 'error').'">'.trim($item['participant_name']).'</a>',
                $item['participant_email'],
                $item['participant_cellphone'],   
                $item['participant_address'],  				
                "<button class='btn' onclick=\"deleteModal('".$item['participant_id']."', '1', 'default'); return false;\">Delete</button>"				
			);
		}

		$response['sEcho']					= $_REQUEST['sEcho'];
		$response['iTotalRecords']			= $participantData['displayrecords'];		
		$response['iTotalDisplayRecords']	= $participantData['count'];
		$response['aaData']					= $participants;
	} else {
		$response['result']		= false;
		$response['message']	= 'There are no items to show.';			
	}

	echo json_encode($response);
	die();
}

$smarty->display('participant/default.tpl');
?>
