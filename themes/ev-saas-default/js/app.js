/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');



$(document).ready(function() {
    let headerScrolled = false;

    $(window).scroll(function() {
        $("body").addClass('body-has-scrolled');
        clearTimeout($.data(this, 'scrollTimer'));
        $.data(this, 'scrollTimer', setTimeout(function() {
            $("body").addClass('body-has-scrolled');
            headerScrolled = true;
            console.log("Haven't scrolled in 250ms!");
            console.log($("body").scrollTop());
            if($(window).scrollTop() > 200) {
                $("body").addClass('body-has-scrolled');
            } else {
                $("body").removeClass('body-has-scrolled');
            }
        }, 150));
    });
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/*const app = new Vue({
    el: '#app',
});*/
