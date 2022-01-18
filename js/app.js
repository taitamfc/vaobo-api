const instance = axios.create({
    baseURL: 'http://api.isportsapi.com',
    timeout: 1000,
    crossdomain: true,
    headers: {
        'Access-Control-Allow-Origin': '*',
        'Access-Control-Allow-Headers' : 'Origin, X-Requested-With, Content-Type, Accept'
    }
  });

var app = new Vue({
    el: '#app',
    data: {
        api_key: '?api_key=WC14dVgAUBsTzcDD',
        api_root: 'ajax.php',
        message: 'Hello Vue 123',
        items: null
    },
    methods: {
        getItems() {
            axios.get(this.api_root)
            .then( (response) => {
                this.items = response.data.data
            });
        }
    },
    mounted: function () {
        this.getItems();
    }
});

console.log(axios);