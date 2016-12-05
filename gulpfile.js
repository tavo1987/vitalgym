const elixir = require('laravel-elixir');

elixir(function(mix) {

    mix.copy('node_modules/toastr/build/toastr.min.js', 'public/plugins/toastr/toastr.js');

    mix.sass(['*.scss','app.scss'])
        .webpack([
            'app.js',
            'plugins/toastr.js'
            ],
            'admin-lte.js', 'public/js/app.js');

    mix.browserSync({
        proxy: 'http://vitalgym.dev',
        injectChanges: true,
        notify: false,
    });

    mix.less('admin-lte/AdminLTE.less');
});

