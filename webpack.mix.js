const mix    = require('laravel-mix');
const dotenv = require('dotenv');

// Load environment variables from .env file
dotenv.config();

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/scss/app.scss', 'public/css', [
        //
    ])
    .sourceMaps();

mix.browserSync(`${process.env.APP_HOST}:${process.env.APP_PORT}`);