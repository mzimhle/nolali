<?php

set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

require_once 'config/database.php';

require_once 'class/database/number.php';

	
	$user 			= "willowvine"; 
	$password 	= "DUJbgGdNRXROaA"; 
	$api_id 		= "3420082"; 
	$baseurl 		="http://api.clickatell.com"; 
	$text 			= urlencode("message here.. "); 
	$to 				= ""; 
	
	$numbersObject = new class_number();
	
	$numbersArray = $numbersObject->getNumbers(10);
	
	foreach($numbersArray as $number) {	
		// auth call 		
		
		if( preg_match( "/^0[0-9]{9}$/", $number['number_cell'])) {
			
			$to = $number['number_cell'];
			
			$url = "$baseurl/http/auth?user=$user&password=$password&api_id=$api_id"; 
			// do auth call 
			$ret = file($url); 

			// split our response. return string is on first line of the data returned 

			$sess = explode(":",$ret[0]); 
			
			if ($sess[0] == "OK") { 
			
				$sess_id = trim($sess[1]); // remove any whitespace 
				
				$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text"; 
				
				// do sendmsg call 
				$ret = file($url); 
				
				$send = explode(":",$ret[0]); 
				
				if ($send[0] == "ID") {		
					echo "success message ID: ". $send[1].' ==== ( '.$to.' )<br />'; 
					$where	= array();
					$data		= array();
					$data['number_updated']	= date('Y-m-d H:i:s'); 
					$where[]	= $numbersObject->getAdapter()->quoteInto('pk_number_id = ?', $number['pk_number_id']);
					$success	= $numbersObject->update($data, $where);	
					
				} else  {
					echo "send message failed<br />".$number['number_cell']."<br />"; 
				}
				echo '---------------------------------------------------------------<br />';
			} else { 
				echo "Authentication failure: ". $ret[0].'<br />'; 
				echo '---------------------------------------------------------------<br />';
			} 
		} else {
		  echo "Invalid number<br />".$number['number_cell']."<br />";		  
		}
	}
	
	$numbersObject = $to = $text  = $baseurl = $api_id  = $password = $user = $data = $number = $ret = $sess = $where = $send = $sess_id = $url = $numbersArray = NULL;
	UNSET($numbersObject, $to, $text, $baseurl, $api_id, $password , $user , $data, $number, $ret , $sess, $where, $send , $sess_id, $url , $numbersArray);
?>	