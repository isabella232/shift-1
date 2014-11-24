// Load all the required plugins.
var gulp   = require('gulp'),
    notify = require('gulp-notify'),
    exec   = require('gulp-exec'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
	assets = require('./gulp.custom'),
    jshint = require('gulp-jshint'),
    rename = require('gulp-rename'),
    rsync  = require('gulp-rsync'),
	sass   = require('gulp-ruby-sass'),
	watch  = require('gulp-watch');

var input  = 'assets/',
    output = 'public/';

var scripts = [
  input + '_app.js',
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
        .pipe(concat('shift.dev.js'))
        .pipe(gulp.dest(output + 'js'))
        .pipe(rename('shift.min.js'))
        .pipe(uglify({mangle: true}))
        .pipe(gulp.dest(output + 'js'))
        .pipe(notify({ message: 'Javascript files compiled.' }));
});

gulp.task('publish' , function() {
    gulp.src('.')
        .pipe(exec('php ../../../artisan asset:publish tectonic/shift'))
        .pipe(notify('Bundle assets published.'));
});

// Helper task for watching the scripts directories, and only the script directories
gulp.task('scripts-watch', function() {
	gulp.run('scripts');

	gulp.watch(input + 'js/**', function() {
		gulp.run('scripts');
	});
});

gulp.task('styles-watch', function() {
	gulp.run('styles');

	gulp.watch(input + 'sass/**', function() {
		gulp.run('styles');
	});
});

gulp.task('shift-sync', function() {
	gulp.run('sync', 'pub');

	gulp.watch(['src/**/*.php', 'boot/*.php', 'views/**/*.php'], function() {
		gulp.run('sync', 'pub');

	});
});

// Kirk's rsync task
gulp.task('sync', function() {
	gulp.src('.')
		.pipe(rsync({
			root: '.',
			destination: '/Users/kirkbushell/Documents/Development/Homestead/Shift/vendor/tectonic/shift',
			exclude: 'vendor/*'
		}))
		.pipe(notify('PHP files synced locally.'));
});

// Kirk's publish task
gulp.task('pub', function() {
	gulp.src('.')
		.pipe(exec('php /Users/kirkbushell/Documents/Development/Homestead/Shift/artisan asset:publish tectonic/shift'))
		.pipe(notify('Bundle assets published.'));
})

// When running gulp without any tasks, it'll watch the scripts, styles, and do artisan publishing.etc.
gulp.task('default' , function() {
	gulp.start('scripts-watch', 'styles-watch', 'publish');

	// Watch the sass directory.
	gulp.watch(input + 'sass/**' , function() {
		gulp.run('styles');
	});

	// When any changes happen to the 'public' directory, publish the changes.
	gulp.watch(output + '**/*' , function() {
		gulp.run('publish');
	});

	custom();
});


