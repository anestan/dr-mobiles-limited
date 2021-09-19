let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix.webpackConfig({
  devtool: 'source-map',
});

// mix.webpackConfig(webpack => {
//   return {
//     plugins: [
//       new webpack.DefinePlugin({
//         __VUE_OPTIONS_API__: true,
//         __VUE_PROD_DEVTOOLS__: true,
//       }),
//     ],
//   };
// });

mix.options({
  processCssUrls: false,
  postCss: [
    require('tailwindcss'),
    require('autoprefixer'),
  ],
});

// mix.browserSync({
//   proxy: 'dr-mobiles-limited.test',
//   files: [
//     'assets/js/*.{js,vue}',
//     'assets/js/**/*.{js,vue}',
//     'assets/sass/*.scss',
//     'assets/sass/**/*.scss',
//     '*.php',
//     '**/*.php',
//   ],
// });

mix.setPublicPath('dist');

mix.js('assets/js/theme.js', 'dist/js/theme.min.js');
mix.sass('assets/sass/style.scss', 'dist/css/theme.css').sourceMaps();
mix.sass('assets/sass/woocommerce.scss', 'dist/css/woocommerce.css').sourceMaps();

mix.sass('assets/sass/app.scss', 'dist/css/app.css').sourceMaps();
mix.js('assets/js/app.js', 'dist/js/app.js');

mix.sass('assets/sass/editor.scss', 'dist/css/editor.css').sourceMaps();
mix.js('assets/js/alpine.js', 'dist/js/alpine.js');

mix.js('assets/js/covid.js', 'dist/js/covid.js');
mix.sass('assets/sass/covid.scss', 'dist/css/covid.css').sourceMaps();

mix.js('assets/js/contact-us.js', 'dist/js/contact-us.js').vue({
  __VUE_OPTIONS_API__: true,
  __VUE_PROD_DEVTOOLS__: true
});
