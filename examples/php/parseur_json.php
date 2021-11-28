<?php

//authentification et machin avec le cookie

$ch = curl_init();
$data = array("name" => "xxxxx","pass" => "xxxxxx");

$postdata = json_encode($data);
curl_setopt($ch, CURLOPT_URL, 'https://www.wsprnet.org/drupal/rest/user/login');
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIESESSION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER,  true);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie-name');  //could be empty, but cause problems on some hosts
curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/cook');  //could be empty, but cause problems on some hosts
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$answer = curl_exec($ch);
if (curl_error($ch)) {
    echo curl_error($ch);
} else {
    print_r($answer);
}
// recuperation des spots
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_URL, 'https://www.wsprnet.org/drupal/wsprnet/spots/json/?band=10&callsign=f4goh&minutes=30');
$answer = curl_exec($ch);
if (curl_error($ch)) {
    echo curl_error($ch);
} else {
//	print_r($answer);
}
print_r($answer);

die();

