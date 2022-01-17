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
                <th>matchId</th>
                <th>leagueName</th>
                <th>matchTime</th>
                <th>match</th>
                <th>odds</th>
               
                
              </tr>
            </thead>
            <tbody>
              <tr v-for="item of items">
                <th>{{ item.matchId }}</th>
                <td>{{ item.leagueName }}</td>
                <td>{{ item.matchTime }}</td>
                <td>{{ item.homeName }} vs {{ item.awayName }}</td>
                <td>
                    <ul>
                        <li v-for="odd of item.odds">
                            {{ odd.oddsDetail }}
                        </li>
                    </ul>
                </td>
                
                
              </tr>
              
            </tbody>
          </table>
    </div>
    <script>
      var app = new Vue({
          el: '#app',
          data: {
            api_root: 'ajax.php?action=european',
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