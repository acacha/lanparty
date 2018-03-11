let mix = require('laravel-mix');

let SWPrecacheWebpackPlugin = require('sw-precache-webpack-plugin');

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

mix.js('resources/assets/js/app.js', 'public/js').sourceMaps()
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.copy('resources/assets/js/push_message.js', 'public/js/push_message.js');


// PWA service Workers
mix.webpackConfig({
  plugins: [
    new SWPrecacheWebpackPlugin(
      {
        cacheId: 'lanparty',
        filename: 'service-worker.js',
        maximumFileSizeToCacheInBytes: 8097152,
        staticFileGlobs: ['public/**/*.{css,eot,svg,ttf,woff,woff2,js,html,ico,jpg,jpeg,png}'],
        minify: false,
        stripPrefix: 'public/',
        handleFetch: true,
        dynamicUrlToDependencies: {
          '/': ['resources/views/welcome.blade.php'],
          '/home': ['resources/views/home.blade.php']
        },
        staticFileGlobsIgnorePatterns: [/\.map$/, /mix-manifest\.json$/, /manifest\.json$/, /service-worker\.js$/],
        // staticFileGlobsIgnorePatterns: [/\.map$/, /mix-manifest\.json$/, /manifest\.json$/],
        // runtimeCaching: [
        //   {
        //     urlPattern: /^https:\/\/fonts\.googleapis\.com\//,
        //     handler: 'cacheFirst'
        //   }
        // ],
        importScripts: ['./js/push_message.js']
      }
    ),
  ]
});