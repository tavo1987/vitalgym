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

    mix.copy('node_modules/toastr/build/toastr.css', 'resources/assets/sass/plugins/_toastr.scss')
        .copy('node_modules/toastr/build/toastr.min.js', 'resources/assets/js/plugins/toastr.js');


    mix.sass(['*.scss','app.scss'])
        .webpack([
            'app.js',
            'plugins/toastr.js',
            'admin-lte.js',
        ], 'public/js/app.js');

    mix.browserSync({
        proxy: 'http://vitalgym.dev',
        injectChanges: true,
        notify: false,
    })

    mix.less('admin-lte/AdminLTE.less');

});

