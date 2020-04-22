require('./bootstrap');

window.Vue = require('vue');

import App from './App.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import {routes} from './routes';
import { VuejsDatatableFactory } from 'vuejs-datatable';
import VueSidebarMenu from 'vue-sidebar-menu';
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css';
import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';
import VueSimpleAlert from "vue-simple-alert";

Vue.use(VueSimpleAlert);
Vue.use( VuejsDatatableFactory );
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(VueSidebarMenu);

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});

