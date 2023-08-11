var gulp = require('gulp');
var newer = require('gulp-newer');
var minifyCss = require('gulp-minify-css');
var uglify = require('gulp-uglify');

cssSrc = 'public/frontend/css/*.css';//Your css source directory
cssDest = 'public/frontend/min';//Your css destination directory

jsSrc = 'public/frontend/js/*.js';//Your js source directory
jsDest = 'public/frontend/min';//Your js destination directory


gulp.task('cssTask', function() {
    return gulp.src(cssSrc)
        .pipe(newer(cssDest))//compares the css source and css destination(css files)
        .pipe(minifyCss())//minify css
        .pipe(gulp.dest(cssDest));//save minified css in destination directory 
});

gulp.task('jsTask', function() {
    return gulp.src(jsSrc)
        .pipe(newer(jsDest))//compares the js source and js destination(js files)
        .pipe(uglify())//minify js
        .pipe(gulp.dest(jsDest));//save minified js in destination directory 
});

gulp.task('custom', function() {//Watch task
    gulp.watch(cssSrc, ['cssTask']);//watch your css source and call css task
    gulp.watch(jsSrc, ['jsTask']);//watch your js source and call js task
});