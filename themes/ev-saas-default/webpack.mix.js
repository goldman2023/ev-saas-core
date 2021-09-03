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
    .js(`${__dirname}/js/aiz-core.js`, `public/themes/${theme}/js`).version()
    .js(`${__dirname}/js/vue.js`, `public/themes/${theme}/js`).vue({ version: 2 }).version() // Uses Vue v2
    .sass(`${__dirname}/scss/app.scss`, `public/themes/${theme}/css`).options({
        processCssUrls: false
    }).version()
    .copyDirectory(`${__dirname}/images`, `public/themes/${theme}/images`)
    .copyDirectory(`${__dirname}/vendor`, `public/themes/${theme}/vendor`)
    .copyDirectory(`${__dirname}/svg`, `public/themes/${theme}/svg`)
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve(`themes/${theme}`),
                'vue@': path.resolve(`themes/${theme}/js/components`), // vue@ is base path alias for Vue components inside a specific theme. Used if we need to override styling or html or anything to be theme specific!
                'r@': path.resolve(`resources`),
                'r-vue@': path.resolve(`resources/js/components`) // r-vue means: Vue files in resources/js. These are non-theme dependent files. Can be overriden with in theme by including vue files with 'vue@'.
            },
        }
    });
