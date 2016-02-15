<?php
include 'options.php';

if ($randomSleep !== false && $randomSleep > 0) {
    sleep($randomSleep);
}

$action = 'update';
if (isset($argv[1]) && in_array($argv[1], ['update', 'open', 'reopen', 'close', 'pause'])) {
    $action = $argv[1];
}

$headers = [
    "Host:{$host}",
    "Origin:{$protocol}://{$host}",
    "Referer:{$protocol}://{$host}",
    "User-Agent:Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/34.0.1312.56 Safari/537.17"
];

$curl = curl_init();
if(!$curl){ print curl_errno($curl); die('Не удалось соединиться');}
curl_setopt($curl, CURLOPT_URL, "{$protocol}://{$host}/?login=yes");
curl_setopt($curl, CURLOPT_VERBOSE , false);
curl_setopt($curl, CURLOPT_HEADER , 0 );
curl_setopt($curl, CURLOPT_HTTPHEADER , $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($curl, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, "AUTH_FORM=Y&TYPE=AUTH&backurl=%2F&USER_LOGIN={$user}&USER_PASSWORD={$pass}&USER_REMEMBER=Y&Login=%C2%EE%E9%F2%E8" );

$response = curl_exec($curl);
$session_id = preg_replace("/.*'bitrix_sessid':'(.*?)'.*/msi", "$1", $response);

//echo $sess_id;
curl_close($curl);

$curl_ajax = curl_init();
curl_setopt($curl_ajax, CURLOPT_URL, "{$protocol}://{$host}/bitrix/tools/timeman.php?action={$action}&site_id=s1&sessid={$session_id}");
curl_setopt($curl_ajax, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($curl_ajax, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($curl_ajax, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_ajax, CURLOPT_HEADER , false );

if ($action === "close") {
    curl_setopt($curl_ajax, CURLOPT_POST, true);
    curl_setopt($curl_ajax, CURLOPT_POSTFIELDS, "REPORT={$endDayReport}&ready=Y&" );
}

$response_ajax = curl_exec($curl_ajax);

echo $response_ajax;
