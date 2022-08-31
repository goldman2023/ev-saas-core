/**
 * Javascript
 */

/**
 * LOAD VENDOR SCRIPTS
 */

window._ = require('lodash');
// window.axios = require('axios');
// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;

// try {
//     window.$ = window.jQuery = require('jquery');
// } catch (e) {}

/**
 * Require custom prototypes
 */
 require('./prototypes');


// WE
window.WE = {};

require('./IMG');
require('./utils');
// require('./leaflet');
require('./sortable');
require('./FX');

// LUXON
let { DateTime } = require('luxon');
window.DateTime = DateTime;

// FLARE (FE)
/*import { flare } from "@flareapp/flare-client";

// only launch in production, we don't want to waste your quota while you're developing.
if (process.env.NODE_ENV === 'production') {
    flare.light('your-project-key');
}*/

// import lazySizes from 'lazysizes';
// import 'lazysizes/plugins/native-loading/ls.native-loading';

// lazySizes.cfg.nativeLoading = {
// 	setLoadingAttribute: true,
// 	disableListeners: {
// 		scroll: true
// 	},
// };
