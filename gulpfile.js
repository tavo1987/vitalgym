const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

    mix.copy('node_modules/toastr/build/toastr.min.css', 'resources/assets/sass/toastr.scss')
        .copy('node_modules/toastr/build/toastr.min.js', 'public/js/toastr.min.js');

    mix.less('admin-lte/AdminLTE.less');
    mix.less('bootstrap/bootstrap.less');

    mix.sass('app.scss')
        .webpack('app.js');

    mix.browserSync({
        proxy: 'http://vitalgym.dev',
        injectChanges: true,
        notify: true,
    })
});

