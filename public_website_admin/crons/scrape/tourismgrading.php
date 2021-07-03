<?php

//ini_set('max_execution_time', 300); //300 seconds = 5 minutes
ini_set('max_execution_time', 300); //300 seconds = 1 minute

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes  */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'global_functions.php';

require_once 'scrape/simple_html_dom.php';
require_once 'class/spam.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE);

function getPage($link) {
	/* Setup curl. */
    $options = array(
        CURLOPT_RETURNTRANSFER 	=> true,     // return web page
        CURLOPT_HEADER         		=> false,    // don't return headers
        CURLOPT_FOLLOWLOCATION 	=> true,     // follow redirects
        CURLOPT_ENCODING       		=> "",       // handle all encodings
        CURLOPT_USERAGENT      		=> "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322", // who am i
        CURLOPT_AUTOREFERER    	=> true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT	=> 120,      // timeout on connect
        CURLOPT_TIMEOUT        		=> 120,      // timeout on response
        CURLOPT_MAXREDIRS      		=> 10,       // stop after 10 redirects
    );

    $curl = curl_init($link);
    curl_setopt_array($curl, $options);
    $urlContent = curl_exec($curl);
    curl_close($curl);
	
	/* Clean it up. */
	$curl = NULL; UNSET($curl);
	
	return  $urlContent;
}

$links 		= array();
$spamObject	= new class_spam();
$page		= rand(1, 100);

$page = isset($_GET['page']) & (int)trim($_GET['page']) != 0 ? (int)trim($_GET['page']) : 1;

for($i = 270; $i < 280; $i++) {
	
	$page = $i;

	$link = "http://directory.southafrica.net/api/v1/product_entries?related-tgcsa_member-status=active&page=$page&per-page=20";
	echo '===========================================================================';
	echo $i.'<br />';
	echo '<b>'.$link.'</b><br /><br />';

	$urlContent = getPage($link);

	$array = json_decode($urlContent);

	foreach($array->list as $item) {
			
		if(validateEmail($item->email) != '') {
			$data = array();
			$data['fk_spamType_id'] 	= 'GTH';				
			$data['spam_name'] 			= $item->title;		
			$data['spam_contact'] 		= $item->contact_first_name.' '.$item->contact_last_name;
			$data['spam_email'] 		= validateEmail($item->email);
			$data['spam_number'] 		= $item->phone_code.$item->phone_number;	
			$data['spam_cell'] 			= $item->mobile_code.$item->mobile_number;
			$data['spam_fax'] 			= $item->fax_code.$item->fax_number;		
			$data['spam_address'] 		= $item->physical_address_1.', '.$item->physical_address_2.', '.$item->physical_suburb.', '.$item->physical_postal_code;
			$data['spam_area'] 			= $item->physical_suburb.', '.$item->location[0]->full_name;
			$data['spam_description']	= $item->full_description;
			$data['spam_link'] 			= $item->website;
			$data['area_code'] 			= null;
			$data['spam_text']			= json_encode($item);
			$data['spam_category']		= 'spam';
			$data['spam_referer']		= $link;

			$linkData = $spamObject->getByEmail($data['spam_email']);

			if(!$linkData) {
				if($spamObject->insert($data)) {
					echo '<span style="color: green;">Inserted: '.$data['spam_name'].'</span><br />';
				} else {
					echo '<span style="color: red;">Error inserting '.$data['spam_name'].'</span><br />';
				}
			} else {
				
				$where 	= $spamObject->getAdapter()->quoteInto('pk_spam_id = ?', $linkData['pk_spam_id']);
				$spamObject->update($data, $where);
				echo 'Updated '.$linkData['spam_name'].' -----> <b>'.$data['spam_email'].'</b><br />';
			}			
		}
		
	}	
}


?>