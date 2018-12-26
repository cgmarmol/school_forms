let mix = require('laravel-mix');

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

// mix.js('resources/assets/js/app.js', 'public/js')
   // .sass('resources/assets/sass/app.scss', 'public/css');

mix.styles([
  'vendor/almasaeed2010/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css',
  'vendor/almasaeed2010/adminlte/bower_components/font-awesome/css/font-awesome.min.css',
  'vendor/almasaeed2010/adminlte/dist/css/AdminLTE.min.css',
  'vendor/almasaeed2010/adminlte/dist/css/skins/_all-skins.min.css',
], 'public/css/app.css');

mix.scripts([
  'vendor/almasaeed2010/adminlte/bower_components/jquery/dist/jquery.min.js',
  'vendor/almasaeed2010/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js',
  'vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js',
], 'public/js/app.js');

mix.copyDirectory('vendor/almasaeed2010/adminlte/bower_components/bootstrap/fonts', 'public/fonts');
mix.copyDirectory('vendor/almasaeed2010/adminlte/bower_components/font-awesome/fonts', 'public/fonts');
