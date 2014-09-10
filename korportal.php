<?php
$action = "update";
if(isset($argv[1])){
	switch($argv[1])
	{
		case 'update': $action = 'update'; break;
		case 'open': $action = 'open'; break;
		case 'reopen': $action = 'reopen'; break;
		case 'close': $action = 'close'; break;
		case 'pause': $action = 'pause'; break;
		default: $action = 'update'; break;
	}
}

$protocol = "https";
$host = "bitrix24.ru";
$cookiefile = "cookie.txt"; 
$user = '';  
$pass = '';
$endDayReport = "";

$curl = curl_init();
if(!$curl){ print curl_errno($curl); die('Не удалось соединиться');}

$header [] = "Accept:*/*";
$header [] = "Accept-Charset:windows-1251,utf-8;q=0.7,*;q=0.3";
$header [] = "Accept-Language:ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4";
$header [] = "Cache-Control:max-age=0";
$header [] = "Content-Length:96";
$header [] = "Content-Type:application/x-www-form-urlencoded";
$header [] = "Host:$host";
$header [] = "Origin:$protocol://$host";
$header [] = "Proxy-Connection:keep-alive";
$header [] = "Referer:$protocol://$host";
$header [] = "User-Agent:Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.56 Safari/537.17";


curl_setopt($curl, CURLOPT_URL, "$protocol://$host/?login=yes");

curl_setopt($curl, CURLOPT_VERBOSE , false);
curl_setopt($curl, CURLOPT_HEADER , 0 );
curl_setopt($curl, CURLOPT_HTTPHEADER , $header );
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiefile);
curl_setopt($curl, CURLOPT_COOKIEJAR, $cookiefile);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, "AUTH_FORM=Y&TYPE=AUTH&backurl=%2F&USER_LOGIN=$user&USER_PASSWORD=$pass&USER_REMEMBER=Y&Login=%C2%EE%E9%F2%E8" );

$response = curl_exec($curl);
$sess_id = preg_replace("/.*'bitrix_sessid':'(.*?)'.*/msi", "$1", $response);

//echo $sess_id;
curl_close($curl);


$curl_ajax = curl_init();
curl_setopt($curl_ajax, CURLOPT_URL, "$protocol://$host/bitrix/tools/timeman.php?action=$action&site_id=s1&sessid=$sess_id");
curl_setopt($curl_ajax, CURLOPT_COOKIEFILE, $cookiefile);
curl_setopt($curl_ajax, CURLOPT_COOKIEJAR, $cookiefile);
curl_setopt($curl_ajax, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_ajax, CURLOPT_HEADER , FALSE );

if($action=="close")
{
	curl_setopt($curl_ajax, CURLOPT_POST, true);
	curl_setopt($curl_ajax, CURLOPT_POSTFIELDS, "REPORT=$endDayReport&ready=Y&" );
}
$response_ajax = curl_exec($curl_ajax);

echo $response_ajax;
