import Vue from 'vue';
import EventBus from './event-bus';
import './bootstrap';
import './admin-lte.js';
import 'toastr';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('user-table', require('./components/UserTable'));
Vue.component('filter-bar', require('./components/FilterBar'))

new Vue({
    el: '#app'
});

$(window).on('load', function(){
    $('#loader').fadeOut();
});

