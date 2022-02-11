// TODO: FIX mix-manifest.json! For now mix() doesn't work cuz compiling tenant-theme css overrides mix-manifest.json!
const mix = require("laravel-mix");
const os = require('os');
let sassVars = require("get-sass-vars");
let _ = require('lodash');
const path = require("path");
const fs = require("fs");

const tailwindcss = require('tailwindcss');


const yargs = require('yargs/yargs');
const { hideBin } = require('yargs/helpers');
const argv = yargs(hideBin(process.argv)).argv;

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

let childThemes = ['ev-saas-fox', 'ev-saas-gun'];
mix.setPublicPath(`public/themes/${theme}`)
    .webpackConfig({
        resolve: {
            alias: {
                // -------- Theme resources paths -------- //
                '@': path.resolve(`themes/${theme}`),
                'scss@': path.resolve(`themes/${theme}/scss`),
                'js@': path.resolve(`themes/${theme}/js`),
                'vue@': path.resolve(`themes/${theme}/js/components`), // vue@ is base path alias for Vue components inside a specific theme. Used if we need to override styling or html or anything to be theme specific!
                // -------- Default resources paths -------- //
                'r@': path.resolve(`resources`),
                'r-scss@': path.resolve(`resources/scss`),
                'r-js@': path.resolve(`resources/js`),
                'r-vue@': path.resolve(`resources/js/components`) // r-vue means: Vue files in resources/js. These are non-theme dependent files. Can be overriden with in theme by including vue files with 'vue@'.
            },
        }
    });

// Object Entries polyfill
if (!Object.entries) {
    (function () {
        let hasOwn = Object.prototype.hasOwnProperty;

        Object.entries = function (obj) {
            let entrys = [];

            for (let name in obj) {
                if (hasOwn.call(obj, name)) {
                    entrys.push([name, obj[name]]);
                }
            }

            return entrys;
        };
    })();
}

// Remove First Char. Match
String.prototype.removeFirstMatch = function (char) {
    for (let i = 0; i < this.length; i++) {
        if (this.charAt(i) == char) {
            return this.slice(0, i) + this.slice(i + 1, this.length);
        }
    }
    return this;
}


mix.js(`${__dirname}/js/app.js`, `public/themes/${theme}/js`).version()
    .js(`${__dirname}/js/aiz-core.js`, `public/themes/${theme}/js`).version()
    .js(`${__dirname}/js/alpine.js`, `public/themes/${theme}/js`).version()
    .js(`${__dirname}/js/vue.js`, `public/themes/${theme}/js`)/*.vue({ version: 2 })*/.version() // Uses Vue v2 // TODO: Fix vue-loader version issue before using .vue()
    .sass(`${__dirname}/scss/app.scss`, `public/themes/${theme}/css`, {
        sassOptions: {
            processCssUrls: false
        },
        additionalData: fs.readFileSync(`${__dirname}/scss/themes/_default.scss`).toString() // Get default theme variables!
    }).version()
    .sass(`${__dirname}/scss/tailwind.scss`, `public/themes/${theme}/css`, {}, [
        tailwindcss(`${__dirname}/tailwind.config.js`), // IT HAS TO BE ADDED HERE, OTHERWISE IT WON'T WORK!
    ]).options({
        processCssUrls: false,
    }).version()
    .copy(`${__dirname}/js/crud/*.js`, `public/themes/${theme}/js/crud`)
    .copyDirectory(`${__dirname}/images`, `public/themes/${theme}/images`)
    .copyDirectory(`${__dirname}/vendor`, `public/themes/${theme}/vendor`)
    .copyDirectory(`${__dirname}/svg`, `public/themes/${theme}/svg`)
