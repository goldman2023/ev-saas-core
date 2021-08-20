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

// NOTE: These webpacks are compiled from root folder by running ./development.sh! This means that paths are relative to the ROOT folder!
// That is the reason why public path starts with "public/etc.", and not with "../../public/etc."!!!
let theme = 'ev-tailwind-bocmanas';


mix.setPublicPath("public/themes/ev-tailwind-bocmanas")
    .js(`${__dirname}/js/app.js`, "js")
    .postCss(`${__dirname}/css/app.css`, "css", [
        require("postcss-import"),
        require("tailwindcss")({
            config: `${__dirname}/tailwind.config.js`,
        }),
        require("autoprefixer"),
    ]);
