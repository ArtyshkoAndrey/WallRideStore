const mix = require('laravel-mix');
let productionSourceMaps = false;

mix.options({processCssUrls: false})

mix.js('resources/js/user/app.js', 'public/js').vue({ version: 2 })
  .sass('resources/sass/user/app.scss', 'public/css');


mix.js('resources/js/admin/app.js', 'public/js/admin').vue({ version: 2 })
  .sass('resources/sass/admin/app.scss', 'public/css/admin')
  .sourceMaps(productionSourceMaps, 'source-map');

if (mix.inProduction()) {
  mix.version();
}

mix.browserSync('https://wallride');
mix.disableNotifications();
