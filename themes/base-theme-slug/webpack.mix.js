const mix = require('laravel-mix');
const fs = require('fs');
const path = require( 'path' );
const defaultConfig = require( './node_modules/@wordpress/scripts/config/webpack.config' );

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

mix.webpackConfig({
	...defaultConfig,
	entry: {
    },

    output: {
        chunkFilename: dist_dir + '/[name].js',
        path: path.resolve( __dirname, './dist/' ),
        publicPath: dist_dir,
        filename: '[name].js',
    },

    module: {

    },

	devtool: "inline-source-map"
});
