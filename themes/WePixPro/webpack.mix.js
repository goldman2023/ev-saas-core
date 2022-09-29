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
let theme = 'WePixPro';

let parentTheme = 'EvTailwind'
console.log("DIRNAME");

const THEME_DIR = __dirname;

mix.setPublicPath(`public/themes/${parentTheme}`)
    .js(`${THEME_DIR}/js/app.js`, `public/themes/${parentTheme}/js`).version()
    .js(`${THEME_DIR}/js/alpine.js`, `public/themes/${parentTheme}/js`).version()
    // .js(`${THEME_DIR}/js/editor.js`, `public/themes/${parentTheme}/js`).version()
    .sass(`${THEME_DIR}/scss/app.scss`, `public/themes/${parentTheme}/css`, {}, [
        tailwindcss(`${THEME_DIR}/tailwind.config.js`), // IT HAS TO BE ADDED HERE, OTHERWISE IT WON'T WORK!
    ]).options({
        processCssUrls: false,
    }).version()
    // .copyDirectory(`${__dirname}/images`, `public/themes/${theme}/images`)
    .webpackConfig({
        resolve: {
            alias: {
                '@': path.resolve(`themes/${parentTheme}`),
            },
        }
    })
    .minify([`public/themes/${parentTheme}/js/app.js`])
    .minify(`public/themes/${parentTheme}/css/app.css`);
