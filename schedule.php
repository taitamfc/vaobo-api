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
    <div class="container" id="app">
        <p v-if="!items"> Loading </p>

        <table class="table" v-if="items">
            <thead>
              <tr>
                <th>homeName</th>
                <th>awayName</th>
                <th>leagueName</th>
                <th>matchId</th>
                <th>matchTime</th>
                <th>status</th>
                <th>scores</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item of items">
                <td>{{ item.homeName }}</td>
                <td>{{ item.awayName }}</td>
                <td>{{ item.leagueName }}</td>
                <td>{{ item.matchId }}</td>
                <td>{{ item.matchTime }}</td>
                <td>{{ item.status }}</td>
                <td>{{ item.homeScore }} - {{ item.awayScore }}</td>
              </tr>
              
            </tbody>
          </table>
    </div>
    <?php
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date   = ( isset($_GET['date']) ) ? $_GET['date'] : date('Y-m-d');
    ?>
    <script>
      var app = new Vue({
          el: '#app',
          data: {
            api_root: 'ajax.php?action=schedule&date=<?= $date; ?>',
            message: 'Hello Vue 123',
            items: null
          },
          methods: {
            getItems() {
              axios.get(this.api_root)
                .then((response) => {
                  this.items = response.data.data
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