/**
 * Gulpfile
 *
 * Available CLI commands:
 *  - gulp prod -- builds JS/CSS for production server
 *  - gulp dev  -- builds JS/CSS for dev server
 *  - gulp      -- watch & build JS/CSS for dev server
 *
 * In case you need more control over what's happening, there's more commands available:
 *  - gulp {env}-{command}
 *
 *    {env} can be of: prod, dev
 *    {command} can be any of: js, topfold, amp, sass
 *
 * Examples:
 * gulp prod-sass51
 * gulp prod-topfold51
 * gulp dev-sass51
 * gulp dev-topfold51
 * gulp dev-docs51
 */

var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');
var sassdoc = require('sassdoc');
var cleanCSS = require('gulp-clean-css');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var exec = require('child_process').exec;
var extractMediaQuery = require('gulp-extract-media-query');
var clean = require('gulp-clean');

/* OPTIONS */
var config = {
  src: {
    docs51: 'wp-content/themes/instapagev3/v5/components/v51',
    docsamp: 'wp-content/themes/instapagev3/v5/components/amp',
    sass51: 'wp-content/themes/instapagev3/v5/assets/sass/v51/ui.scss',
    topfold51: 'wp-content/themes/instapagev3/v5/assets/sass/v51/topfold.scss',
    amp51: 'wp-content/themes/instapagev3/v5/assets/sass/amp/pages/*.scss',
    js51: [
      'wp-content/themes/instapagev3/v5/assets/js/v51/src/libs/*.js',
      'wp-content/themes/instapagev3/v5/assets/js/v70/src/libs/*.js',
      '!wp-content/themes/instapagev3/v5/assets/js/v51/src/legacy.js',
      '!wp-content/themes/instapagev3/v5/assets/js/v51/src/libs/lazysizes.min.js',
      'wp-content/themes/instapagev3/v5/components/generic/*/js/scripts.js',
      'wp-content/themes/instapagev3/v5/components/v51/*/js/scripts.js',
      'wp-content/themes/instapagev3/v5/components/v70/*/js/scripts.js',
      'wp-content/themes/instapagev3/v5/assets/js/v51/src/*.js',
      'wp-content/themes/instapagev3/v5/assets/js/v70/src/*.js',
      'wp-content/themes/instapagev3/v5/assets/js/generic/*.js',
      '!wp-content/themes/instapagev3/v5/assets/js/v51/src/admin.js'
    ],
    watch: [
      'wp-content/themes/instapagev3/v5/assets/sass/**/*.scss',
      'wp-content/themes/instapagev3/v5/components/v51/*/scss/*.scss',
      'wp-content/themes/instapagev3/v5/components/v70/*/scss/*.scss'
    ],
    sassdoc: 'wp-content/themes/instapagev3/ui/**/*.scss'
  },
  dest: {
    docs51: 'docs/v51',
    docsamp: 'docs/amp',
    sass: 'wp-content/themes/instapagev3/v5/assets/css',
    sassFilename51: 'styles51.min.css',
    topfoldFilename51: 'topfold51.min.css',
    amp51: 'wp-content/themes/instapagev3/v5/assets/css/amp',
    ampFilename: 'amp.min.css',
    js51: 'wp-content/themes/instapagev3/v5/assets/js/v51',
    jsFilename: 'scripts.min.js',
    sassdoc: 'sassdoc'
  }
};

var constants = {
  default: {
    browsers: [
      'edge >16',
      'safari >9',
      'firefox 52',
      'firefox >61',
      'chrome 49',
      'chrome >62',
      'android >66',
      'android 4',
      'samsung >3',
      'opera 55',
      'opera 56',
      'ios_saf >9',
      'op_mini all',
      'op_mob 46',
      'and_chr 70',
      'and_ff 63',
      'and_qq 1.2',
      'baidu 7',
      'and_uc 11.8',
      'safari 9',
      'firefox 51',
      'chrome 60',
      'android 67',
      'samsung 5',
      'opera 17'
    ]
  }
}

/* PRODUCTIONS TASKS */
gulp.task('prod-amp', function() {
  return gulp.src(config.src.amp)
    .pipe(concat(config.dest.ampFilename))
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({browsers: constants.default.browsers}))
    .pipe(rename(config.dest.ampFilename))
    .pipe(cleanCSS())
    .pipe(gulp.dest(config.dest.sass));
});

/* v5.1 */
gulp.task('prod-js51', function() {
  return gulp.src(config.src.js51)
    .pipe(concat(config.dest.jsFilename))
    .pipe(rename(config.dest.jsFilename))
    .pipe(uglify())
    .pipe(gulp.dest(config.dest.js51));
});

gulp.task('prod-topfold51', function() {
  return gulp.src(config.src.topfold51)
    .pipe(concat(config.dest.topfoldFilename51))
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({browsers: constants.default.browsers}))
    .pipe(rename(config.dest.topfoldFilename51))
    .pipe(cleanCSS())
    .pipe(gulp.dest(config.dest.sass));
});

