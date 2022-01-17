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
                <th>leagueId</th>
                <th>name</th>
                <th>shortName</th>
                <th>subLeagueName</th>
                <th>type</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item of items">
                <th>{{ item.leagueId }}</th>
                <td>{{ item.name }}</td>
                <td>{{ item.shortName }}</td>
                <td>{{ item.subLeagueName }}</td>
                <td>{{ item.type }}</td>
              </tr>
              
            </tbody>
          </table>
    </div>
    <script>
      var app = new Vue({
          el: '#app',
          data: {
            api_root: 'ajax.php?action=league',
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