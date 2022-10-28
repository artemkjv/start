const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
]).version();

mix.styles([
    "resources/css/table.css",
    "resources/css/filter-select.css",
], "public/css/table.css").version();

mix.scripts([
    "resources/js/jquery.js",
    "resources/js/filter-select.js",
], "public/js/excel.js").version();

if (mix.inProduction()) {
    mix.version();
}