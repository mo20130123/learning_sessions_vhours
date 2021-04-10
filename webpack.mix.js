
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
// mix.sass("resources/sass/app_site.scss", "public/css").version();
// js("resources/js/app.js", "public/js");
// .sass('resources/sass/app_site_2.scss', 'public/css');
// mix
mix.js('resources/js/app.js', 'public/js').vue() ;
