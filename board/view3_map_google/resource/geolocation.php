<?php
$hostNameUrl = 'https://geolocation.apigw.ntruss.com';
$requestUrl = '/geolocation/v2/geoLocation?ip='.$_SERVER['REMOTE_ADDR'].'&ext=t&responseFormatType=json';
$timestamp = round(microtime(true) * 1000);
$accessKey = '';
$secretKey = '';
$sts = "GET ".$requestUrl."\n".$timestamp."\n".$accessKey;
$hash_sha256 = hash_hmac('sha256', $sts, $secretKey, true);
$sign = base64_encode($hash_sha256);
$curlHandler = curl_init();
curl_setopt($curlHandler, CURLOPT_URL, $hostNameUrl.$requestUrl);
curl_setopt($curlHandler, CURLOPT_HTTPHEADER, array(
    'x-ncp-apigw-timestamp: '.$timestamp,
    'x-ncp-iam-access-key: '.$accessKey,
    'x-ncp-apigw-signature-v2: '.$sign
));
curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curlHandler);
$info = curl_getinfo($curlHandler);
curl_close($curlHandler);
echo $result;
?>