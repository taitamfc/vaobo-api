<?php
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('PRC');

$api_key = '?api_key=WC14dVgAUBsTzcDD';
$ajax_url = 'http://api.isportsapi.com';

$action = $_GET['action'];
$date   = ( isset($_GET['date']) ) ? $_GET['date'] : 1639;
$companyId  = ( isset($_GET['companyId']) ) ? $_GET['companyId'] : 16;

switch ($action) {
    case 'bookmaker':
        $url = $ajax_url."/sport/football/bookmaker".$api_key;
        break;
    case 'league':
        $url = $ajax_url."/sport/football/league/basic".$api_key;
        break;
    case 'schedule':
        $url = $ajax_url."/sport/football/schedule/basic".$api_key.'&date='.$date;
        break;
    case 'european':
        $url = $ajax_url."/sport/football/odds/european/all".$api_key.'&companyId='.$companyId;
        break;
    case 'pre-match':
        $url = $ajax_url."/sport/football/odds/main".$api_key;
        break;
    default:
        # code...
        break;
}
// Call iSport Api to get data in json format
$json_data = file_get_contents($url);

$json_data = json_decode($json_data);
foreach ($json_data->data as $key => $value) {
    if( $value->status != 0 ){
        unset($json_data->data[$key]);
        continue;
    }
    $value->matchTime = date('Y-m-d H:i:s',$value->matchTime);
}
echo json_encode($json_data);
die();
