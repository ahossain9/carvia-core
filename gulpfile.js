'use strict';

const { src, dest, watch, series, parallel } = require('gulp');
const sass       = require('gulp-sass')(require('sass'));
const cleanCSS   = require('gulp-clean-css');
const rename     = require('gulp-rename');
const sourcemaps = require('gulp-sourcemaps');
const uglify     = require('gulp-uglify');
const zip        = require('gulp-zip');
const log        = require('fancy-log');

/* ─── Paths ───────────────────────────────────────────────── */
const paths = {
  scss: {
    src:    'assets/scss/main.scss',
    watch:  'assets/scss/**/*.scss',
    dest:   'assets/css/',
  },
  adminScss: {
    src:    'assets/scss/admin.scss',
    dest:   'assets/css/',
  },
  js: {
    src:    'assets/js/main.js',
    dest:   'assets/js/',
  },
  zip: {
    src: [
      '**/*',
      '!node_modules/**',
      '!.git/**',
      '!*.zip',
      '!gulpfile.js',
      '!package*.json',
      '!assets/scss/**',
      '!assets/css/maps/**'
    ],
    filename: 'carvia-core.zip',
    dest:     '../', // one level up from theme root
  },
};

/* ─── CSS: compile main SCSS → assets/css/style.min.css ───── */
function compileSCSS() {
  return src(paths.scss.src)
    .pipe(sourcemaps.init())
    .pipe(
      sass({
        outputStyle: 'compressed',
        silenceDeprecations: ['legacy-js-api'],
      }).on('error', sass.logError)
    )
    .pipe(cleanCSS({ level: 2 }))
    .pipe(rename({ basename: 'style', suffix: '.min' }))
    .pipe(sourcemaps.write('./maps'))
    .pipe(dest(paths.scss.dest))
    .on('end', () => log('✔  SCSS compiled → assets/css/style.min.css'));
}

/* ─── CSS: compile admin SCSS → assets/css/admin.min.css ───── */
function compileAdminSCSS() {
  return src(paths.adminScss.src)
    .pipe(sourcemaps.init())
    .pipe(
      sass({
        outputStyle: 'compressed',
        silenceDeprecations: ['legacy-js-api'],
      }).on('error', sass.logError)
    )
    .pipe(cleanCSS({ level: 2 }))
    .pipe(rename({ basename: 'admin', suffix: '.min' }))
    .pipe(sourcemaps.write('./maps'))
    .pipe(dest(paths.adminScss.dest))
    .on('end', () => log('✔  Admin SCSS compiled → assets/css/admin.min.css'));
}

/* ─── JS: minify ───────────────────────────────────────────── */
function compileJS() {
  return src(paths.js.src)
    .pipe(uglify())
    .pipe(rename({ suffix: '.min' }))
    .pipe(dest(paths.js.dest))
    .on('end', () => log('✔  JS minified → assets/js/main.min.js'));
}

/* ─── Watch ────────────────────────────────────────────────── */
function watchFiles() {
  // One glob covers both main.scss and admin.scss
  watch(paths.scss.watch, parallel(compileSCSS, compileAdminSCSS));
  watch(paths.js.src, compileJS);
  log('👀  Watching SCSS & JS files…');
}

/* ─── Package: generate carvia.zip ─────────────────────────── */
function packagePlugin() {
  return src(paths.zip.src, { base: '../' })
    .pipe(zip(paths.zip.filename))
    .pipe(dest(paths.zip.dest))
    .on('end', () => log('carvia.zip generated at ' + paths.zip.dest));
}

/* ─── Exports ───────────────────────────────────────────────── */
exports.build   = parallel(compileSCSS, compileAdminSCSS, compileJS);
exports.watch   = series(exports.build, watchFiles);
exports.package = series(exports.build, packagePlugin);
exports.default = exports.build;