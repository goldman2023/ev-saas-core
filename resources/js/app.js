require('./bootstrap');

import Vue from 'vue';
import Laraform from '@laraform/laraform';

Vue.use(Laraform)

const app = new Vue({
  el: '#app'
});
