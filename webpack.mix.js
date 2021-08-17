const mix = require('laravel-mix');
const path = require("path");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management for CENTRAL APP and ADMIN DASHBOARD
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */



/* Minimal dependency requirements for public parts of the website */
mix.scripts([
    'resources/js/vendor/jquery.js',
    'resources/js/vendor/uppy.js',
    'resources/js/vendor/footable.js',
    'resources/js/vendor/chart.js',
    'resources/js/vendor/aiz-core.js',
], 'public/assets/js/vendors.js');

mix.scripts([
    'resources/js/vendor/vendors.js',
    'resources/js/vendor/aiz-core.js',
], 'public/assets/js/vendors-guest.js');

mix.setPublicPath("public")
    .js('resources/js/app.js', 'public/js').vue().version()
    .sass('resources/scss/app.scss', 'public/css').version()
    /* Minimal dependency requirements for public parts of the CENTRAL EV-SAAS app AND Tenants Dashboards! */
    .scripts([
        'resources/js/vendor/intlTelutils.js',
        'resources/js/vendor/aiz-core.js',
    ], 'public/js/vendors.js').version()
    .scripts([
        'resources/js/flare.js',
    ], 'public/js/flare.js').version()
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve('./resources'),
            },
        }
    });
