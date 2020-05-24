const mix = require('laravel-mix');
require('laravel-mix-purgecss');

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

mix.react('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/modules/main.scss', 'public/css/modules')
  .sass('resources/sass/modules/product.scss', 'public/css/modules')
  .sass('resources/sass/modules/cart.scss', 'public/css/modules')
  .sass('resources/sass/modules/order.scss', 'public/css/modules')
  .sass('resources/sass/modules/user.scss', 'public/css/modules')
  .purgeCss()
  .browserSync('boutique.local');

