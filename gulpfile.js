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

    /**
     * Minify & Compile all CSS Files & Libraries required for the application
     */

    //run phpUnit
    mix.phpUnit();

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

    //compile and minify CSS for archive
    mix.styles([
        "Archive.css"
    ], 'public/css/Login.css');

    /**
    * Minify & Compile all JS Files & Libraries required for the application
    */

    //Minified & Compiled JS for CICO page
    mix.scripts([
        "jquery.min.js",
        "jquery-ui.min.js",
        "bootstrap.min.js",
        "fontawesome.min.js",
        "toastr.min.js",
        "VolunteerRESTLibrary.js",
        "CICO.js"
    ], 'public/js/CICO.js');

    //Minified & Compiled JS for Checkout page
    mix.scripts([
        "jquery.min.js",
        "jquery-ui.min.js",
        "bootstrap.min.js",
        "fontawesome.min.js",
        "toastr.min.js",
        "moment.js",
        "jquery.tabledit.min.js",
        "VolunteerRESTLibrary.js",
        "CICO.js"
    ], 'public/js/Checkout.js');

    //Minified & Compiled JS for Navbar & Profile page
    mix.scripts([
        "jquery.min.js",
        "jquery-ui.min.js",
        "bootstrap.min.js",
        "touchpunch.min.js",
        "fontawesome.min.js",
        "toastr.min.js",
        "moment.js",
        "spin.min.js",
        "Highcharts.js",
        "fullcalendar.min.js",
        "jquery.tabledit.min.js",
        "VolunteerRESTLibrary.js",
        "Chart.js",
        "Profile.js"
    ], 'public/js/Profile.js');


    //Minified & Compiled JS for Archive page
    mix.scripts([
        "jquery.min.js",
        "jquery-ui.min.js",
        "bootstrap.min.js",
        "fontawesome.min.js",
        "toastr.min.js",
        "VolunteerRESTLibrary.js",
        "Archive.js"
    ], 'public/js/Archive.js');

    //Minified & Compiled JS for Donation page
    mix.scripts([
        "jquery.min.js",
        "jquery-ui.min.js",
        "bootstrap.min.js",
        "fontawesome.min.js",
        "toastr.min.js",
        "VolunteerRESTLibrary.js",
        "Archive.js"
    ], 'public/js/Archive.js');

    //Minified & Compiled JS for Login page
    mix.scripts([
        "jquery.min.js",
        "jquery-ui.min.js",
        "bootstrap.min.js",
        "fontawesome.min.js",
        "VolunteerRESTLibrary.js"
    ], 'public/js/Login.js');


    //Minified & Compiled JS for Password Reset pages
    mix.scripts([
        "jquery.min.js",
        "jquery-ui.min.js",
        "bootstrap.min.js"
    ], 'public/js/Jquery_Bootstrap.js');


    //Minified & Compiled JS for Volunteer Search page
    mix.scripts([
        "jquery.min.js",
        "bootstrap.min.js",
        "toastr.min.js",
        "fontawesome.min.js",
        "jquery.tabledit.min.js",
        "VolunteerRESTLibrary.js",
        "Search.js"
    ], 'public/js/Search.js');

});
