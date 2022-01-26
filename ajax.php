<?php
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('PRC');

$api_key = '?api_key=WC14dVgAUBsTzcDD';
$ajax_url = 'http://api.isportsapi.com';

$action = $_GET['action'];
$date   = ( isset($_GET['date']) ) ? $_GET['date'] : date('Y-m-d');
$companyId  = ( isset($_GET['companyId']) ) ? $_GET['companyId'] : 16;
$matchIds  = ( isset($_GET['matchIds']) ) ? $_GET['matchIds'] : '';

switch ($action) {
    case 'bookmaker':
        $url = $ajax_url."/sport/football/bookmaker".$api_key;
        break;
    case 'league':
        $url = $ajax_url."/sport/football/league/basic".$api_key;
        break;
    case 'schedule':
        $url = $ajax_url."/sport/football/schedule/basic".$api_key.'&date='.$date;
        $url = $ajax_url."/sport/football/schedule".$api_key.'&date='.$date;
        break;
    case 'live':
        $url = $ajax_url."/sport/football/schedule".$api_key.'&date='.$date;
        break;
    case 'european':
        $url = $ajax_url."/sport/football/odds/european/all".$api_key.'&companyId='.$companyId;
        break;
    case 'pre-match':
        $url = $ajax_url."/sport/football/odds/main".$api_key.'&matchId='.$matchIds.'&companyId=3';
        break;
    default:
        # code...
        break;
}
// Call iSport Api to get data in json format
$json_data = file_get_contents($url);

$json_data = json_decode($json_data);

if( $action == 'pre-match' ){
    $matches_odd = [];
    foreach ($json_data->data as $odd_type => $odd_items) {
        foreach ($odd_items as $odd_item) {
            $matchId = current( explode(',',$odd_item) );
            $matches_odd[$matchId][$odd_type] = $odd_item;
        }
    }

    $json_data = $matches_odd;
}
if( $action == 'live' ){
    // $leagues = [];
    // foreach ($json_data->data as $key => $value) {
    //     $leagues[$value->leagueId] = $value->leagueName;
    // }

    $matches = [];
    $matchIds = [];
    foreach ($json_data->data as $key => $value) {
        $matchIds[] = $value->matchId;
        $leagues[$value->leagueId] = $value->leagueName;
        if( $value->status != 0 ){
            unset($json_data->data[$key]);
            continue;
        }
        $value->matchTime = date('Y-m-d H:i:s',$value->matchTime);
        $matches[$value->leagueId][] = $value;
    }

    $return['matches'] = $matches;
    $return['leagues'] = $leagues;
    $return['matchIds'] = implode(',',$matchIds);
    $json_data = $return;
    header('Content-Type: application/json; charset=utf-8');
}

echo json_encode($json_data);
die();
