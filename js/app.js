var app = new Vue({
    el: '#app',
    data: {
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