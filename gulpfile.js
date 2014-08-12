// Load all the required plugins.
var gulp   = require('gulp'),
    notify = require('gulp-notify'),
    exec   = require('gulp-exec'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    jshint = require('gulp-jshint'),
    rename = require('gulp-rename');

var input  = 'assets/',
    output = 'public/';

var scripts = [
    '!' + input + 'js/src/Vendor/angular.js',
    input + 'js/src/**/*.js',
    input + 'js/shift.js'
];

gulp.task('scripts', function() {
    return gulp.src(scripts)
        .pipe(concat('shift-dev.js'))
        .pipe(gulp.dest(output + 'js'))
        .pipe(rename('shift.js'))
        .pipe(uglify())
        .pipe(gulp.dest(output + 'js'))
        .pipe(notify({ message: 'Javascript files compiled.' }));
});

gulp.task( 'publish' , function() {
    gulp.src('.')
        .pipe(exec('php ../../../artisan asset:publish --bench="tectonic/shift"'))
        .pipe(notify('Bundle assets published.'));
});

gulp.task( 'default' , [ 'scripts' , 'publish' ]);