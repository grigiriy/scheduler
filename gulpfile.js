'use strict';


var gulp = require('gulp'),
    sass = require('gulp-sass'),
    // concat = require('gulp-concat'),
    sourcemaps = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer'),
    notify = require('gulp-notify'),
    cssmin = require('gulp-cssmin');
    // rename = require('gulp-rename');
    // del = require('del');

gulp.task('styles', function () {
    return gulp.src('src/scss/main.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        // .pipe(autoprefixer(['last 2 versions', 'ie 10', 'opera 12']))
        // .pipe(cssmin())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('css'))
        .pipe(notify({message: 'Собрались стили темы'}));
});

gulp.task('build', function () {
    return gulp.src('src/scss/main.scss')
        // .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(autoprefixer(['last 2 versions', 'ie 10', 'opera 12']))
        .pipe(cssmin())
        // .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('css'))
        .pipe(notify({message: 'Собрались стили темы для прода'}));
});

// gulp.task('assets', function(){
//   return gulp.src('src/assets/**', {since: gulp.lastRun('assets') })
//   .pipe(gulp.dest('assets'))
//   .pipe(notify({message: 'Собрались ассетсы темы'}));
// });

gulp.watch('src/**/*.*', ['styles'])
// gulp.watch('src/**/*.*', ['assets'])


// gulp.task('theme', ['styles', 'watch']);
