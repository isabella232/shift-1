// Load all the required plugins.
var gulp   = require('gulp'),
    notify = require('gulp-notify'),
    exec   = require('gulp-exec'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    jshint = require('gulp-jshint'),
    rename = require('gulp-rename'),
	sass   = require('gulp-ruby-sass');

var input  = 'assets/',
    output = 'public/';

var scripts = [
    input + 'js/vendor/markdown.converter.js',
    input + 'js/vendor/moment.min.js',
    input + 'js/vendor/underscore.min.js',
    input + 'js/vendor/underscore.string.min.js',
    input + 'js/vendor/jquery.js',
    input + 'js/vendor/angular.js',
    input + 'js/vendor/restangular.js',
    input + 'js/vendor/angular-resource.js',
    input + 'js/vendor/angular-route.js',
    input + 'js/vendor/angular-cookies.js',
    input + 'js/src/**/*.js',
    input + 'js/Shift.js'
];

var styles = [
	input + 'sass/shift.scss'
];

gulp.task('styles', function() {
	return gulp.src(styles)
		.pipe(sass({quiet: true}))
		.pipe(rename('shift.dev.css'))
		.pipe(gulp.dest(output + '/css'))
		.pipe(sass({style: 'compressed', quiet: true}))
		.pipe(rename('shift.min.css'))
		.pipe(gulp.dest(output + '/css'));
		//.pipe(notify({ message: 'SCSS files compiled.' }));
});

gulp.task('scripts', function() {
    return gulp.src(scripts)
        .pipe(concat('shift.dev.js'))
        .pipe(gulp.dest(output + 'js'))
        .pipe(rename('shift.min.js'))
        .pipe(uglify({mangle: true}))
        .pipe(gulp.dest(output + 'js'));
        //.pipe(notify({ message: 'Javascript files compiled.' }));
});

gulp.task('publish' , function() {
    return gulp.src('.')
        .pipe(exec('php ../../../artisan asset:publish --bench=tectonic/shift'));
        //.pipe(notify('Bundle assets published.'));
});

// Helper task for watching the scripts directories, and only the script directories
gulp.task('scripts-watch' , function() {
	return gulp.watch(input + 'js/**', ['scripts']);
});

gulp.task('styles-watch' , function() {
	return gulp.watch(input + 'sass/**', ['styles']);
});

gulp.task('public-watch', function() {
    return gulp.watch(output + '**' , ['publish']);
});

// When running gulp without any tasks, it'll watch the scripts, styles, and do artisan publishing.etc.
gulp.task('default' , ['scripts' , 'styles', 'publish', 'scripts-watch', 'styles-watch', 'public-watch']);


