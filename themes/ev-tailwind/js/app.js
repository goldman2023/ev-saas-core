/**
 * Javascript
 */

/**
 * LOAD VENDOR SCRIPTS
 */

window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector('meta[name="csrf-token"]').content;

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import intersect from '@alpinejs/intersect';
Alpine.plugin(persist);
Alpine.plugin(intersect);
window.Alpine = Alpine;
Alpine.start();

// LUXON
let { DateTime } = require('luxon');
window.DateTime = DateTime;

// FLARE (FE)
/*import { flare } from "@flareapp/flare-client";

// only launch in production, we don't want to waste your quota while you're developing.
if (process.env.NODE_ENV === 'production') {
    flare.light('your-project-key');
}*/

