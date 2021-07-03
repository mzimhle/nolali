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

$link = 'https://www.capetown.gov.za/en/councilonline/Pages/ViewWardDetails.aspx?FirstWardSequenceNo=1&LastWardSequenceNo=10';
 
/* Object. */
if(trim($link) != '') {
	
	// echo '<b>'.$link.'</b><br /><br />';
    $urlContent = getPage($link);

		/* Get the first DIV in the results page. */
		$table = str_get_html($urlContent)->find('.s4-wpTopTable', 1)->innertext;
		
		// loop over rows
		foreach(str_get_html($table)->find('tr') as $row) {
			$data = null; $data = array();
			$input = null; $input = array();
			
			// initialize array to store the cell data from each row
			foreach($row->find('td') as $cell) {
				$input[] = $cell->innertext;		
			}
			
			if(count($input) > 0) {
				
				unset($data); $data = null; $data = array();
				$data['ward'] 		= trim(strip_tags($input[0])) == '' ? '' : preg_replace('/\s+/', ' ', trim(strip_tags($input[0])));
				$data['councillor']	= trim(strip_tags($input[1])) == '' ? '' : preg_replace('/\s+/', ' ', trim(strip_tags($input[1])));
				$data['areas'] 		= trim(strip_tags($input[2])) == '' ? '' : preg_replace('/\s+/', ' ', trim(strip_tags($input[2])));

				$councillor =  str_get_html($input[1])->find('a', 0)->href;		
				$data['councillor_link'] = 'https://www.capetown.gov.za/en/councilonline/Pages/'.$councillor;
				
				if($data['councillor'] != '') {
					// echo '<br /><br />Councilour details: '.$data['councillor_link'].'<br /><br />';
					
					/****************************************************************************************** Get councillor details. */
					$councilData =   $urlContent = getPage($data['councillor_link']);
					
					$tempTable = str_get_html($councilData)->find('#ctl00_MSO_ContentDiv table tr td div div span', 0)->innertext;

					$subTable = str_get_html($tempTable)->find('table', 0)->innertext;
					$subTable = str_replace('<th', '<td', $subTable);
					$subTable = str_replace('</th>', '</td>', $subTable);
					$subTable = str_replace('<td class="ms-rteCustom-CityArticleText" valign="top" />', '', $subTable); 
					$subTable = str_replace('<><>', '', $subTable); 
					/* $subTable = preg_replace("/<td(.*)>/", '', $subTable);
					$subTable = preg_replace("/<tr(.*)>/", '', $subTable); 				 */
					
					//echo $subTable; exit; 
					/* get the first table. */
					// $councilourDetails = str_get_html($subTable)->find('.s4-wpTopTable table', 0)->innertext;					
					
					foreach(str_get_html($subTable)->find('tr') as $subrow) {
						$subdata = null; $subdata = array();
						$subinput = null; $subinput = array();
						
						foreach($subrow->find('td') as $subcell) {
							$subinput[] = $subcell->innertext;		
						}
						
						if(count($subinput) > 0) {
							/* Check if its an image. */
							$subdata['image'] =  str_get_html($subinput[0])->find('img', 0)->src != '' ? str_get_html($subinput[0])->find('img', 0)->src;
							
						}
						
						print_r($subdata);
					}	
					
					exit;
				}
			}			
		}

}

?>