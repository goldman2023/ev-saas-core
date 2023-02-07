const path = require('path');
const mix = require("laravel-mix");
let weMix = require('../../we-webpack-mix');

weMix.compileTheme(mix, __dirname, path.basename(__dirname));