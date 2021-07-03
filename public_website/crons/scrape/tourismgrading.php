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

$link = 'http://www.tourismgrading.co.za/find-a-graded-establishment/search-for-graded-accommodation/';
 
/* Object. */
if(trim($link) != '') {
	
	echo '<b>'.$link.'</b><br /><br />';
    $urlContent = getPage($link);

		/* Get the first DIV in the results page. */
		$maintable = str_get_html($urlContent)->find('#results-table table', $i)->innertext;
		$success 	= true;
		echo $maintable; exit;
		if($maintable) {
		
			$data = array();
			$data['fk_spamType_id'] 	= 'BOX';
			$data['spam_name'] 			= null;
			$data['spam_contact'] 		= null;
			$data['spam_number'] 		= null;
			$data['spam_link'] 			= null;
			$data['spam_address'] 		= null;
			$data['spam_fax'] 				= null;
			$data['spam_cell'] 				= null;
			$data['spam_email']			= null;		
			$data['spam_text']				= null;
			$data['spam_description']	= null;		
			$data['spam_referer']		= $link;
			
			/* Get email number. */
			$companyemail = str_get_html($maintable)->find('.summaryComplementaryContent', 0)->innertext;
			$matches = array();
			$pattern = '/([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+/';
			preg_match($pattern,$companyemail,$matches);
			
			if(isset($matches[0])) {
				if(preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', trim($matches[0]))) {
					$data['spam_email'] = trim($matches[0]);
					$data['spam_link'] = substr(strrchr($data['spam_email'], "@"), 1); 

				} else { $success = false; }
			} else {
				$success = false;
			}
			
			/* End email address. */	
			if($success) {
				/* Get company name. */
				$companyname = str_get_html($maintable)->find('.summaryTitle h3 a', 0)->innertext;				
				if($companyname) {
					$data['spam_name']	= $companyname;
				}
				/* Get link to thiis item within this site. */
				$companylink = str_get_html($maintable)->find('.summaryTitle h3 a', 0)->href;				
				if($companylink) {
					$data['spam_referer']	= $companylink;
				}
				/* Check description. */
				$companydescription = str_get_html($maintable)->find('.summaryDescription p', 0)->innertext;					
				if($companydescription) {
					$data['spam_description']	= preg_replace('!\s+!'," ", strip_tags($companydescription));	
				}			
				/* Get Address. */
				$companyaddress = str_get_html($maintable)->find('.summaryComplementaryContent .summarySpacer', 0)->innertext;				
				if($companyaddress) {
					$data['spam_address']	= preg_replace('!\s+!'," ", strip_tags($companyaddress));	
				}
				/* Get telephone number. */
				$companytelephone = str_get_html($maintable)->find('.summaryComplementaryContent .controlPhoneHide', 0)->innertext;				
				if($companytelephone) {
					$data['spam_number']	= preg_replace('/[^0-9]/','', strip_tags($companytelephone));	
				}	
				/* Get fax number. */
				$companyfax = str_get_html($maintable)->find('.summaryComplementaryContent .controlFaxHide', 0)->innertext;				
				if($companyfax) {
					$data['spam_fax']	= preg_replace('/[^0-9]/','', strip_tags($companyfax));	
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


?>