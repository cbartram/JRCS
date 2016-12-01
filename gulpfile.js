const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {

    //compile Sass run phpUnit
    mix.sass('app.scss')
       .webpack('app.js')
       .phpUnit();

    //compile and minify css for Profile
    mix.styles([
       "bootstrap.min.css",
       "toastr.min.css",
       "fullcalendar.css",
       "fullcalendar.print.css",
       "jquery-ui.min.css",
       "Profile.css"
    ], 'public/css/Profile.css');

    //Bootstrap and Toastr
    mix.styles([
        "bootstrap.min.css",
        "toastr.min.css",
        "jquery-ui.min.css"
    ], 'public/css/Toastr_Bootstrap.css');

    //compile and minify css for CICO
    mix.styles([,
        "bootstrap.min.css",
        "toastr.min.css",
        "jquery-ui.min.css",
        "CICO.css"
    ], 'public/css/CICO.css');

    //compile and minify css for Login
    mix.styles([,
        "bootstrap.min.css",
        "toastr.min.css",
        "jquery-ui.min.css",
        "Login.css"
    ], 'public/css/Login.css');

      // .scripts(['forum.js', 'threads.js'], 'public/js/forum.js');
});
