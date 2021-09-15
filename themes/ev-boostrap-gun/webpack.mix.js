const mix = require("laravel-mix");

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

let theme = 'ev-boostrap-gun';


mix.setPublicPath("public/themes/ev-boostrap-gun")
    .js(`${__dirname}/js/app.js`, "js")
    .sass(`${__dirname}/sass/app.scss`, "css");
