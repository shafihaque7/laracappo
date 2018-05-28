
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('navbar',require('./components/Navbar.vue'));
Vue.component('articles',require('./components/Articles.vue'));

const app = new Vue({
    el: '#app'
});

const isIos = () => {
   const userAgent = window.navigator.userAgent.toLowerCase();
   return /iphone|ipad|ipod/.test( userAgent );
 }
 // Detects if device is in standalone mode
 const isInStandaloneMode = () => ('standalone' in window.navigator) && (window.navigator.standalone);
 
 // Checks if should display install popup notification:
 if (isIos() && !isInStandaloneMode()) {
   this.setState({ showInstallMessage: true });
 }