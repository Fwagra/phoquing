
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
dateformat = require('dateformat');
window.Vue = require('vue');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(require('vue-resource'));
Vue.component('current-tracks', require('./components/CurrentTracks.vue'));
Vue.http.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;
Vue.prototype.$hourFormat = "HH:MM";
Vue.prototype.$yearFormat = "yyyy-mm-dd";
const app = new Vue({
    el: '#content-app'
});
