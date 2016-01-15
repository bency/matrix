var gulp = require('gulp'),
    notify  = require('gulp-notify'),
    args    = require('yargs').argv,
    allowedArgs = ['group', 'debug', 'repeat', 'verbose'];
    phpunit = require('gulp-phpunit');

gulp.task('phpunit', function() {
    var options = {debug: true, notify: true};
    var phpunitArgs = '';
    for (var i in args) {

        if (allowedArgs.indexOf(i) == -1) {
            continue;
        }

        if (typeof args[i] === 'string') {
            phpunitArgs += ' --' + i + ' ' + args[i];
        } else {
            phpunitArgs += ' --' + i;
        }
    }
    gulp.src('tests/**/*.php')
        .pipe(phpunit('/usr/local/bin/phpunit' + phpunitArgs, options))
        .on('error', notify.onError({
            title: "Failed Tests!",
            message: "Error(s) occurred during testing..."
        }));
});
gulp.task('default', function(){
	gulp.watch(
		['src/**/*.php', 'tests/**/*.php'],
		{ debounceDelay: 2000, emit: 'one', verbose: true },
		['phpunit']
	);
});
