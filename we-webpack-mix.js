function compileTheme(mix, dirname, theme, defaultTheme = 'WeTailwind') {

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
    
    mix.setPublicPath(`public/themes/${theme}`);

    // Images - (IMPORTANT: We must use full public path in second parameter, cuz for some reason, setPublicPath above doesn't affect copyDirectory() method!)
    if (fs.existsSync(`${dirname}/images`)) {
        mix.copyDirectory(`${dirname}/images`, `public/themes/${theme}/images`);
    } else {
        mix.copyDirectory(`${dirname}/../${defaultTheme}/images`, `public/themes/${theme}/images`)
    }
    
    // App.js
    if (fs.existsSync(`${dirname}/js/app.js`)) {
        mix.js(`${dirname}/js/app.js`, `js`).version();
    } else {
        mix.js(`${dirname}/../${defaultTheme}/js/app.js`, `js`).version();
    }
    
    // Alpine.js
    if (fs.existsSync(`${dirname}/js/alpine.js`)) {
        mix.js(`${dirname}/js/alpine.js`, `js`).version();
    } else {
        mix.js(`${dirname}/../${defaultTheme}/js/alpine.js`, `js`).version();
    }
    
    // Editor.js
    if (fs.existsSync(`${dirname}/js/editor.js`)) {
        mix.js(`${dirname}/js/editor.js`, `js`).version();
    } else {
        mix.js(`${dirname}/../${defaultTheme}/js/editor.js`, `js`).version();
    }
    
    // Theme SCSS
    if (fs.existsSync(`${dirname}/scss/app.scss`)) {
        mix.sass(`${dirname}/scss/app.scss`, `css`, {}, [
            tailwindcss(`${dirname}/tailwind.config.js`), // IT HAS TO BE ADDED HERE, OTHERWISE IT WON'T WORK!
        ]).options({
            processCssUrls: false,
        }).version()
    } else {
        mix.sass(`${dirname}/../${defaultTheme}/scss/app.scss`, `css`, {}, [
            tailwindcss(`${dirname}/../${defaultTheme}/tailwind.config.js`), // IT HAS TO BE ADDED HERE, OTHERWISE IT WON'T WORK!
        ]).options({
            processCssUrls: false,
        }).version()
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

    return mix;
}

module.exports = { compileTheme };