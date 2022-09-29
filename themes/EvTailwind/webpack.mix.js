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
let theme = 'EvTailwind';

mix.setPublicPath(`public/themes/${theme}`)
    .js(`${__dirname}/js/app.js`, `public/themes/${theme}/js`).version()
    .js(`${__dirname}/js/alpine.js`, `public/themes/${theme}/js`).version()
    .js(`${__dirname}/js/editor.js`, `public/themes/${theme}/js`).version()
    .sass(`${__dirname}/scss/app.scss`, `public/themes/${theme}/css`, {}, [
        tailwindcss(`${__dirname}/tailwind.config.js`), // IT HAS TO BE ADDED HERE, OTHERWISE IT WON'T WORK!
    ]).options({
        processCssUrls: false,
    }).version()
    .copyDirectory(`${__dirname}/images`, `public/themes/${theme}/images`)
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve(`themes/${theme}`),
            },
        }
    })
    .minify([`public/themes/${theme}/js/app.js`])
    .minify(`public/themes/${theme}/css/app.css`);
