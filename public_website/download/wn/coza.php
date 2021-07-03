<?php
	
	
	if(isset($_REQUEST['domain']) && trim($_REQUEST['domain']) != '') {
		
		$domain	= trim($_REQUEST['domain']);

	header('Content-Description: File Transfer');
	header('Content-type: text/plain');
	header('Content-Disposition: attachment; filename='.$domain.'.txt');
	header('Content-Transfer-Encoding: chunked'); //changed to chunked
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');

		
    $ch = curl_init();
    $url = "http://www.coza.net.za/Update_gen.php?domain=$domain";

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0; .NET CLR 1.0.3705)");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 4);
    curl_setopt($ch, CURLOPT_REFERER, "http://co.za/whois.shtml"); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
	echo $data;
	exit;
	
	}
?>