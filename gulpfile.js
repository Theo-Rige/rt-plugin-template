const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('gulp-autoprefixer');

const paths = {
    css: {
        src: 'assets/scss/**/*.scss',
        dest: 'assets/css/'
    },
    js: {
        src: ['assets/js/*.js', '!assets/js/*.min.js', '!assets/js/*.map'], // Prevents an infinite loop.
        dest: 'assets/js/'
    },
    maps: '/' // To save the maps files in the same folder as the original files.
};

/**
 * Compiles SCSS files into CSS.
 * @returns {Object} Gulp stream
 */
function compileSCSS() {
    return gulp
        .src(paths.css.src)
        .pipe(sourcemaps.init())
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(rename({ suffix: '.min' }))
        .pipe(sourcemaps.write(paths.maps))
        .pipe(gulp.dest(paths.css.dest));
}

/**
 * Compresses JavaScript files.
 * @returns {Object} Gulp stream
 */
function compressJS() {
    return gulp
        .src(paths.js.src)
        .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(rename({ suffix: '.min' }))
        .pipe(sourcemaps.write(paths.maps))
        .pipe(gulp.dest(paths.js.dest));
}

/**
 * Watches the specified files for changes and triggers the corresponding tasks.
 */
function watchFiles() {
    gulp.watch(paths.css.src, compileSCSS);
    gulp.watch(paths.js.src, compressJS);
}

gulp.task('default', gulp.series(compileSCSS, compressJS, watchFiles));
