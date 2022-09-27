// TODO: FIX mix-manifest.json! For now mix() doesn't work cuz compiling tenant-theme css overrides mix-manifest.json!
const mix = require("laravel-mix");
const os = require('os');
let sassVars = require("get-sass-vars");
let _ = require('lodash');
const path = require("path");
const fs = require("fs");



const yargs = require('yargs/yargs');
const { hideBin } = require('yargs/helpers');

// TODO: Fix vue-loader error!
// NOTE: If vue is enabled with .vue(), there will be an error in compiling due to vue-loader package.
// Error: Compiling RuleSet failed: Unexpected property test in condition
// Read: https://github.com/laravel-mix/laravel-mix/issues/2613

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


var entry_path = 'themes/';
mix.setPublicPath(`public/themes/${theme}`).js(`${entry_path}/js/app.js`, `public/themes/${theme}/js`).version()
    .js(`${entry_path}/js/alpine.js`, `public/themes/${theme}/js`).version()
    .sass(`${entry_path}/scss/app.scss`, `public/themes/${theme}/css`, {
        sassOptions: {
            processCssUrls: false
        },
    }).version()
    .copy(`${entry_path}/js/crud/*.js`, `public/themes/${theme}/js/crud`);
    // TODO: Note that when .then() function is added, everything is compiled already, so no further compilings are possible!


