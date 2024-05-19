const { resolve } = require('node:path');

const { sync: glob } = require('fast-glob');
const mix = require('laravel-mix');
const DependencyExtraction = require('@wordpress/dependency-extraction-webpack-plugin');

const root_dir = './';
const assets_dir = root_dir + '/assets';
const blocks_dir = root_dir + '/library/blocks';
const dist_dir = root_dir + '/dist';

mix.sass(assets_dir + '/scss/app.scss','./css/app.css');
mix.sass(assets_dir + '/scss/editor.scss','./css/editor.css');

// Compile all JS functionalities into separate files
glob(assets_dir + '/javascript/functionalities/*.js').forEach((path) => {
    mix.js(path, './js/functionalities');
});

// Compile all block assets into individual files
glob(blocks_dir + '/*/*.js', { ignore: ['**/shared/**'] }).forEach((path) => {
    const parts = path.split('/');
    mix.js(path, './blocks/' + parts[3]).react();
})
glob(blocks_dir + '/*/*.scss', { ignore: ['**/shared/**'] }).forEach((path) => {
    const parts = path.split('/');
    mix.sass(path, './blocks/' + parts[3]);
})

mix.sourceMaps(true, 'eval-source-map', 'source-map');

mix.webpackConfig({
    output: {
        chunkFilename: dist_dir + '/[name].js',
        path: resolve( __dirname, './dist/' ),
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
