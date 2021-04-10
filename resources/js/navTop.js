
let navTop = new Vue({
    el: "#nav-top",
    data: {
      cart_count: 0,
      is_Auth: false
    },
    mounted()
    {
         this.get_card_count();
    },
    methods:{
        get_card_count()
        {
            axios.get(`${site_url}/ShoppingCart/getCount`)
                 .then(response => {
                     this.cart_count = response.data;
                 })
                 .catch( error => {
                    console.log(error);
                 });
        }
    }//End methods
});

window.navTop = navTop;
