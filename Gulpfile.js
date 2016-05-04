'use strict';

var gulp    = require('gulp');
var sass    = require('gulp-sass');
var concat  = require('gulp-concat');
var uglify  = require('gulp-uglify');

var dir = {
    assets: './app/Resources/',
    dist: './web/',
    bower: './bower_components/',
    bootstrapJS: './bower_components/bootstrap-sass/assets/javascripts/bootstrap/'
};

gulp.task('sass', function() {
    gulp.src(dir.assets + 'style/main.scss')
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
        .pipe(concat('style.css'))
        .pipe(gulp.dest(dir.dist + 'css'));
});

gulp.task('scripts', function() {
    gulp.src([
            // jQuery
            dir.bower + 'jquery/dist/jquery.min.js',
            dir.bower + 'jquery-ui/jquery-ui.min.js',
            // Counter-up plugin
            dir.bower + 'waypoints/waypoints.js',
            dir.bower + 'counter-up/jquery.counterup.js',

            // Bootstrap JS modules
            dir.bootstrapJS + 'transition.js',
            dir.bootstrapJS + 'collapse.js',
            dir.bootstrapJS + 'dropdown.js',
            dir.bootstrapJS + 'tooltip.js',
            dir.bootstrapJS + 'popover.js',
            //...

            // File Upload script
            './vendor/kartik-v/bootstrap-fileinput/js/fileinput.js',

            // Nice select
            dir.assets + 'scripts/jquery.sticky.js',
            dir.assets + 'scripts/jquery.nice-select.min.js',

            // Application custom scripts
            dir.assets + 'scripts/offers.js',
            dir.assets + 'scripts/file-upload-plugin-translation.js',
            dir.assets + 'scripts/age-popover.js',
            dir.assets + 'scripts/index-search.js',

            // Main JS file
            dir.assets + 'scripts/main.js'
        ])
        .pipe(concat('script.js'))
        .pipe(uglify())
        .pipe(gulp.dest(dir.dist + 'js'));

    // Offers scripts
    gulp.src([
            dir.assets + 'scripts/offers.js'
        ])
        .pipe(uglify())
        .pipe(gulp.dest(dir.dist + 'js'));
});

gulp.task('images', function() {
    gulp.src([
            dir.assets + 'images/**'
        ])
        .pipe(gulp.dest(dir.dist + 'images'));
});

gulp.task('fonts', function() {
    gulp.src([
        dir.bower + 'bootstrap-sass/assets/fonts/**',
        './node_modules/font-awesome/fonts/**'
        ])
        .pipe(gulp.dest(dir.dist + 'fonts'));
});

gulp.task('default', ['sass', 'scripts', 'fonts', 'images']);
