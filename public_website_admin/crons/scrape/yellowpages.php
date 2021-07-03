<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/*** Standard includes  */
require_once 'config/database.php';
require_once 'config/smarty.php';

require_once 'scrape/simple_html_dom.php';
require_once 'class/spam.php';

//error_reporting(E_ERROR | E_WARNING | E_PARSE);

$page = array('0-9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
$rand = rand(0, count($page));


$link = 'http://www.yellowpages.co.za/search/recruitment+consultants/4';

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
	$counter = 0;
	while(($item = str_get_html($results)->find('.result ', $counter)->innertext) != NULL) {
		
		$data = array();
		$data['fk_spamType_id']	= 'YLP';
		$data['spam_name']			= str_replace('&rarr;', '',str_get_html($item)->find('.resultName a', $counter)->innertext);
		$data['spam_referer'] 		= 'http://www.yellowpages.co.za'.str_get_html($item)->find('.resultName a', $counter)->href;
		$data['spam_text'] 			= null;
		$data['spam_address']		= trim(str_replace('Get directions', '', strip_tags(str_get_html($urlContent)->find('.resultAddress', 0)->innertext)));
		$data['spam_number'] 		= trim(strip_tags(str_get_html($urlContent)->find('.resultMainNumber', 0)->innertext));
			
		
		$subcontent = getPage($data['spam_referer']);

		
		$subresults = str_get_html($subcontent)->find('.contentColumn panel', 0)->innertext;
		
		/* PHONE *************************************************************************************/																				
		$regexp = '/<dt>Description<\/dt>/';					
		preg_match_all($regexp, $subresults, $descmatches);
		print_r($descmatches);exit;
		$data['spam_number'] 		= isset($numbermatches[1][0]) && trim($numbermatches[1][0]) != '' ? trim($numbermatches[1][0]) : null;					
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
						$data['spam_link'] =  $matches[$i][0];
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
						$data['spam_number'] =  str_replace(' ', '', $matches[$i][0]);
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
		$pattern			="/[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}/i"; 
		
		/* Pregmatch to find an email address. */
		preg_match_all($pattern, $emailContent, $matches);
		
		if(count($matches) > 0) {
			for($i = 0; $i < count($matches); $i++) {
				if(isset($matches[$i][0])) {
					if(preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $matches[$i][0])) {
						$data['spam_email'] =  $matches[$i][0];
					}			
				}
			}
		}
		
		$emailContent = $pattern = $matches = $i = null;
		unset($numberContent, $pattern, $matches, $i);
		/************************************************************* Email End. */
		print_r($data); exit;
		$checkData = array();
		
		if(isset($data['spam_email']) && trim($data['spam_email']) != '') {
			$checkData = $spamObject->getByEmail($data['spam_email']);
		} else if(isset($data['spam_fax']) && trim($data['spam_fax']) != '') {
			$checkData = $spamObject->getByFax($data['spam_fax']);
		} else if(isset($data['spam_name']) && trim($data['spam_name']) != '') {
			$checkData = $spamObject->getByName($data['spam_name']);
		}
		
		if(count($checkData) > 0 && isset($checkData['spam_name'])) {		
			echo '<span style="color: red; font-weight: bold;">Aready exists: '.$data['spam_name'].' '.$data['spam_email'].' '.$data['spam_fax'].'</span><br />';
		} else {
			echo '<span style="color: green; font-weight: bold;">Added: '.$data['spam_name'].' '.$data['spam_email'].' '.$data['spam_fax'].'</span><br />';
			$spamObject->insert($data);
		}


		$counter++;
	}
}

?>