<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ISPORTAPI</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/vue.js"></script>
    <script src="./js/axios.min.js"></script>
    
</head>
<body>
    <div class="container-fluid" id="app">
        <p v-if="!matches"> Loading </p>
        <div class="item" v-for="(items, index) in matches">
            <h4>{{ leagues[index] }}</h4>
            <table class="table" v-if="items">
                <tbody>
                    <tr v-for="item of items">
                        <td>{{ item.matchTime }} <br> {{ item.matchId }}</td>
                        <td>{{ item.homeName }} <br> {{ item.awayName }}</td>
                        <td v-if="matches_odd[item.matchId]" width="200px">
                            <table class="table">
                                <tr>
                                    <td>handicap</td>
                                    <td>europeOdds</td>
                                    <td>overUnder</td>
                                    <td>handicapHalf</td>
                                    <td>overUnderHalf</td>
                                </tr>
                                <tr>
                                    <td>{{ (matches_odd[item.matchId]) ? matches_odd[item.matchId]['handicap'] : '' }}</td>
                                    <td>{{ (matches_odd[item.matchId]) ? matches_odd[item.matchId]['europeOdds'] : '' }}</td>
                                    <td>{{ (matches_odd[item.matchId]) ? matches_odd[item.matchId]['overUnder'] : '' }}</td>
                                    <td>{{ (matches_odd[item.matchId]) ? matches_odd[item.matchId]['handicapHalf'] : '' }}</td>
                                    <td>{{ (matches_odd[item.matchId]) ? matches_odd[item.matchId]['overUnderHalf'] : '' }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                
                </tbody>
            </table>
        </div>
    </div>
    <?php
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date   = ( isset($_GET['date']) ) ? $_GET['date'] : date('Y-m-d');
    ?>
    <script>
      var app = new Vue({
          el: '#app',
          data: {
            api_root: 'ajax.php?action=live&date=<?= $date; ?>',
            message: 'Hello Vue 123',
            matches: null,
            leagues: null,
            matchIds: null,
            matches_odd: null,
          },
          methods: {
            getItems() {
                axios.get(this.api_root)
                .then((response) => {
                    this.leagues = response.data.leagues;
                    this.matches = response.data.matches;
                    this.matchIds = response.data.matchIds;
                    this.getOdds();
                });
            },
            getOdds(){
                axios.get('ajax.php?action=pre-match&matchIds='+this.matchIds)
                .then((response) => {
                    this.matches_odd = response.data;
                });
            }
          },
          mounted: function () {
            this.getItems();
            
          }
        });
    </script>
</body>
</html>