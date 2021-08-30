/**
 * Load Vue and it's plugins on demand.
 */
import Vue from 'vue2/dist/vue.js';
import Laraform from '@laraform/laraform';

// Import Form Vue Components
import ProductForm from 'r-vue@/ProductForm.vue';


Laraform.config({
    theme: 'bs4' // This theme uses Bootstrap 4 theme
})

Vue.use(Laraform);
Vue.component('product-form', ProductForm);

const app = new Vue({
    el: '#app'
});
