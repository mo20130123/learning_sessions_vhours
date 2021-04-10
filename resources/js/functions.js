
window.escapeSpecialChars = function(jsonString) {
    return jsonString
        .replace(/\n/g, "\\n").replace(/\r/g, "\\r")
        .replace(/\t/g, "\\t").replace(/\f/g, "\\f");
}

// module.exports = {
//   escapeSpecialChars
// };

window.ProductMixin = {
    data: () => ({
      site_lang:site_lang,
    }),
    methods: {
        // lacal(word) { return lacal(word); },
        add_to_wishlist(item)
        {
            if (member_id == 0) {
                //if not auth
                // new Noty({text: lacal("Must login first"), layout: "center", type: "error", timeout: 2000}).show();
                new Noty({text: "Must login first", layout: "center", type: "error", timeout: 2000}).show();
                return;
            }
            else
            {
              axios.get(`${site_url}/WishList/addOrRemove/${item.id}`)
                    .then(response => {
                        if (response.data.status == "success") {
                            item.in_wish_list = response.data.case;
                        }
                    })
                    .catch( error => {
                       console.log(error);
                    });
            }
        },
        item_is_out_of_stock()
        {
          new Noty({ text: lacal("item is out of stock"), layout: "center", type: "error",  timeout: 2000 }).show();
          return;
        }
    } //End methods
}; //End ProductMixin