gulp.task('prod-sass51', function() {
  return gulp.src(config.src.sass51)
    .pipe(concat(config.dest.sassFilename51))
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({browsers: constants.default.browsers}))
    .pipe(rename(config.dest.sassFilename51))
    .pipe(cleanCSS())
    .pipe(gulp.dest(config.dest.sass));
});

/* DEVELOPMENT TASKS */
gulp.task('dev-amp', function() {
  return gulp.src(config.src.amp)
    .pipe(sourcemaps.init())
    .pipe(concat(config.dest.ampFilename))
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({browsers: constants.default.browsers}))
    .pipe(rename(config.dest.ampFilename))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(config.dest.sass));
});

gulp.task('dev-docsamp', function (cb) {
  exec('php ./tools/comp-doc/bin/comp-doc.phar -s ' + config.src.docsamp + ' -d ' + config.dest.docsamp + ' -t "Website AMP components"', function (error, stdout, stderr) {
    if (stdout.length) {
      console.log(stdout);
    }
    cb(error);
  });
});

/* v5.1 */
gulp.task('dev-js51', function() {
  return gulp.src(config.src.js51)
    .pipe(sourcemaps.init())
    .pipe(concat(config.dest.jsFilename))
    .pipe(rename(config.dest.jsFilename))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(config.dest.js51));
});

gulp.task('dev-topfold51', function() {
  return gulp.src(config.src.topfold51)
    .pipe(sourcemaps.init())
    .pipe(concat(config.dest.topfoldFilename51))
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({browsers: constants.default.browsers}))
    .pipe(rename(config.dest.topfoldFilename51))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(config.dest.sass));
});

gulp.task('dev-sass51', function() {
  return gulp.src(config.src.sass51)
    .pipe(sourcemaps.init())
    .pipe(concat(config.dest.sassFilename51))
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({browsers: constants.default.browsers}))
    .pipe(rename(config.dest.sassFilename51))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(config.dest.sass));
});

gulp.task('dev-docs51', function(cb) {
  exec('php ./tools/comp-doc/bin/comp-doc.phar -s ' + config.src.docs51 + ' -d ' + config.dest.docs51 + ' -t "Website v.5.1 components"', function(error, stdout, stderr) {
    if (stdout.length) {
      console.log(stdout);
    }
    cb(error);
  });
});

gulp.task('sassdoc', function() {
  return gulp.src(config.src.sassdoc)
    .pipe(sassdoc());
});

gulp.task('amp-scss', function () {
  return gulp.src(config.src.amp51)
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({browsers: constants.default.browsers}))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(config.dest.amp51));
});

gulp.task('no-mq-css', ['amp-scss'], function() {
  return gulp.src(config.dest.amp51 + '/*.css')
    .pipe(extractMediaQuery({
      match: '(min-width: 750px)',
      postfix: '-responsive'
    }))
    .pipe(extractMediaQuery({
      match: '(min-width: 820px)',
      postfix: '-responsive'
    }))
    .pipe(extractMediaQuery({
      match: '(min-width: 970px)',
      postfix: '-responsive'
    }))
    .pipe(extractMediaQuery({
      match: '(min-width: 1170px)',
      postfix: '-responsive'
    }))
    .pipe(extractMediaQuery({
      match: '(min-width: 1220px)',
      postfix: '-responsive'
    }))
    .pipe(extractMediaQuery({
      match: '(max-width: 749px)',
      postfix: '-responsive'
    }))
    .pipe(extractMediaQuery({
      match: '(max-width: 750px)',
      postfix: '-responsive'
    }))
    .pipe(extractMediaQuery({
      match: '(max-width: 969px)',
      postfix: '-responsive'
    }))
    .pipe(extractMediaQuery({
      match: '(max-width: 970px)',
      postfix: '-responsive'
    }))
    .pipe(extractMediaQuery({
      match: '(max-width: 1170px)',
      postfix: '-responsive'
    }))
    .pipe(cleanCSS())
    .pipe(gulp.dest(config.dest.amp51));
});

gulp.task('amp-css', ['no-mq-css'], function () {
  return gulp.src(config.dest.amp51 + '/*-responsive.css', {read: false})
    .pipe(clean());
});

gulp.task('amp51', ['amp-css']);
gulp.task('dev', ['dev-topfold51', 'dev-sass51', 'dev-js51', 'amp-css']);
gulp.task('prod', ['prod-topfold51', 'prod-sass51', 'prod-js51', 'amp-css']);
gulp.task('docs', ['dev-docs51', 'dev-docsamp']);

gulp.task('default', function() {
  gulp.watch(config.src.amp51, ['amp-css']);
  gulp.watch(config.src.watch, ['dev-topfold51', 'dev-sass51']);
  gulp.watch(config.src.js51, ['dev-js51']);
});
