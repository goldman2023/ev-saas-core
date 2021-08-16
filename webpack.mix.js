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
