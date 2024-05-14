const fs = require('node:fs');
const path = require('node:path');

const mix = require('laravel-mix');
const DependencyExtraction = require('@wordpress/dependency-extraction-webpack-plugin');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

const getDirFiles = function (dir) {
    // get all 'files' in this directory
    // filter directories
    return fs.readdirSync(dir).filter(file => {
        return fs.statSync(`${dir}/${file}`).isFile();
    });
};

const root_dir = './';
const assets_dir = root_dir + '/assets';
const dist_dir = root_dir + '/dist';

mix.sass(assets_dir + '/scss/app.scss','./css/app.css');

// Compile all JS functionalitis into individual files
const functionalitiesPath = assets_dir + '/javascript/functionalities/';
getDirFiles(functionalitiesPath).forEach((filepath) => {
    mix.js(functionalitiesPath + filepath , './js/functionalities');
})

mix.sourceMaps(true, 'eval-source-map', 'source-map');

mix.webpackConfig({
    output: {
        chunkFilename: dist_dir + '/[name].js',
        path: path.resolve( __dirname, './dist/' ),
        publicPath: dist_dir,
        filename: '[name].js',
    },

    plugins: [
        new DependencyExtraction({
            combineAssets: true,
            injectPolyfill: false,
        }),
    ],
});
