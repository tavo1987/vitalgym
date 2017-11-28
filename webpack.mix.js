let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');

mix.copy('node_modules/toastr/build/toastr.min.js', 'public/plugins/toastr/toastr.js');
mix
    .js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .less('resources/assets/less/admin-lte/AdminLTE.less', 'public/css')
    .options({
        processCssUrls:false,
        postCss: [tailwindcss('./tailwind.js')],
    })
    .browserSync({
        proxy: 'http://vitalgym.dev',
        injectChanges: true,
        notify: false,
        open: false
    });
