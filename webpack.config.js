const path = require('path');
const webpack = require('webpack');

//uglify js files
const UglifyJSPlugin = require('uglifyjs-webpack-plugin');

const ExtractTextPlugin = require('extract-text-webpack-plugin');

//clean /build dir
const CleanWebpackPlugin = require('clean-webpack-plugin');

//create json manifest
const ManifestPlugin = require('webpack-manifest-plugin');

//minify css files
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const cssnano = require('cssnano'); //minify css processor

//manipulate sass/scss files
const ExtractSASS = new ExtractTextPlugin('css/[name].min.css', {allChunks: true}); 

const commonConfig = {
  context: path.resolve(__dirname, 'src'),
  entry: {
    vendor: ["bootstrap"],
    front: './front.js',
    homepage: './front/js/homepage',
    project: './front/js/project',
    back: './back.js',
    dashboard: './back/js/dashboard.js',
    parameters:  './back/js/parameters.js',
    users:  './back/js/users.js',
    categories:  './back/js/categories.js',
    projects:  './back/js/projects.js',
    pictures:  './back/js/pictures.js',
    images : './images',
  },
  output: {
    path: path.resolve(__dirname, 'public/build'),
    filename: 'js/[name].min.js',
  },
  module: {
    rules: [
      { //ESLint rule
        test: /\.js$/,
        exclude: /node_modules/,
        enforce: 'pre',
        loader: 'eslint-loader',
        options: {
          emitWarning: true,
          fix: true,
        },
      },
      { //CSS rule
        test: /\.css$/,
        use: ['style-loader', 'css-loader'],
      },
      { // SASS/SCSS rule
        test: /\.(sass|scss)$/,
        use: ExtractSASS.extract({
          fallback: 'style-loader',
          use: ['css-loader', 'sass-loader'],
        }),
      },
      { // Image & pdf rule
        test: /\.(svg|png|jpeg|jpg|gif|pdf)$/,
        loader: 'file-loader',
        options: {
          name: '[path]/[name].[ext]',
        },
      },
      { // Font rule
        test: /\.(woff|woff2|eot|otf|ttf)$/,
        loader: 'url-loader',
        options: {
          limit: 50000,
          name: './fonts/[name].[ext]',
          publicPath: '../',
        },
      },
    ],
  },
  plugins: [
    // Clean the folder at each run build
    new CleanWebpackPlugin(['public/build']),
    // Generate a manifest of the assets
    new ManifestPlugin(),
    // Manage Bootstrap dependency
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
      'window.jQuery': 'jquery',
      Popper: ['popper.js', 'default'],
    }),
    new webpack.DefinePlugin({
      BaseURL: '\'http://localhost:8080/ci-cms-portfolio/\'',
    }),
    // Clean and minify CSS files
    new OptimizeCssAssetsPlugin({
      cssProcessor: cssnano,
      cssProcessorOptions: { discardComments: {removeAll: true } },
      canPrint: false,
    }),
    new UglifyJSPlugin(),
    // Process SASS/SCSS to CSS
    ExtractSASS,
    new webpack.optimize.CommonsChunkPlugin({
      name: "vendor",
      minChunks: Infinity,
    })
  ],
};

module.exports = commonConfig;

