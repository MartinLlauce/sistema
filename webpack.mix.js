let mix = require("laravel-mix");

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

mix.styles(
    [
        "resources/assets/plantilla/css/bootstrap.css",
        "resources/assets/plantilla/css/bootstrap-extended.css",
        "resources/assets/plantilla/css/colors.css",
        "resources/assets/plantilla/css/components.css",
        "resources/assets/plantilla/css/palette-gradient.css",
        "resources/assets/plantilla/css/styleNew.css",
        "resources/assets/plantilla/css/vendors.min.css",
        "resources/assets/plantilla/css/vertical-menu.css",
        "resources/assets/plantilla/css/toastr.css"
    ],
    "public/css/plantilla.css"
)
mix.styles(
    [
        "resources/assets/campo/css/app.css",
        "resources/assets/campo/css/bootstrap.min.css",
        "resources/assets/campo/css/font-awesome.min.css",
        "resources/assets/campo/css/owl.carousel.css",
        "resources/assets/campo/css/style.css",
    ],
    "public/css/campus.css"
)
    .scripts(
        [
            "resources/assets/plantilla/js/vendors.min.js",
            "resources/assets/plantilla/js/applicacion.js",
            "resources/assets/plantilla/js/app-menu.js",
            "resources/assets/plantilla/js/components.js",
            "resources/assets/plantilla/js/toastr.js",
            "resources/assets/plantilla/js/sweetalert2.all.min.js"
        ],
        "public/js/plantilla.js"
    )
    .scripts(
        [
            "resources/assets/campo/js/app.js",
            "resources/assets/campo/js/bootstrap.min.js",
            "resources/assets/campo/js/circle-progress.min.js",
            "resources/assets/campo/js/jquery-3.2.1.min.js",
            "resources/assets/campo/js/main.js",
            "resources/assets/campo/js/map.js",
            "resources/assets/campo/js/mixitup.min.js",
            "resources/assets/campo/js/owl.carousel.min.js"
        ],
        "public/js/campus.js"
    )
    .js(["resources/assets/js/app.js"], "public/js/app.js");
