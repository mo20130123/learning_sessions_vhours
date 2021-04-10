// require('./bootstrap');
window.Swiper = require('Swiper');

import Vue from 'vue';

window.Vue = Vue;

window.Noty = require('noty');

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import AOS from 'aos';
AOS.init();


Vue.component('pagination', require('laravel-vue-pagination'));

Vue.component('spinner1', require('./components/spinner1.vue').default);
Vue.component('spinner2', require('./components/spinner2.vue').default);
Vue.component('spinner3', require('./components/spinner3.vue').default);
Vue.component('spinner-mini', require('./components/spinner-mini.vue').default);
Vue.component('z-row', require('./components/ZRows/z-row').default);
Vue.component('z-col', require('./components/ZRows/z-col').default);

