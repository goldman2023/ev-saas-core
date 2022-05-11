const mix = require("laravel-mix");
const tailwindcss = require('tailwindcss');
const path = require("path");
const { exit } = require("process");

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
let theme = 'ev-tailwind';
// console.log(path.resolve('we-edit/grapesjs'));

mix.setPublicPath(`public/themes/${theme}`)
    .js(`${__dirname}/js/app.js`, `public/themes/${theme}/js`).version()
    /* We edit Compilation - REMOVED Path was moved to /themes/features/we-edit */
    // .js(`${__dirname}/we-edit/src/index.js`, `public/themes/${theme}/we-edit`).version()
    // .js(`${__dirname}/js/aiz-core.js`, `public/themes/${theme}/js`).version()
    .js(`${__dirname}/js/alpine.js`, `public/themes/${theme}/js`).version()
    .sass(`${__dirname}/scss/app.scss`, `public/themes/${theme}/css`, {}, [
        tailwindcss(`${__dirname}/tailwind.config.js`), // IT HAS TO BE ADDED HERE, OTHERWISE IT WON'T WORK!
    ]).options({
        processCssUrls: false,
        //postCss: [ tailwindcss(`${__dirname}/tailwind.config.js`) ], // NOT HERE!
    }).version()
    // .copyDirectory(`${__dirname}/fonts`, `public/themes/${theme}/fonts`)
    // .copyDirectory(`${__dirname}/svg`, `public/themes/${theme}/svg`)
    .copyDirectory(`${__dirname}/images`, `public/themes/${theme}/images`)
    // .copyDirectory(`${__dirname}/js`, `public/themes/${theme}/js`)
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve(`themes/${theme}`),
            },
        }
    })
    .minify([`public/themes/${theme}/js/app.js`, `public/themes/${theme}/js/alpine.js`])
    .minify(`public/themes/${theme}/css/app.css`);
