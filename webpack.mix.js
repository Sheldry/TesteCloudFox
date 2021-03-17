const mix = require('laravel-mix');

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

mix
    .js('resources/js/app.js', 'public/assets/js')

    .js('resources/views/assets/js/scripts.js', 'public/assets/js/scripts.js')

    .sass('resources/sass/app.scss', 'public/assets/css')
    
    .copyDirectory('resources/views/assets/img', 'public/assets/img');
