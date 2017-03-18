const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.sass('teleportoo.scss')
    .browserify('app.js')
    .scripts([
        'converio-theme/header.js',
        'converio-theme/html5.js',
        'converio-theme/ie.js',
        'converio-theme/jquery.hoverIntent.js',
        'converio-theme/jquery.slides.min.js',
        'converio-theme/modernizr.js',
        'converio-theme/respond.min.js',
        'converio-theme/scripts.js',
        'jquery.periodpicker.full.min.js',
        'jquery.datetimepicker.full.min.js',
        'bootstrap-dialog.min.js',
        'calculations.js',
        'jquery.geocomplete.min.js',
        'dropzones.js',
        'reviewstars.js',
        'main.js'
    ])
    .scripts([
        'converio-theme/header.js',
        'converio-theme/html5.js',
        'converio-theme/ie.js',
        'converio-theme/jquery.hoverIntent.js',
        'converio-theme/jquery.slides.min.js',
        'converio-theme/modernizr.js',
        'converio-theme/respond.min.js',

        'bootstrap-dialog.min.js',
        'bootstrap-select.js',
        'datatables.js',
    ], 'public/js/admin.js')
    .scripts([
        'dropzones.js',
        'reviewstars.js',
        'jquery.datetimepicker.full.min.js',
        'modal.js'
    ], 'public/js/modal.js')
    .styles([
        'jquery.datetimepicker.min.css',
        'jquery.periodpicker.min.css',
        'bootstrap-dialog.min.css',
        'bootstrap2-toggle.min.css'
    ]).styles([
        'bootstrap-select.css'
    ], 'public/css/admin.css')
    .copy(
        "node_modules/bootstrap-toggle/css/bootstrap2-toggle.min.css",
        'resources/assets/css/')
    .styles([
        'mapsvg.css',
    ], 'public/css/maps.css')
    .scripts([
        'mapsvg.js',
        'countrySelect.min.js',
        'maps.js'
    ], 'public/js/map.js');
});
