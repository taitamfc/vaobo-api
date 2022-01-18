<?php
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('PRC');

$api_key = '?api_key=WC14dVgAUBsTzcDD';
$ajax_url = 'http://api.isportsapi.com';

// Set url parameter
$url = "http://api.isportsapi.com/sport/football/odds/european/all".$api_key.'&companyId=16';

// Call iSport Api to get data in json format
$json_data = file_get_contents($url);

echo $json_data;
die();
