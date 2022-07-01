require("./bootstrap");

import Vue from 'vue';
import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';

Vue.use(VueRouter);
Vue.use(BootstrapVue);
window.axios = require('axios');

import App from './views/App';
import Users from './views/Users/Users';

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Users',
      component: Users
    },
  ],
});

const app = new Vue({
  el: '#app',
  components: { App },
  router,
});
