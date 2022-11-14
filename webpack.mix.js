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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps();

// mix.scripts([
//     "resources/assets/plugins/jquery/jquery.min.js",
//     "resources/assets/plugins/bootstrap/js/bootstrap.bundle.min.js",
// ], 'public/assets/js/admin_app.min.js')
// .styles([
//     "resources/assets/css/adminlte.min.css",
// ], "public/assets/css/admin_app.min.css")
