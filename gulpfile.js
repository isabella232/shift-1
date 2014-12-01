// Load all the required plugins.
var gulp   = require('gulp'),
	custom = require('./gulp.custom'),
    exec   = require('gulp-exec'),
    concat = require('gulp-concat'),
    jshint = require('gulp-jshint'),
    notify = require('gulp-notify'),
    rename = require('gulp-rename'),
	sass   = require('gulp-ruby-sass'),
    uglify = require('gulp-uglify'),
	watch  = require('gulp-watch');

var input  = 'assets/',
    output = 'public/';

var scripts = [
  input + 'js/_app.js',
  input + 'js/vendor/**/*.js',
  input + 'js/src/**/*.js',
  input + 'js/shift.js'
];

var styles = [
	input + 'sass/shift.scss'
];

gulp.task('styles', function() {
	return gulp.src(styles)
		.pipe(sass())
		.pipe(rename('shift.dev.css'))
		.pipe(gulp.dest(output + '/css'))
		.pipe(sass({style: 'compressed'}))
		.pipe(rename('shift.min.css'))
		.pipe(gulp.dest(output + '/css'))
		.pipe(notify({ message: 'SCSS files compiled.' }));
});

gulp.task('scripts', function() {
    return gulp.src(scripts)
	    .pipe(jshint())
	    .pipe(jshint.reporter('default'))
        .pipe(concat('shift.dev.js'))
        .pipe(gulp.dest(output + 'js'))
        .pipe(rename('shift.min.js'))
        .pipe(uglify({mangle: true}))
        .pipe(gulp.dest(output + 'js'))
        .pipe(notify({ message: 'Javascript files compiled.' }));
});

// Helper task for watching the scripts directories, and only the script directories
gulp.task('scripts-watch', function() {
	gulp.run('scripts');

	gulp.watch(input + 'js/**/', function() {
		gulp.run('scripts');
	});
});

gulp.task('styles-watch', function() {
	gulp.run('styles');

	gulp.watch(input + 'sass/**', function() {
		gulp.run('styles');
	});
});

// When running gulp without any tasks, it'll watch the scripts, styles, and do artisan publishing.etc.
gulp.task('default' , function() {
	gulp.start('scripts-watch', 'styles-watch');

	// Run any custom gulp code
	custom.start();
});

// Registers the tasks you'd like to run
custom.tasks();
