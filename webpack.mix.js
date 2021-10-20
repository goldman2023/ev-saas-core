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

 /* TODO: Document this propertly right now it's a test using getstream.io react chat sdk */
 mix.js('resources/js/feed.js', 'public/js').react().extract(['react', 'react-dom']);



/* Minimal dependency requirements for public parts of the website */
mix.scripts([
    'resources/js/admin/vendors.js',
    'resources/js/vendor/aiz-core.js',
], 'public/assets/js/vendors.js');

/* EV SaaS + HS Core In admin panel */
mix.js('resources/js/admin/ev-saas.js', 'public/assets/admin/js/ev-saas.js').version()

mix.scripts([
    'resources/js/vendor/vendors.js',
    'resources/js/vendor/aiz-core.js',
], 'public/assets/js/vendors-guest.js');

mix.setPublicPath("public")
    .js('resources/js/app.js', 'public/js').version()
    .sass('resources/scss/app.scss', 'public/css').version()
    .sass('resources/scss/admin/admin.scss', 'public/ev-assets/admin/css').version()
    // .sass('resources/scss/app.scss', 'public/ev-assets/css').version()
    /* Minimal dependency requirements for public parts of the CENTRAL EV-SAAS app AND Tenants Dashboards! */
    .scripts([
        'resources/js/admin/vendors.js',
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
