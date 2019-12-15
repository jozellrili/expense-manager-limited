const {src, dest, parallel} = require('gulp');
const gulp = require('gulp');

// Include Our Plugins
const sass = require('gulp-sass');
const babel = require('gulp-babel');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const autoprefixer = require('gulp-autoprefixer');
const image = require('gulp-image');
const cleanCSS = require('gulp-clean-css');
const sourcemaps = require('gulp-sourcemaps');
const del = require('del');

/* Not all tasks need to use streams, a gulpfile is just another node program
 * and you can use all packages available on npm, but it must return either a
 * Promise, a Stream or take a callback and call it
 */
function clean() {
    // You can use multiple globbing patterns as you would with `gulp.src`,
    // for example if you are using del 2.0 or above, return its promise
    return del(['../../public/css/style.min.css', '../../public/js/all/min.css']);
}


const paths = {
    styles: {
        src: ['src/scss/*.scss', 'src/scss/**/*.scss'],
        dest: '../../public/css/'
    },
    scripts: {
        src: 'src/js/*.js',
        dest: '../../public/js/'
    },
    images: {
        src: 'dist/images/**/*',
        dest: '../../public/images/**/*'
    }
};

/*
* Define our tasks using plain functions
*/

function styles() {
    return src(paths.styles.src)
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(cleanCSS({force: true}))
        // pass in options to the stream
        .pipe(rename({
            basename: 'style',
            suffix: '.min'
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(paths.styles.dest));
}

function scripts() {
    return src(paths.scripts.src)
        .pipe(sourcemaps.init())
        .pipe(babel())
        .pipe(uglify())
        .pipe(concat('all.min.js'))
        .pipe(sourcemaps.write('.'))
        .pipe(dest(paths.scripts.dest));
}

function images() {
    return gulp.src(paths.styles.src)
        .pipe(image())
        .pipe(gulp.dest(paths.images.dest));
}

function watch() {
    gulp.watch(paths.scripts.src, scripts);
    gulp.watch(paths.styles.src, styles);
}

/*
 * Specify if tasks run in series or parallel using `gulp.series` and `gulp.parallel`
 */
const build = gulp.series(clean, gulp.parallel(styles, scripts));

/*
* You can use CommonJS `exports` module notation to declare tasks
*/
exports.clean = clean;
exports.styles = styles;
exports.scripts = scripts;
exports.images = images;
exports.watch = watch;
exports.default = parallel(clean, styles, scripts, watch);

// /*
//  * You can still use `gulp.task` to expose tasks
//  */
gulp.task('dist', build);

/*
 * Define default task that can be called by just running `gulp` from cli
 */
gulp.task('default', build);