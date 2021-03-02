const mix = require('laravel-mix');
let productionSourceMaps = false;
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

mix.options({processCssUrls: false})

// mix.extract([
//   'jquery', 'vue', 'axios', // Common dependencies (all)
// ], 'public/js/vendor.js');
//
// mix.extract([
//   'popper.js', 'sweetalert2', 'mdb-ui-kit', 'vuex', // Common dependencies (user)
// ], 'public/js/user.js');
//
// mix.extract([
//   'halfmoon', // Common dependencies (admin)
// ], 'public/js/admin.js');
//
// mix.autoload({
//   jquery: ['$', 'window.jQuery', 'jQuery', 'jquery'],
//   vue: ['window.Vue', 'Vue']
// })


mix.js('resources/js/user/app.js', 'public/js')
  .sass('resources/sass/user/app.scss', 'public/css')


mix.js('resources/js/admin/app.js', 'public/js/admin')
  .sass('resources/sass/admin/app.scss', 'public/css/admin')
  .sourceMaps(productionSourceMaps, 'source-map')

if (mix.inProduction()) {
  mix.version();
}

mix.browserSync('http://myshop/');
mix.disableNotifications();
