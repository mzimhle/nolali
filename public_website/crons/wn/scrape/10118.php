<?php

//ini_set('max_execution_time', 300); //300 seconds = 5 minutes
ini_set('max_execution_time', 120); //300 seconds = 1 minute

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes  */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'scrape/simple_html_dom.php';
require_once 'class/ADMIN/spam.php';
require_once 'global_functions.php';

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

$links 				= array();
$spamObject		= new class_spam();

$numbers			= array(1);

$randomletter	= $spamObject->randomLetter();
$page				= rand(1, 30);

$page = 5;
$array = array();

for($i = 0; $i < 3; $i++) {
	$array[] = $page;
	$page += 4;
}

$link = 'http://www.10118.biz/browse-directory/letter/'.randomAlphabet().'/page-'.$page.'-5/itemid-173';

/* Object. */
if(trim($link) != '') {
	
	echo '<b>'.$link.'</b><br /><br />';
	
    $urlContent = getPage($link);

	for($i = 0; $i < 20; $i++) {
		/* Get the first DIV in the results page. */
		$maintable = str_get_html($urlContent)->find('.listing-summary', $i)->innertext;
		$success 	= true;
		
		if($maintable) {
		
			$data = array();
			$data['fk_spamType_id'] 	= '101';
			$data['spam_name'] 			= null;
			$data['spam_contact'] 		= null;
			$data['spam_number'] 		= null;
			$data['spam_link'] 				= null;
			$data['spam_address'] 		= null;
			$data['spam_fax'] 				= null;
			$data['spam_cell'] 				= null;
			$data['spam_email']			= null;		
			$data['spam_text']				= null;
			$data['spam_description']	= null;		
			$data['spam_referer']		= $link;
			
			
			$filedsdata = str_get_html($maintable)->find('.fields', 0)->innertext;
			
			for($z = 0; $z < 5; $z++) {
				$outputdata = str_get_html($filedsdata)->find('.fieldRow .caption', $z)->innertext;
				if($outputdata == 'Telephone') {
					$data['spam_number'] = onlyAlphaNumeric(str_get_html($filedsdata)->find('.fieldRow .output', $z)->innertext);	
				}
				if($outputdata == 'Fax') {
					$data['spam_fax'] = onlyAlphaNumeric(str_get_html($filedsdata)->find('.fieldRow .output', $z)->innertext);	
				}				
				if($outputdata == 'E-mail') {
					$temp = html_entity_decode( html_entity_decode(str_get_html($filedsdata)->find('.fieldRow .output', $z)->innertext));					
					$matches = array();
					$pattern = '/([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+/';
					preg_match($pattern,$temp,$matches);							
					$data['spam_email'] = isset($matches[0]) && trim($matches[0]) != '' ? $matches[0] : null;
				}
			}
				
			if(preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', trim($data['spam_email'] ))) {
				$data['spam_email']	= trim($matches[0]);
				$data['spam_link']		= validateDomain(substr(strrchr($data['spam_email'], "@"), 1)); 
			} else {
				$success = false; 
			}
			
			/* End email address. */	
			if($success) {
				/* Get company name. */
				$companyname = str_get_html($maintable)->find('h3 a', 1)->innertext;				
				if($companyname) {
					$data['spam_name']	= $companyname;
				}				
				/* Get link to thiis item within this site. */
				$companylink = str_get_html($maintable)->find('.website a', 0)->innertext;				
				if($companylink) {
					$data['spam_link']	= validateDomain(trim($companylink)) != '' ? validateDomain(trim($companylink)) : $data['spam_link'];
				}
				$address = str_get_html($maintable)->find('.address', 0)->innertext;				
				if($address) {
					$data['spam_address']	= strip_tags($address);
				}					
				/* Check description. */
				$companydescription = str_get_html($maintable)->find('p', 0)->innertext;	
				
				if($companydescription) {
					$data['spam_description']	= preg_replace('!\s+!'," ", strip_tags($companydescription));	
				}			

				if($success == true) {
				
					$linkData = $spamObject->getByEmail($data['spam_email']);

					if(!$linkData) {
						if($spamObject->insert($data)) {
							echo '<br />Inserted: '.$data['spam_name'].'<br />';
						} else {
							echo '<br />Error inserting '.$data['spam_name'].'<br />';
						}
					} else {
						echo '<br />Duplicate inserting '.$linkData['spam_name'].' -----> <b>'.$data['spam_email'].'</b><br />';
					}			
				}
			} else {
				echo '<br /><b>No Email</b><br />';
			}	
		}
	}	
}

?>