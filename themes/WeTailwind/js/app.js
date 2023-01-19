/**
 * Javascript
 */

/**
 * LOAD VENDOR SCRIPTS
 */

window._ = require('lodash');


/**
 * Require custom prototypes
 */
 require('./prototypes');


// WE
window.WE = {};

// LUXON
let { DateTime } = require('luxon');
window.DateTime = DateTime;

require('./IMG');
require('./utils');
require('./sortable');
require('./FX');
require('./wysiwyg');

// WEF
window.addEventListener("wef-replace-value-on-frontend", (event) => {
    document.getElementById(event.detail.target).innerHTML = event.detail.wef_value;
});