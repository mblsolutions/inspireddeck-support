const mix = require('laravel-mix');

mix.js('resources/js/inspireddeck.js', 'public/js')
   .sass('resources/sass/inspireddeck.scss', 'public/css')
   .sass('resources/sass/inspireddeck-login.scss', 'public/css')
   .sass('resources/sass/inspireddeck-error.scss', 'public/css');
