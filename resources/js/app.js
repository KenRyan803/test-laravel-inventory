/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';

// VFORM
import { Form, HasError, AlertError } from 'vform';
window.Form = Form;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

// VUE PROGRESS BAR
import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {
    color: 'rgb(47, 163, 96)',
    failedColor: 'red',
    height: '10px'
})

// SWAL 2
import Swal from 'sweetalert2';
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

const Toast2 = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

window.Toast = Toast;
window.Toast2 = Toast2;

// VUE ROUTER
import VueRouter from 'vue-router';
Vue.use(VueRouter)

// VUE FILTERS
Vue.filter('toUppercase', function(text){
    return text.toUpperCase();
});

Vue.filter('created_date', function(createDate){
    return moment(createDate).format('MMMM Do YYYY, h:mm:ss a');
});

// DATATABLE
import DataTable from 'laravel-vue-datatable';
Vue.use(DataTable);

// VUE SELECT
import vSelect from 'vue-select';
Vue.component('v-select', vSelect)

// VUE HTML TO PAPER
import VueHtmlToPaper from "vue-html-to-paper";

const options = {
    name: "_blank",
    specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
    styles: [
      "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css",
      "https://unpkg.com/kidlat-css/css/kidlat.css"
    ]
  };
  
  Vue.use(VueHtmlToPaper, options);

// GLOBAL CUSTOM EVENT LISTENER
window.Fire = new Vue();;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/add_product', component: require('./components/Product.vue').default },
    { path: '/add_category', component: require('./components/ProductCategory.vue').default },
    { path: '/add_supplier', component: require('./components/Supplier.vue').default },
    { path: '/systemlogs', component: require('./components/SystemLogs.vue').default },
    { path: '/stock_entry', component: require('./components/StockEntry.vue').default },
    { path: '/view_stocks', component: require('./components/ViewStockEntry.vue').default },
    { path: '/pos', component: require('./components/POS.vue').default },
    { path: '/customers', component: require('./components/Customers.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/invoices', component: require('./components/Invoices.vue').default },
    { path: '*', component: require('./components/404.vue').default }
]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

// Vue.component(
//     'passport-clients',
//     require('./components/passport/Clients.vue').default
// );

// Vue.component(
//     'passport-authorized-clients',
//     require('./components/passport/AuthorizedClients.vue').default
// );

// Vue.component(
//     'passport-personal-access-tokens',
//     require('./components/passport/PersonalAccessTokens.vue').default
// );

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});

// or
// const app = new Vue({
//     router
// }).$mount('#app');
