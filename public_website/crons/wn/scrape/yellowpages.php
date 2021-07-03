<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes  */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'scrape/simple_html_dom.php';
require_once 'class/ADMIN/spam.php';
require_once 'global_functions.php';

//error_reporting(E_ERROR | E_WARNING | E_PARSE);

$page		= rand(1, 10);
$links		= array();
$links[]	= 'http://www.yellowpages.co.za/search/recruitment+consultants/';
$links[]	= 'http://www.yellowpages.co.za/search/catering/';
$links[]	= 'http://www.yellowpages.co.za/search/cleaners/';
$links[]	= 'http://www.yellowpages.co.za/search/services/';
$links[]	= 'http://www.yellowpages.co.za/search/lodge/';
$links[]	= 'http://www.yellowpages.co.za/search/recruitment/';
$links[]	= 'http://www.yellowpages.co.za/search/agency/';
$links[]	= 'http://www.yellowpages.co.za/search/advertising/';

$link			= $links[rand(0,6)].$page;

function getPage($link) {
	/* Setup curl. */
    $options = array(
        CURLOPT_RETURNTRANSFER 	=> true,     // return web page
        CURLOPT_HEADER         		=> false,    // don't return headers
        CURLOPT_FOLLOWLOCATION 	=> true,     // follow redirects
        CURLOPT_ENCODING       		=> "",       // handle all encodings
        CURLOPT_USERAGENT      		=> "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1", // who am i
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

/* Object. */
if(trim($link) != '') {
	
    $urlContent = getPage($link);
	
	/* Clean it up. */
	$curl = NULL; UNSET($curl);

	/* Get the first DIV in the results page. */
	$results = str_get_html($urlContent)->find('#searchResults', 0)->innertext;

	/* Object. */
	$spamObject = new class_spam();
		
	/* Loop through all the jobs. */
	for($counter = 1; $counter < 21; $counter++) {
	
		$data = array();
		$data['fk_spamType_id']		= 'YLP';
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
		$data['spam_referer']			= null;	
		
		//while(($item = str_get_html($results)->find('.result ', $counter)->innertext) != NULL) {
		
		$item = str_get_html($results)->find('.result ', $counter)->innertext;

		$data['spam_name']			= str_replace('&rarr;', '',str_get_html($item)->find('.resultName a', 0)->innertext);
		$data['spam_referer'] 		= 'http://www.yellowpages.co.za'.str_get_html($item)->find('.resultName a', 0)->href;
		$data['spam_text'] 				= null;
		$data['spam_address']		= trim(str_replace('Get directions', '', strip_tags(str_get_html($urlContent)->find('.resultAddress', 0)->innertext)));
		$data['spam_number'] 		= onlyAlphaNumeric(trim(strip_tags(str_get_html($urlContent)->find('.resultMainNumber', 0)->innertext)));
			
		
		$subcontent = getPage($data['spam_referer']);
		
		if($subcontent != '') {
		
			$subresults = str_get_html($subcontent)->find('.contentColumn panel', 0)->innertext;
		
			/* PHONE *************************************************************************************/																				
			$regexp = '/<dt>Description<\/dt>/';					
			preg_match_all($regexp, $subresults, $descmatches);

			$data['spam_number'] 		= isset($numbermatches[1][0]) && trim($numbermatches[1][0]) != '' ? onlyAlphaNumeric(trim($numbermatches[1][0])) : $data['spam_number'] ;					
			/*********************************************************************************************/																				

			/************************************************************* Website. */
			/* Check if they have email. */
			$websiteContent	= str_get_html($item)->find('.details #resultWebsiteBar a', 0)->onclick;	
			$pattern				='/(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/'; 
			
			/* Pregmatch to find an email address. */
			preg_match_all($pattern, $websiteContent, $matches);
			
			if(count($matches) > 0) {
				for($i = 0; $i < count($matches); $i++) {
					if(isset($matches[$i][0])) {
						if(preg_match($pattern, str_replace(' ', '', $matches[$i][0]))) {
							$data['spam_link'] =  validateDomain($matches[$i][0]);
						}			
					}
				}
			}
			
			$numberContent = $pattern = $matches = $i = null;
			unset($numberContent, $pattern, $matches, $i);		
			/************************************************************* Website End. */		
			
			/************************************************************* Number. */
			/* Check if they have email. */
			$numberContent	= str_get_html($item)->find('.details #resultTelBar span', 0)->onclick;	
			$pattern				="/[(][0-9]{3}[)][\-][0-9]{6}|[0-9]{3}[\s][0-9]{6}|[0-9]{3}[\s][0-9]{3}[\s][0-9]{4}|[0-9]{10}|[0-9]{3}[\-][0-9]{3}[\-][0-9]{4}/"; 
			
			/* Pregmatch to find an email address. */
			preg_match_all($pattern, $numberContent, $matches);
			
			if(count($matches) > 0) {
				for($i = 0; $i < count($matches); $i++) {
					if(isset($matches[$i][0])) {
						if(preg_match($pattern, $matches[$i][0])) {
							$data['spam_number'] =  onlyAlphaNumeric(str_replace(' ', '', $matches[$i][0]));
						}			
					}
				}
			}
			
			$numberContent = $pattern = $matches = $i = null;
			unset($numberContent, $pattern, $matches, $i);
			
			/************************************************************* Number End. */
			/************************************************************* Email. */
			/* Check if they have email. */
			$emailContent	= str_get_html($item)->find('.details #resultEmailBar a', 0)->onclick;
			
			if($emailContent != '') {
			
				$pattern			="/[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}/i"; 
				
				/* Pregmatch to find an email address. */
				preg_match_all($pattern, $emailContent, $matches);
				
				if(count($matches) > 0) {
					for($i = 0; $i < count($matches); $i++) {
						if(isset($matches[$i][0])) {
							if(preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $matches[$i][0])) {
								$data['spam_email']	= $matches[$i][0];
								$data['spam_link']		= $data['spam_link'] == '' ? validateDomain(substr(strrchr($data['spam_email'], "@"), 1)) : $data['spam_link']; 
							}			
						}
					}
				}
				
				$emailContent = $pattern = $matches = $i = null;
				unset($numberContent, $pattern, $matches, $i);
				/************************************************************* Email End. */
				if($data['spam_email'] != '') {
					print_r($data); exit;
					$checkData = $spamObject->getByEmail($data['spam_email']);
					
					if($checkData) {		
						echo '<span style="color: red; font-weight: bold;">Aready exists: '.$data['spam_name'].' '.$data['spam_email'].' '.$data['spam_fax'].'</span><br />';
					} else {
						echo '<span style="color: green; font-weight: bold;">Added: '.$data['spam_name'].' '.$data['spam_email'].' '.$data['spam_fax'].'</span><br />';
						$spamObject->insert($data);
					}
				}
			}
		}
	}
}

?>