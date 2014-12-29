// Load all the required plugins.
var gulp   = require('gulp'),
	fs     = require('fs'),
    exec   = require('gulp-exec'),
    concat = require('gulp-concat'),
    jshint = require('gulp-jshint'),
    notify = require('gulp-notify'),
    rename = require('gulp-rename'),
	sass   = require('gulp-ruby-sass'),
    uglify = require('gulp-uglify'),
	watch  = require('gulp-watch');

var custom = null;

if (fs.existsSync('./gulp.custom.js')) {
	custom = require('./gulp.custom');
}

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

gulp.task( 'theme-config', function() {

	// The location of our default theme file
	var theme_default = './assets/sass/_theme-default.scss';

	// If our default theme file does not exist we need to create it
	if ( fs.existsSync( theme_default ) == false ) {

		// Read our PHP theme config file
		runner.exec(
		    'php -r \'print json_encode(include("./config/theme.php"));\'', 
		    function (err, stdout, stderr) {

		    	// Convert array stdout to json
		    	var theme_settings = JSON.parse(stdout);
		    	
		    	// Loop over theme settings and create sass variables
				for (var i=0; i < theme_settings.length; i++) {

					// Alias current setting
					var s = theme_settings[i];

					// Append sass variable string to theme_default file with sync
					fs.appendFileSync( theme_default, '$' + s.name + ': ' + s._default + ";\r\n" , { 'mode': 420 }, function (err) {
						console.log( err );
					});
				}
		  	}
		);
	}
	else {
		console.log( 'Theme file already exists' );
	}
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

// When running gulp without any tasks, it'll watch the scripts, styles, and do artisan publishing.etc.
gulp.task('default' , function() {

	gulp.run('theme-config');

	gulp.start('scripts-watch', 'styles-watch');

	// Run any custom gulp code
	if (custom) {
		custom.start();
	}
});

// Registers the tasks you'd like to run
if (custom) {
	custom.tasks();
}