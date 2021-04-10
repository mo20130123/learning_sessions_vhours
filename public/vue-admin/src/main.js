import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import $ from "jquery";
import vuetify from './plugins/vuetify';
import jqueryUiSortableNpm from 'jquery-ui-sortable-npm';

import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Nl2br from 'vue-nl2br'

//------------Start fontawesome--------------
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { fab } from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Swal from 'sweetalert2'
import spinnerPagnation from '@/components/spinner-pagnation';
import ActionRowTd from '@/components/action-row-td';
import VuePageTransition from 'vue-page-transition';         //https://www.npmjs.com/package/vue-page-transition

Vue.use(VuePageTransition)

library.add(fab, far, fas)
Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.component('nl2br', Nl2br)


// Link:-> https://www.npmjs.com/package/vue-morris
import Raphael from 'raphael/raphael'
global.Raphael = Raphael;

Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)
// Link:-> https://bootstrap-vue.js.org/docs/icons/
// Link:-> https://icons.getbootstrap.com/

window.Swal = Swal;
window.Noty = require('noty');
window.jqueryFormValidator = require('noty');

Noty.overrideDefaults({
    layout: 'topRight',
    timeout: 3000 ,
});

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('spinnerPagnation', spinnerPagnation);
Vue.component('ActionRowTd', ActionRowTd);



window.$ = window.jQuery = require('jquery');

Vue.config.productionTip = false

window.Admin_BASE_url = process.env.VUE_APP_Admin_BASE_url;

Vue.use(require('vue-moment')); // https://www.npmjs.com/package/vue-moment


import CKEditor from '@ckeditor/ckeditor5-vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

window.CKEditor = CKEditor;
window.ClassicEditor = ClassicEditor;

Vue.use( CKEditor );


new Vue({
  router,
  store,
  vuetify,
  $,
  render: h => h(App)
}).$mount('#app')

//============================================vue mixin========================================
Vue.mixin({
   data: () => ({
     Permissions: localStorage.getItem('Permissions').split(',')
   }),
   methods: {
       capitalize: str => str.charAt(0).toUpperCase() + str.slice(1),
       escapeSpecialChars(jsonString)
       {
         return jsonString.replace(/\n/g, "\\n")
                                .replace(/\r/g, "\\r")
                                .replace(/\t/g, "\\t")
                                .replace(/\f/g, "\\f");
       },
       check_Permission(Perm)
       {
         if(this.Permissions[0] != 'is_super_admin')
         {
            if(Perm) {
               if(this.Permissions.indexOf(Perm) == -1){
                  this.$router.push('/');
               }
            }
         }
       },

       capitalize: str => str.charAt(0).toUpperCase() + str.slice(1),
       escapeSpecialChars(jsonString)
       {
         return jsonString.replace(/\n/g, "\\n")
                                .replace(/\r/g, "\\r")
                                .replace(/\t/g, "\\t")
                                .replace(/\f/g, "\\f");
       },
       Preview_image(e,from_id)
       {  console.log('Preview_image => '+from_id);
         if(e) {
            $('#'+from_id).attr('src', URL.createObjectURL(e));
         }
       },
       Preview_image_Vue(e,item)
       {
           console.log('-------');
            console.log('Preview_image => object');
         if(e) {
           item.image = URL.createObjectURL(e);
            // $('#'+from_id).attr('src', URL.createObjectURL(e));
         }
       },
   },//End methods
   filters: {
      capitalize: str => str.charAt(0).toUpperCase() + str.slice(1),
      characters_limit(longString,number)
      {
         if(longString.length > number) {
           return longString.substr(0, number) + ' ...';
         }
         else {
           return longString;
         }
     },
     replace_underscore_with_space(the_string)
     {
        if(the_string)
            return  the_string.split("_").join(" ");
     },
  }//End filters

});
