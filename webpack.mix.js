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


mix.copy('node_modules/toastr/build/toastr.min.js', 'public/plugins/toastr/toastr.js');

mix.options({
        processCssUrls:false
    })
    .sass('resources/assets/sass/app.scss', 'public/css')
    .js('resources/assets/js/app.js', 'public/js')
    .browserSync({
        proxy: 'http://vitalgym.dev',
        injectChanges: true,
        notify: false,
        open: false
    })
    .less('resources/assets/less/admin-lte/AdminLTE.less', 'public/css');