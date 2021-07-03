<?php
/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/**
 * Standard includes
 */
require_once 'config/database.php';
require_once 'config/smarty.php';

/**
 * Check for login
 */
require_once 'includes/auth.php';

/* objects. */
require_once 'class/campaign.php';
require_once 'class/campaigntype.php';

$campaignObject 	= new class_campaign();
$campaigntypeObject	= new class_campaigntype();

if (isset($_GET['code']) && trim($_GET['code']) != '') {
	
	$campaigncode = trim($_GET['code']);
	
	$campaignData = $campaignObject->getByCode($campaigncode);
	
	if($campaignData) {
		$smarty->assign('campaignData', $campaignData);
	} else {
		header('Location: /campaign/');
		exit;
	}
}

$campaigntypePairs = $campaigntypeObject->pairs();
if($campaigntypePairs) $smarty->assign('campaigntypePairs', $campaigntypePairs);

/* Check posted data. */
if(count($_POST) > 0) {
	$errorArray		= array();
	$data 			= array();
	$formValid		= true;
	$success		= NULL;
	$areaByName		= NULL;
	
	if(isset($_POST['campaign_name']) && trim($_POST['campaign_name']) == '') {
		$errorArray['campaign_name'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['campaign_company']) && trim($_POST['campaign_company']) == '') {
		$errorArray['campaign_company'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['campaign_contact_name']) && trim($_POST['campaign_contact_name']) == '') {
		$errorArray['campaign_contact_name'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['campaign_contact_surname']) && trim($_POST['campaign_contact_surname']) == '') {
		$errorArray['campaign_contact_surname'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['campaign_domain']) && trim($_POST['campaign_domain']) == '') {
		$errorArray['campaign_domain'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['campaign_domain_admin']) && trim($_POST['campaign_domain_admin']) == '') {
		$errorArray['campaign_domain_admin'] = 'required';
		$formValid = false;		
	}
	
	if(isset($_POST['campaigntype_code']) && trim($_POST['campaigntype_code']) == '') {
		$errorArray['campaigntype_code'] = 'required';
		$formValid = false;		
	}
	
	/* Check email. */	
	if(isset($_POST['campaign_email']) && trim($_POST['campaign_email']) != '') {
		if($campaignObject->validateEmail(trim($_POST['campaign_email'])) == '') {
			$errorArray['campaign_email'] = 'Your email address is not valid';
			$formValid = false;	
		}
	} else {
		$errorArray['campaign_email'] = 'Please add email address';
		$formValid = false;		
	}
	
	if(isset($_POST['campaign_telephone']) && trim($_POST['campaign_telephone']) != '') {
		if($campaignObject->validateNumber(trim($_POST['campaign_telephone'])) == '') {
			$errorArray['campaign_telephone']= 'Please add a valid telephone number';
			$formValid = false;
		}
	}
	
	if(isset($_POST['campaign_cell']) && trim($_POST['campaign_cell']) != '') {
		if($campaignObject->validateNumber(trim($_POST['campaign_cell'])) == '') {
			$errorArray['campaign_cell']= 'Please add a valid cell number';
			$formValid = false;
		}
	}
	
	if(isset($_POST['campaign_fax']) && trim($_POST['campaign_fax']) != '') {
		if($campaignObject->validateNumber(trim($_POST['campaign_fax'])) == '') {
			$errorArray['campaign_fax']= 'Please add a valid fax number';
			$formValid = false;
		}
	}
	
	if(isset($_POST['areapost_code']) && trim($_POST['areapost_code']) == '') {
		$errorArray['areapost_code'] = 'required';
		$formValid = false;		
	}
	
	if(count($errorArray) == 0 && $formValid == true) {
		
		$data 	= array();		
		$data['campaign_name'] 								= trim($_POST['campaign_name']);
		$data['campaign_domain'] 								= trim($_POST['campaign_domain']);
		$data['campaign_domain_admin'] 					= trim($_POST['campaign_domain_admin']);
		$data['campaign_description'] 						= trim($_POST['campaign_description']);	
		$data['campaign_latitude']								= trim($_POST['campaign_latitude']);
		$data['campaign_longitude'] 							= trim($_POST['campaign_longitude']);		
		$data['areapost_code'] 									= trim($_POST['areapost_code']);				
		$data['campaign_fax'] 									= trim($_POST['campaign_fax']);	
		$data['campaign_telephone'] 							= trim($_POST['campaign_telephone']);
		$data['campaign_email'] 								= trim($_POST['campaign_email']);
		$data['campaign_address'] 							= trim($_POST['campaign_address']);				
		$data['campaign_cell'] 									= trim($_POST['campaign_cell']);		
		$data['campaign_contact_name'] 					= trim($_POST['campaign_contact_name']);	
		$data['campaign_contact_surname'] 				= trim($_POST['campaign_contact_surname']);	
		$data['campaign_company'] 							= trim($_POST['campaign_company']);	
		$data['campaign_registration_number'] 			= trim($_POST['campaign_registration_number']);	

		$data['campaign_bankaccount_holder'] 			= trim($_POST['campaign_bankaccount_holder']);	
		$data['campaign_bankaccount_bank'] 				= trim($_POST['campaign_bankaccount_bank']);	
		$data['campaign_bankaccount_number'] 			= trim($_POST['campaign_bankaccount_number']);	
		$data['campaign_bankaccount_branchcode'] 	= trim($_POST['campaign_bankaccount_branchcode']);	
		$data['campaign_vat'] 									= trim($_POST['campaign_vat']);
		
		$data['campaign_facebook'] 							= trim($_POST['campaign_facebook']);
		$data['campaign_twitter'] 								= trim($_POST['campaign_twitter']);
		$data['campaign_google'] 								= trim($_POST['campaign_google']);
		$data['campaign_linkedIn'] 							= trim($_POST['campaign_linkedIn']);
		$data['campaign_blog'] 									= trim($_POST['campaign_blog']);
		
		if(isset($campaignData)) {
		
			/*Update. */
			$where		= $campaignObject->getAdapter()->quoteInto('campaign_code = ?', $campaignData['campaign_code']);
			$success	= $campaignObject->update($data, $where);
			
		} else {
			
			$campaigntypeData = $campaigntypeObject->getByCode(trim($_POST['campaigntype_code']));
			
			if($campaigntypeData) {
			
				$data['campaign_code'] 			= $campaignObject->createReference();				
				$data['campaign_directory']	= $campaigntypeData['campaigntype_directory'].$data['campaign_code'];
				$data['campaigntype_code']	= $campaigntypeData['campaigntype_code'];

				/* Create root folder. */
				mkdir(realpath(__DIR__.'/../../').$data['campaign_directory'], 0777);
				
				/* Create media folder. */
				$mediaDir	= realpath(__DIR__.'/../../'.$root).$data['campaign_directory'].'/media';
				
				if(!is_dir($mediaDir)) mkdir($mediaDir, 0777);
				
				$success = $campaignObject->insert($data);		
				
			} else {
				$errorArray['campaigntype_code'] = 'Campaign type selected does not exist.';
			}			
		}
		
		if(count($errorArray) == 0) {
			header('Location: /campaign/');				
			exit;		
		}		
	}

	/* if we are here there are errors. */
	$smarty->assign('errorArray', $errorArray);	
}

$smarty->display('campaign/details.tpl');

?>