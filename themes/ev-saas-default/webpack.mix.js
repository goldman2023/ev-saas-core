const mix = require("laravel-mix");
const tailwindcss = require('tailwindcss');
const path = require("path");

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

// NOTE: These webpacks are compiled from root folder by running ./development.sh! This means that paths are relative to the ROOT folder!
// That is the reason why public path starts with "public/etc.", and not with "../../public/etc."!!!
let theme = 'ev-saas-default';

mix.setPublicPath(`public/themes/${theme}`)
    .js(`${__dirname}/js/app.js`, `public/themes/${theme}/js`).version()
    .sass(`${__dirname}/scss/app.scss`, `public/themes/${theme}/css`).version()
    .copyDirectory(`${__dirname}/images`, `public/themes/${theme}/images`)
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve(`themes/${theme}`),
            },
        }
    });
