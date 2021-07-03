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
$page				= rand(1, 30)*10;

$links = array();
$links[] = 'http://www.brabys.com/name/'.$randomletter.'/gauteng/'.$page;
$links[] = 'http://www.brabys.com/name/'.$randomletter.'/western-cape/'.$page;
//$links[] = 'http://www.brabys.com/name/'.$randomletter.'/eastern-cape/'.$page;
//$links[] = 'http://www.brabys.com/name/'.$randomletter.'/free-state/'.$page;
//$links[] = 'http://www.brabys.com/name/'.$randomletter.'/kwazulu-natal/'.$page;
//$links[] = 'http://www.brabys.com/name/'.$randomletter.'/limpopo/'.$page;
//$links[] = 'http://www.brabys.com/name/'.$randomletter.'/mpumalanga/'.$page;
//$links[] = 'http://www.brabys.com/name/'.$randomletter.'/north-west/'.$page;
//$links[] = 'http://www.brabys.com/name/'.$randomletter.'/northern-cape/'.$page;

$link = $links[rand(0,1)];


/* Object. */
if(trim($link) != '') {	
	
	echo '<b>'.$link.'</b><br /><br />';
    $urlContent = getPage($link);

	/* Get the first DIV in the results page. */
	$maintable = str_get_html($urlContent)->find('.catHolder', 0)->innertext;

	if($maintable) {
		
		$counter = 0;

		$spamArray = array();

		$regexp = '/http?:\/\/www\.brabys\.com\/business\/(.*?)"/'; 

		preg_match_all($regexp, $maintable, $matches);

		for($i = 0; $i < count($matches[0]); $i++) {
			
			$link			= str_replace('"', '', $matches[0][$i]);	
		
			$success	= true;
			$data = null;
			
			$data = array();
			$data['fk_spamType_id'] 	= 'BRY';
			$data['spam_name'] 			= null;
			$data['spam_contact'] 		= null;
			$data['spam_number'] 		= null;
			$data['spam_link'] 			= null;
			$data['spam_address'] 		= null;
			$data['spam_fax'] 				= null;
			$data['spam_cell'] 				= null;
			$data['spam_email']			= null;		
			$data['spam_text']				= null;		
			$data['spam_referer']		= $link;

			$linkContent = getPage($link);

			if($linkContent) {

				/* Get name of the company. *************************************************************************************/
				$regexp = '/<title>(.*?)- Brabys Business Directory<\/title>/';

				preg_match_all($regexp, $linkContent, $titlematches);

				if(isset($titlematches[1][0]) && trim($titlematches[1][0]) != '') {
					$namearea = explode('-', $titlematches[1][0]); 

					$data['spam_name']	= trim($namearea[0]);
					$data['spam_area']	= isset($namearea[1]) && trim($namearea[1]) != '' ? trim($namearea[1]) : null;
				}
				/* End get name of the company. *************************************************************************************/
				
				$regexp = '/business_entry_(.*?)"/';
				preg_match_all($regexp, $linkContent, $businesslink);

				$classbox = isset($businesslink[1][0]) ? '.business_entry_'.$businesslink[1][0] : '';

				if($classbox != '') {					
					
					/* Item box. */
					$contactDetails = str_get_html($linkContent)->find($classbox, 0)->innertext;

					/* EMAIL*************************************************************************************/																				
					$emailDetails = str_get_html($contactDetails)->find('.email a', 0)->innertext;	

					if($emailDetails == '') {																		
						$regexp = '/<span>Email: <\/span>(.*?)<\/div>/';
						preg_match_all($regexp, $contactDetails, $emailmatches);
						$emailDetails = isset($emailmatches[1][0]) && trim($emailmatches[1][0]) != '' ? trim($emailmatches[1][0]) : null;											
					}
					
					if(!preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', trim($emailDetails))) {
						$success = false;
					} else {
						$data['spam_email']	= $emailDetails;
						$data['spam_text']		= $contactDetails;
						
					
						/* PHONE *************************************************************************************/																				
						$regexp = '/<span>Phone: <\/span>(.*?)<\/div>/';					
						preg_match_all($regexp, $contactDetails, $numbermatches);
						$data['spam_number'] 		= isset($numbermatches[1][0]) && trim($numbermatches[1][0]) != '' ? onlyAlphaNumeric(trim($numbermatches[1][0])) : null;					
						/*********************************************************************************************/																				

						/* FAX *************************************************************************************/																				
						$regexp = '/<span>Fax: <\/span>(.*?)<\/div>/';					
						preg_match_all($regexp, $contactDetails, $faxmatches);
						$data['spam_fax'] 		= isset($faxmatches[1][0]) && trim($faxmatches[1][0]) != '' ? onlyAlphaNumeric(trim($faxmatches[1][0])) : null;					
						/******************************************************************************************/							

						/* FAX *************************************************************************************/																				
						$regexp = '/<span>Share Call Fax: <\/span>(.*?)<\/div>/'; $faxmatches = null;
						preg_match_all($regexp, $contactDetails, $faxmatches);
						$data['spam_fax'] 		= isset($faxmatches[1][0]) && trim($faxmatches[1][0]) != '' ? onlyAlphaNumeric(trim($faxmatches[1][0])) : $data['spam_fax'];					
						/******************************************************************************************/	

						/* FAX *************************************************************************************/																				
						$regexp = '/<span>Cell: <\/span>(.*?)<\/div>/';
						preg_match_all($regexp, $contactDetails, $cellmatches);
						$data['spam_cell'] 		= isset($cellmatches[1][0]) && trim($cellmatches[1][0]) != '' ? onlyAlphaNumeric(trim($cellmatches[1][0])) : null;					
						/******************************************************************************************/	

						/* LINK *************************************************************************************/																				
						$linkDetails = str_get_html($contactDetails)->find('.web a', 0)->innertext;				
						$data['spam_link']	= validateDomain($linkDetails);
						if($data['spam_link'] == '') {
							$data['spam_link']		= validateDomain(substr(strrchr($data['spam_email'], "@"), 1)); 
						}
						/*******************************************************************************************/

						/* DESCRIPTION *************************************************************************************/																				
						$aboutDetails = str_get_html($contactDetails)->find('.entryAboutUs', 0)->innertext;				
						$data['spam_description']	= trim(str_replace('<br />', '', str_replace('<strong>About</strong>', '', $aboutDetails)));
						/***************************************************************************************************/					

						/* DESCRIPTION *************************************************************************************/																				
						$addressDetails = str_get_html($contactDetails)->find('.address_1', 0)->innertext;				
						$data['spam_address']	= trim(str_replace('<br />', '', str_replace('<strong>About</strong>', '', $addressDetails)));
						/***************************************************************************************************/	
					}
				} else {
					$success = false;
				}
								
			} else {
				$success = false;
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
			} else {
				echo '<br /><b>No Email</b><br />';
			}	 			
			
			echo '=============================================================================';

		}	
	}
}

?>