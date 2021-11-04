const mix = require("laravel-mix");
const tailwindcss = require('tailwindcss');
const path = require("path");
const fs = require("fs");
const { spawn } = require("child_process");
let CleanCSS = require('clean-css');

const mysql = require('mysql2/promise');
const { Client } = require('pg');

const yargs = require('yargs/yargs');
const { hideBin } = require('yargs/helpers');
const argv = yargs(hideBin(process.argv)).argv;

let is_compiling_tenant = false;
let tenant_id = '';
if(argv.env !== undefined && argv.env.indexOf('tenant_id=') !== -1) {
    tenant_id = argv.env.split('=',2)[1] || '';
    is_compiling_tenant = true;
}

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
let theme = 'ev-saas-default';
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

// Compile only tenant specific scss
if(is_compiling_tenant) {
    // Check if tenant-theme stylings are present, If not create them by copying default theme styles!
    createTenantCustomStylingVarsFile(tenant_id, theme);

    mix.sass(`${__dirname}/scss/app.scss`, `public/themes/${theme}/css/${tenant_id}.css`, {
            sassOptions: {
                processCssUrls: false
            },
            additionalData: fs.readFileSync(`resources/scss/tenants/${tenant_id}/_variables-${theme}.scss`).toString() // Get tenant-theme variables!
        }).version()
        .then(() => {
            //optimizeCSS(`public/themes/${theme}/css/${tenant_id}.css`);
        });
} else {
    mix.js(`${__dirname}/js/app.js`, `public/themes/${theme}/js`).version()
        .js(`${__dirname}/js/aiz-core.js`, `public/themes/${theme}/js`).version()
        .js(`${__dirname}/js/vue.js`, `public/themes/${theme}/js`)/*.vue({ version: 2 })*/.version() // Uses Vue v2 // TODO: Fix vue-loader version issue before using .vue()
        .sass(`${__dirname}/scss/app.scss`, `public/themes/${theme}/css`, {
            sassOptions: {
                processCssUrls: false
            },
            additionalData: fs.readFileSync(`${__dirname}/scss/themes/_default.scss`).toString() // Get default theme variables!
        }).version()
        .copy(`${__dirname}/js/crud/*.js`, `public/themes/${theme}/js/crud`)
        .copyDirectory(`${__dirname}/images`, `public/themes/${theme}/images`)
        .copyDirectory(`${__dirname}/vendor`, `public/themes/${theme}/vendor`)
        .copyDirectory(`${__dirname}/svg`, `public/themes/${theme}/svg`)
        // TODO: Note that when .then() function is added, everything is compiled already, so no further compilings are possible!
        .then(async () => {
            //optimizeCSS(`public/themes/${theme}/css/app.css`);

            // IMPORTANT NOTE: It's not possible to run file compiling for the same file used as earlier entry point
            // This means that we cannot run .sass(`${__dirname}/scss/app.scss`) again, so we have to run mix cli processes with tenant_id option for each tenant which uses current theme!
            // Compile all tenants (who use this theme) scss
            if(process.env.DB_CONNECTION === 'mysql') {
                let db = await mysql.createConnection({
                    host: '127.0.0.1', // TODO: Don't forget to fix this once we move DBs to different servers!
                    port: process.env.DB_MYSQL_PORT,
                    user: process.env.DB_MYSQL_USERNAME,
                    password: process.env.DB_PASSWORD,
                    database: process.env.DB_DATABASE,
                });
                const [rows, fields] = await db.execute(`SELECT t.* FROM tenants AS t INNER JOIN domains AS d ON t.id=d.tenant_id WHERE d.theme = ?`, [theme]);

                let compiled_tenants_ids = [];
                for (const index in rows) {
                    let row = rows[index];

                    if(compiled_tenants_ids.indexOf(row.id) === -1) {
                        compiled_tenants_ids.push(row.id);

                        createTenantCustomStylingVarsFile(row.id, theme);

                        // Compile tenant-theme scss

                        // 1. First approach is not possible due to `Same entry point defined twice` error! Check: https://github.com/laravel-mix/laravel-mix/issues/1936
                        /*mix.sass(`${__dirname}/scss/app.scss`, `public/themes/${theme}/css/${row.id}.css`, {
                            sassOptions: {
                                processCssUrls: false
                            },
                            additionalData: fs.readFileSync(`resources/scss/tenants/${row.id}/_variables-${theme}.scss`).toString()
                        }).version()*/

                        // 2. Second approach is to run npx mix cli for each tenant separately in separate process
                        const process = spawn(`npx mix watch --mix-config="themes/${theme}/webpack.mix.js" -- --env tenant_id=${row.id}`, {
                            stdio: 'inherit',
                            shell: true
                        });
                    }
                }

                await db.end();
            } else if(process.env.DB_CONNECTION === 'pgsql') {
                // TODO: Same logic as above but just for PostgresSQL
            }
        });


}


function createTenantCustomStylingVarsFile(tenant_id, theme) {
    // Check if tenant custom vars folder doesn't exist and create it if not
    if(!fs.existsSync(`resources/scss/tenants/${tenant_id}`)) {
        fs.mkdirSync(`resources/scss/tenants/${tenant_id}`, {
            mode: 0o755
        });
    }

    // Create custom vars for tenant-theme combination (by copying theme default vars!) - mode: rw-rw-r-- (664)
    if(!fs.existsSync(`resources/scss/tenants/${tenant_id}/_variables-${theme}.scss`)) {
        fs.writeFileSync(`resources/scss/tenants/${tenant_id}/_variables-${theme}.scss`, fs.readFileSync(`${__dirname}/scss/themes/_default.scss`).toString(), {
            mode: 0o664
        });
    }
}

// TODO: Fix `Invalid character(s)` error when optimizing compiled css files -_-. No idea why it doesn't work tbh...
function optimizeCSS(file) {
    return new CleanCSS(/*{
        level: {
            2: {
                all: true, // sets all optimization options for level 2 to `true`
            }
        }
    }*/)
    .minify(file, function (error, output) {
        console.log(output);
        /*fs.writeFileSync(file, output.styles, {
            mode: 0o664
        });*/
    })
    /*.then(function(output) {

    })
    .catch(function(error) {
        console.error(error);
    });*/
}
