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
    input + 'js/vendor/markdown.converter.js',
    input + 'js/vendor/moment.min.js',
    input + 'js/vendor/underscore.min.js',
    input + 'js/vendor/underscore.string.min.js',
    input + 'js/vendor/angular.js',
    input + 'js/vendor/angular-resource.js',
    input + 'js/vendor/angular-route.js',
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

gulp.task('publish' , function() {
    gulp.src('.')
        .pipe(exec('php ../../../artisan asset:publish --bench="tectonic/shift"'))
        .pipe(notify('Bundle assets published.'));
});

// Helper task for watching the scripts directories, and only the script directories
gulp.task('scripts-watch' , function() {
	gulp.run('scripts');

	gulp.watch(input + 'js/src/**' , function() {
		gulp.run('scripts');
	});
});

// When running gulp without any tasks, it'll watch the scripts, styles, and do artisan publishing.etc.
gulp.task('default' , function() {
	gulp.run('scripts' , 'publish', 'scripts-watch');

	// Watch the JS directory.
	gulp.watch(input + 'js/src/**' , function() {
		gulp.run('scripts');
	});

	// When any changes happen to the 'public' directory, publish the changes.
	gulp.watch(output + '**/*' , function() {
		gulp.run('publish');
	});
});


