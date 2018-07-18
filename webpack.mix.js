let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');

mix
    .js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .less('resources/assets/less/admin-lte/AdminLTE.less', 'public/css')
    .options({
        processCssUrls:false,
        postCss: [tailwindcss('./tailwind.js')],
    });

if(!mix.inProduction()) {
    mix.browserSync({
        proxy: 'vitalgym.test',
        open: false,
        notify: false,
    }).webpackConfig({
        devtool: 'source-map'
    }).sourceMaps();
}

if (mix.inProduction()) {
    mix.version();
}

mix.disableNotifications();
