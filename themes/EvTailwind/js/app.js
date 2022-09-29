/**
 * Javascript
 */

/**
 * LOAD VENDOR SCRIPTS
 */

// window._ = require('lodash');


/**
 * Require custom prototypes
 */
 require('./prototypes');


// WE
window.WE = {};

require('./IMG');
require('./utils');
require('./sortable');
require('./FX');

// LUXON
let { DateTime } = require('luxon');
window.DateTime = DateTime;
