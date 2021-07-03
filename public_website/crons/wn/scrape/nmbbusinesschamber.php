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

$links = array();
$links[] = 'http://nmbbusinesschamber.co.za/categories/120/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/106/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/104/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/117/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/116/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/133/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/134/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/108/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/103/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/129/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/125/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/135/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/107/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/102/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/115/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/109/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/123/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/98/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/124/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/113/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/113/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/118/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/127/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/101/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/114/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/114/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/111/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/96/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/100/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/95/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/128/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/132/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/126/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/99/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/121/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/119/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/137/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/122/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/122/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/130/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/131/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/105/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/136/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/110/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/138/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/97/members';
$links[] = 'http://nmbbusinesschamber.co.za/categories/112/members';

//$link = $links[rand(0,1)];
$link = $links[rand(0, 47)];

/* Object. */
if(trim($link) != '') {
	
	echo '<b>'.$link.'</b><br /><br />';
	
    $urlContent = getPage($link);

	for($i = 0; $i < 20; $i++) {
		/* Get the first DIV in the results page. */
		$maintable = str_get_html($urlContent)->find('.m ', $i)->innertext;
		$success 	= true;
		
		if($maintable) {
			
			$data = array();
			$data['fk_spamType_id'] 	= 'NMB';
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
			$data['spam_referer']			= $link;
			
			/* Get email number. */
			$companyemail = str_get_html($maintable)->find('dl dd a', 0)->innertext;
			$matches = array();
			$pattern = '/([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+/';
			preg_match($pattern,$companyemail,$matches);
			
			if(isset($matches[0])) {
				if(preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', trim($matches[0]))) {
					$data['spam_email'] = trim($matches[0]);
					$data['spam_link'] = validateDomain(substr(strrchr($data['spam_email'], "@"), 1)); 

				} else { 
					$success = false; 
				}
			} else {
				$success = false;
			}
			
			/* End email address. */	
			if($success) {
				/* Get company name. */
				$companyname = str_get_html($maintable)->find('h3', 0)->innertext;				
				if($companyname) {					
					$data['spam_name']	= $companyname;				
				}
				
				/* Phones *************************************************************************************/																				
				$regexp = '/<dt>Phone Number<\/dt><dd>(.*?)<\/dd>/';					
				preg_match_all($regexp, $maintable, $numbermatches);
				$data['spam_number']	= isset($numbermatches[1][0]) && trim($numbermatches[1][0]) != '' ? onlyAlphaNumeric(trim($numbermatches[1][0])) : null;					
				/*********************************************************************************************/						
				/* Address *************************************************************************************/																				
				$regexp = '/<dt>Address<\/dt><dd>(.*?)<\/dd>/';					
				preg_match_all($regexp, $maintable, $addressmatches);
				$data['spam_address']	= isset($addressmatches[1][0]) && trim($addressmatches[1][0]) != '' ? trim($addressmatches[1][0]) : null;					
				/*********************************************************************************************/		
				/* Website *************************************************************************************/																				
				$regexp = '/<dt>Website<\/dt><dd>(.*?)<\/dd>/';
				preg_match_all($regexp, $maintable, $websitematches);
				$data['spam_link']	= isset($websitematches[1][0]) && trim($websitematches[1][0]) != '' ? validateDomain(trim($websitematches[1][0])) : $data['spam_link'];
				/*********************************************************************************************/	
				 $data['spam_text']	= $maintable;
				 
				$description = str_get_html($maintable)->find('.clear', 0)->innertext;
				$data['spam_description'] = $description;
				
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
				
			} else {
				echo '<br /><b>No Email</b><br />';
			}	
		}
	}
}

?>