const mix = require('laravel-mix');

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

mix.
    styles(['resources/views/repositorio/plugins/fontawesome-free/css/all.min.css'],
    'public/public/plugins/fontawesome-free/css/all.min.css')

    .styles(['resources/views/repositorio/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'],
    'public/public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')

    .styles(['resources/views/repositorio/plugins/icheck-bootstrap/icheck-bootstrap.min.css'],
    'public/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')

    .styles(['resources/views/repositorio/plugins/jqvmap/jqvmap.min.css'],
    'public/public/plugins/jqvmap/jqvmap.min.css')

    .styles(['resources/views/repositorio/dist/css/adminlte.min.css'],
    'public/public/dist/css/adminlte.min.css')

    .styles(['resources/views/repositorio/plugins/overlayScrollbars/css/OverlayScrollbars.min.css'],
    'public/public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')

    .styles(['resources/views/repositorio/plugins/daterangepicker/daterangepicker.css'],
    'public/public/plugins/daterangepicker/daterangepicker.css')

    .styles(['resources/views/repositorio/plugins/summernote/summernote-bs4.min.css'],
    'public/public/plugins/summernote/summernote-bs4.min.css')

    //sdasds
    .styles(['resources/views/repositorio/plugins/chart.js/Chart.min.css'],
    'public/public/plugins/chart.js/Chart.min.css')

    .scripts(['resources/views/repositorio/plugins/jquery/jquery.min.js'],
    'public/public/plugins/jquery/jquery.min.js')

    .scripts(['resources/views/repositorio/plugins/jquery-ui/jquery-ui.min.js'],
    'public/public/plugins/jquery-ui/jquery-ui.min.js')

    .scripts(['resources/views/repositorio/plugins/bootstrap/js/bootstrap.bundle.min.js'],
    'public/public/plugins/bootstrap/js/bootstrap.bundle.min.js')

    .scripts(['resources/views/repositorio/plugins/chart.js/Chart.min.js'],
    'public/public/plugins/chart.js/Chart.min.js')

    .scripts(['resources/views/repositorio/plugins/sparklines/sparkline.js'],
    'public/public/plugins/sparklines/sparkline.js')

    .scripts(['resources/views/repositorio/plugins/jqvmap/jquery.vmap.min.js'],
    'public/public/plugins/jqvmap/jquery.vmap.min.js')
    .scripts(['resources/views/repositorio/plugins/jqvmap/maps/jquery.vmap.usa.js'],
    'public/public/plugins/jqvmap/maps/jquery.vmap.usa.js')

    .scripts(['resources/views/repositorio/plugins/jquery-knob/jquery.knob.min.js'],
    'public/public/plugins/jquery-knob/jquery.knob.min.js')

    .scripts(['resources/views/repositorio/plugins/moment/moment.min.js'],
    'public/public/plugins/moment/moment.min.js')

    .scripts(['resources/views/repositorio/plugins/daterangepicker/daterangepicker.js'],
    'public/public/plugins/daterangepicker/daterangepicker.js')

    .scripts(['resources/views/repositorio/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'],
    'public/public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')

    .scripts(['resources/views/repositorio/plugins/summernote/summernote-bs4.min.js'],
    'public/public/plugins/summernote/summernote-bs4.min.js')

    .scripts(['resources/views/repositorio/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'],
    'public/public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')

    .scripts(['resources/views/repositorio/dist/js/adminlte.js'],
    'public/public/dist/js/adminlte.js')

    .scripts(['resources/views/repositorio/dist/js/demo.js'],
    'public/public/dist/js/demo.js')

    .scripts(['resources/views/repositorio/dist/js/pages/dashboard.js'],
    'public/public/dist/js/pages/dashboard.js')

    .scripts(['resources/views/repositorio/mode/js/script_login/script_ajax.js'],
    'public/public/mode/js/script_login/script.js')

    .copyDirectory(['resources/views/repositorio/avatar_users/default.jpg'],
    'public/public/avatar_users/default.jpg')

    .scripts(['resources/views/repositorio/plugins/select2/js/select2.min.js'],
    'public/public/plugins/select2/select2.min.js')

    .scripts(['resources/views/repositorio/plugins/select2/script.js'],
    'public/public/plugins/select2/script.js')

    .scripts(['resources/views/repositorio/plugins/sweetalert2/sweetalert2.all.min.js'],
    'public/public/plugins/sweetalert2/sweetalert2.all.min.js')

    .version();
