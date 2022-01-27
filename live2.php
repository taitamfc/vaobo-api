<?php

$api_key = '?api_key=WC14dVgAUBsTzcDD';
$ajax_url = 'http://api.isportsapi.com';

$date   = ( isset($_GET['date']) ) ? $_GET['date'] : date('Y-m-d');

$schedule_url = $ajax_url."/sport/football/schedule".$api_key.'&date='.$date;
$json_data = file_get_contents($schedule_url);
$json_data = json_decode($json_data);

//get all matches
$matches = [];

//get leagues for current matches
$leagues = [];

//get matchIds to get odds
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

$companyId = 22;

//get odds
$matchIds           = implode(',',$matchIds);
$odds_url = $ajax_url."/sport/football/odds/main".$api_key.'&matchId='.$matchIds.'&companyId='.$companyId;
$json_data = file_get_contents($odds_url);
$json_data = json_decode($json_data);

$matches_odds = [];
foreach ($json_data->data as $odd_type => $odd_items) {
    foreach ($odd_items as $odd_item) {
        $matchId = current( explode(',',$odd_item) );
        //$matches_odds[$matchId][$odd_type] = $odd_item;
        $matches_odds[$matchId][$odd_type] = explode(',',$odd_item);
    }
}
?>
<?php foreach( $matches as $league_id => $items ):?>
<div class="item">
    <h4><?= $leagues[$league_id] ?></h4>
    <table class="table" border="1">
        <tbody>
            <?php foreach( $items as $item ):?>
            <tr>
                <td><?= $item->matchTime ?> <br> <?= $item->matchId ?></td>
                <td><?= $item->homeName ?> <br> <?= $item->awayName ?></td>
                <td width="200px">
                    <?php if( isset($matches_odds[$item->matchId]) ):?>
                    <table class="table" border="1">
                        <tr>
                            <td>handicap</td>
                            <td>europeOdds</td>
                            <td>overUnder</td>
                            <td>handicapHalf</td>
                            <td>overUnderHalf</td>
                        </tr>
                        <tr>
                            <td>
                                <table class="table" border="1">
                                    <tr>
                                        <td><?= $matches_odds[$item->matchId]['handicap'][2]; ?></td>
                                        <td><?= $matches_odds[$item->matchId]['handicap'][3]; ?></td>
                                        <td><?= $matches_odds[$item->matchId]['handicap'][5]; ?></td>
                                        <td><?= $matches_odds[$item->matchId]['handicap'][6]; ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><?= $matches_odds[$item->matchId]['handicap'][4]; ?></td>
                                        <td></td>
                                        <td><?= $matches_odds[$item->matchId]['handicap'][7]; ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="table" border="1">
                                    <tr>
                                        <td><?= $matches_odds[$item->matchId]['europeOdds'][2]; ?></td>
                                        <td><?= $matches_odds[$item->matchId]['europeOdds'][3]; ?></td>
                                        <td><?= $matches_odds[$item->matchId]['europeOdds'][5]; ?></td>
                                        <td><?= $matches_odds[$item->matchId]['europeOdds'][6]; ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><?= $matches_odds[$item->matchId]['europeOdds'][4]; ?></td>
                                        <td></td>
                                        <td><?= $matches_odds[$item->matchId]['europeOdds'][7]; ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class="table" border="1">
                                    <tr>
                                        <td><?= $matches_odds[$item->matchId]['overUnder'][2]; ?></td>
                                        <td><?= $matches_odds[$item->matchId]['overUnder'][3]; ?></td>
                                        <td><?= $matches_odds[$item->matchId]['overUnder'][5]; ?></td>
                                        <td><?= $matches_odds[$item->matchId]['overUnder'][6]; ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><?= $matches_odds[$item->matchId]['overUnder'][4]; ?></td>
                                        <td></td>
                                        <td><?= $matches_odds[$item->matchId]['overUnder'][7]; ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <?php if( isset($matches_odds[$item->matchId]['handicapHalf']) ):?>
                                <table class="table" border="1">
                                    <tr>
                                        <td><?= $matches_odds[$item->matchId]['handicapHalf'][2]; ?></td>
                                        <td><?= $matches_odds[$item->matchId]['handicapHalf'][3]; ?></td>
                                        <td><?= $matches_odds[$item->matchId]['handicapHalf'][5]; ?></td>
                                        <td><?= $matches_odds[$item->matchId]['handicapHalf'][6]; ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><?= $matches_odds[$item->matchId]['handicapHalf'][4]; ?></td>
                                        <td></td>
                                        <td><?= $matches_odds[$item->matchId]['handicapHalf'][7]; ?></td>
                                    </tr>
                                </table>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if( isset($matches_odds[$item->matchId]['overUnderHalf']) ):?>
                                <table class="table" border="1">
                                    <tr>
                                        <td><?= $matches_odds[$item->matchId]['overUnderHalf'][2]; ?></td>
                                        <td><?= $matches_odds[$item->matchId]['overUnderHalf'][3]; ?></td>
                                        <td><?= $matches_odds[$item->matchId]['overUnderHalf'][5]; ?></td>
                                        <td><?= $matches_odds[$item->matchId]['overUnderHalf'][6]; ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><?= $matches_odds[$item->matchId]['overUnderHalf'][4]; ?></td>
                                        <td></td>
                                        <td><?= $matches_odds[$item->matchId]['overUnderHalf'][7]; ?></td>
                                    </tr>
                                </table>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                    <?php endif;?>
                </td>
            </tr>
            <?php endforeach; ?>   
        </tbody>
    </table>
</div>
<?php endforeach; ?>