const mix = require("laravel-mix");
const tailwindcss = require('tailwindcss');
const path = require("path");
const fs = require('fs');

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
let theme = 'WeBaltic';
let defaultTheme = 'EvTailwind';

mix.setPublicPath(`public/themes/${theme}`);


// App.js
if (fs.existsSync(`${__dirname}/js/app.js`)) {
    mix.js(`${__dirname}/js/app.js`, `js`).version();
} else {
    mix.js(`${__dirname}/../${defaultTheme}/js/app.js`, `js`).version();
}

// Alpine.js
if (fs.existsSync(`${__dirname}/js/alpine.js`)) {
    mix.js(`${__dirname}/js/alpine.js`, `js`).version();
} else {
    mix.js(`${__dirname}/../${defaultTheme}/js/alpine.js`, `js`).version();
}

// Editor.js
if (fs.existsSync(`${__dirname}/js/editor.js`)) {
    mix.js(`${__dirname}/js/editor.js`, `js`).version();
} else {
    mix.js(`${__dirname}/../${defaultTheme}/js/editor.js`, `js`).version();
}

// Theme SCSS
if (fs.existsSync(`${__dirname}/scss/app.scss`)) {
    mix.sass(`${__dirname}/scss/app.scss`, `css`, {}, [
        tailwindcss(`${__dirname}/tailwind.config.js`), // IT HAS TO BE ADDED HERE, OTHERWISE IT WON'T WORK!
    ]).options({
        processCssUrls: false,
    }).version()
} else {
    mix.sass(`${__dirname}/../${defaultTheme}/scss/app.scss`, `css`, {}, [
        tailwindcss(`${__dirname}/../${defaultTheme}/tailwind.config.js`), // IT HAS TO BE ADDED HERE, OTHERWISE IT WON'T WORK!
    ]).options({
        processCssUrls: false,
    }).version()
}
    
// Images
if (fs.existsSync(`${__dirname}/images`)) {
    mix.copyDirectory(`${__dirname}/images`, `images`);
} else {
    mix.copyDirectory(`${__dirname}/../${defaultTheme}/images`, `images`)
}

// Other actions
mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve(`themes/${theme}`),
        },
    }
})
.minify([
    `public/themes/${theme}/js/app.js`, 
    `public/themes/${theme}/css/app.css`
]);