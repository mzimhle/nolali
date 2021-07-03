<?php

require_once('simple_html_dom.php');
require_once('global_functions.php');

class scrape_datafin {

	protected $domain = 'http://www.datafin.com/';
	protected $resultsDOMDoc;
	protected $pageResults;
	protected $url;
	protected $jobItems = array();
	protected $categoriesLink = 'www.datafin.com/vacancies.aspx';
	
	/* Constructor. */
	function __construct($url) {
		
		/* Assign url to the object variable. */
		$this->url = $url;
		
		/* Get the page. */
		$urlContent = file_get_contents($url);
		
		/* Get the first DIV in the results page. */
		$page = '#page_1';
		$results = str_get_html($urlContent)->find($page, 0)->innertext;
		
		/* Output it as a DOM object. */
		$this->resultsDOMDoc = str_get_html($results);
		print_r($this->resultsDOMDoc); exit;
	}
	
	
	public function getCareer24JobItems() {
		$pageResultsArray = array();
		$count = 0;
		
		foreach($this->resultsDOMDoc->find('ol') as $OLitem) {
			foreach($OLitem->find('li') as $LIitem) { 
				if(@$LIitem->find('h2 a', 0)->innertext != '') {
					
					/* Get job title. */
					$pageResultsArray[$count]['title'] =  @$LIitem->find('h2 a', 0)->innertext;
				
					/* Get job link. */
					$titleLink = @$LIitem->find('a', 0)->href;
					$pageResultsArray[$count]['link'] =  $this->domain.$titleLink;

					/* Get recruiter logo. */
					$logoName = @$LIitem->find('.clogo img', 0)->src != '' ? @$LIitem->find('.clogo img', 0)->src : '';
					$pageResultsArray[$count]['logo'] =  $logoName != '' ? $this->domain.$logoName : '';
				
					/* Get recruiter logo. */
					$pageResultsArray[$count]['area'] =  @$LIitem->find('.details li', 0)->innertext;

					/* Get salary. */
					$pageResultsArray[$count]['salary'] =  @$LIitem->find('.details li', 1)->innertext;
					
					/* Get job type. */
					$pageResultsArray[$count]['type'] =  @$LIitem->find('.details li', 2)->innertext;
					/* End Getting details. */
					
					/* Get poster name. */
					$pageResultsArray[$count]['postedBy'] =  @$LIitem->find('dl dd', 0)->innertext;
			
					/* Get date posted. */
					$date = @$LIitem->find('dl dd', 1)->innertext; // outputs 2006-01-24 
					$pageResultsArray[$count]['datePosted'] = date('Y-m-d', strtotime($date));
					
					/* Get job short description. */
					$pageResultsArray[$count]['description'] =  @$LIitem->find('p', 1)->innertext == '' ? @$LIitem->find('p', 0)->innertext : @$LIitem->find('p', 1)->innertext;						
					
					/* Prepare for the next <list> item. */
					$count++;
				}
			}
		}
		
		return $pageResultsArray;
	}
	
	
	public function getCareers24Pagination() {
		
		/* Declare array to be used and returned. */
		$paginationArray = array();
		$paginationArray['totalItems']	= '';
		$paginationArray['pages'] 		= 0;
		
		/* Get string that has pagination. */
		$stringArray =  explode('of', $this->resultsDOMDoc->find('.sr-header p', 0)->innertext);
		$numberArray = str_split($stringArray[1]);				
		
		/* Add together the characters at the same time removing non-numeric ones. */
		foreach($numberArray as $number) {
			if(is_numeric($number) && (int)$number != 0) {
				$paginationArray['totalItems'] .= $number;
			}
		}
		
		/* Get the total number of pages through calculation, was lazy. */
		$pages = (int)$paginationArray['totalItems'] / 10;
		$pages =  ($pages % 10) > 0 ? (int)$pages + 1 : (int)$pages;
		$paginationArray['pages'] = $pages;
		
		/* Return findings if any. */
		return $paginationArray;
	}
	
	
	/* File path: http://www.willowvine.co.za/{sectionName}/{jobTitle}-{randomChars}/{imageName}/ */
	public function uploadLogo($url, $category = '', $filename = '', $ext = '.jpg') {
		
		/* Random number. */
		$random = rand(1, 100000);
		$category = $_SERVER['DOCUMENT_ROOT'].'/pages/jobs/'.StringToFilename($category).'/';
		
		/* d
		/* Check the directory, create it if its not present. */
		if (!is_dir($category)) {
			if (!mkdir($category, 0775, true)) {
				return;
			}
		}
		/* Full file name and save path. */
		$imageName = $category.$filename.'_'.$random.$ext;
		
		/* if file already exists. call the function again. */
		if(is_file($category.$filename.'_'.$random.$ext))  {
			return;
		} else {
			/* upload image and check as well. */
			if(file_put_contents($imageName, file_get_contents($url))) {
				return $imageName;
			}
		}
	}
	
	public function insertJob($jobConnObject, $data, $categoryId = NULL, $categoryName = '') {
		
		/* Define check array. */
		$check = array();
		/* Build the insert statement. */
		$check = $jobConnObject->checkJobExists(trim($data['title']), trim($data['postedBy']), trim($data['link']));
		
		if(count($check) == 0) {  
			$insertData['job_title']				= trim($data['title']);
			$insertData['job_extURL'] 			= trim($data['link']);
			$insertData['job_image']			= $data['logo'] != '' ? $this->uploadLogo($data['logo'], $categoryName, StringToFilename(trim($data['title']))) : '';
			$insertData['job_area']				= trim($data['area']);
			$insertData['job_salary']			= trim($data['salary']);
			$insertData['job_type']				= trim(strtolower($data['type']));
			$insertData['job_poster_name']		= trim($data['postedBy']);
			$insertData['job_added']			= trim($data['datePosted']);
			$insertData['job_page']				= trim($data['description']);
			
			$insertData['fk_section_id']			= $categoryId;
			$insertData['job_referenceDB']	= createReference($jobConnObject);	
			$insertData['job_poster_email']	= '';
			$insertData['job_AdType']			= 'offering';
			$insertData['job_advertBy']		= 'agency';
			
			return $jobConnObject->insert($insertData);
		}
	}
	
	public function getCareer24Categories() {
		/* Get the page. */
		$urlContent = file_get_contents($this->categoriesLink);
		
		/* Get the first DIV in the results page. */
		$results = str_get_html($urlContent)->find('.wrapper2 .wrapper3 .browse-jobs-tabs .inner1', 0)->innertext;
		
		/* Output it as a DOM object. */
		$resultsDOMObject = str_get_html($results);
		
		/* Output it as a DOM object. */
		$categoryListObject = str_get_html($resultsDOMObject->innertext);
		
		/* list array to be built and returned. */
		$categoryListArray = array();
		$count = 0;
		
		/* Build the category list. */
		foreach($categoryListObject->find('ul') as $ULitem) {
			foreach($ULitem->find('li') as $LIitem) {
			
				$categoryListArray[$count]['category']	= @$LIitem->find('a', 0)->innertext;
				$tempLIlink												= @$LIitem->find('a', 0)->href;
				$categoryListArray[$count]['link']			=  $this->domain.$tempLIlink;
				
				$count++;
			}
		}
		
		return $categoryListArray;
		
	}
}
?>