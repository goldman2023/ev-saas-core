import Sortable from 'sortablejs';
import flatpickr from "flatpickr";
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import intersect from '@alpinejs/intersect';

window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('jquery-mask-plugin')
    require('select2');
    window.flatpickr = flatpickr;
    window.Sortable = Sortable;
    window.Quill = require('quill');
    require('slick-carousel');
    require('ion-rangeslider');
    require('daterangepicker');

    require('bootstrap/dist/js/bootstrap.bundle.min.js'); // includes popper.js by default 1.16.1

    /* eXtend Alpine and start it */
    /*Alpine.plugin(persist);
    Alpine.plugin(intersect);
    window.Alpine = Alpine;
    Alpine.start();*/
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

window.EV = {};
require('./form');
