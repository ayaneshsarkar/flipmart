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

mix.js('resources/js/app.js', 'public/js');
mix.js('resources/js/main.js', 'public/js/main.js');
mix.js('resources/js/map-custom.js', 'public/js/map-custom.js');
mix.js('resources/js/slick-custom.js', 'public/js/slick-custom.js');
mix.js('resources/js/modal.js', 'public/js/modal.js');
mix.js('resources/js/admin.js', 'public/js/admin.js');
mix.sass('resources/sass/app.scss', 'public/css');
mix.sass('resources/sass/admin.scss', 'public/css/admin.css');
mix.styles('resources/css/main.css', 'public/css/main.css');
mix.styles('resources/css/util.css', 'public/css/util.css');
