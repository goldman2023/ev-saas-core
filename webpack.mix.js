const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').vue()
   .sass('resources/sass/app.scss', 'public/css')


/* Minimal dependency requirements for public parts of the website */
mix.scripts([
    'resources/js/vendor/vendors.js',
    'resources/js/vendor/aiz-core.js',
], 'public/assets/js/vendors.js');


mix.scripts([
    'resources/js/flare.js',
], 'public/assets/js/flare.js');
