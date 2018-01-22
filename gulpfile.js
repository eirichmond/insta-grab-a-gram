var gulp = require('gulp');

var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');


var browserSync = require('browser-sync').create();

gulp.task('sass', function(){
  return gulp.src('public/sass/insta-grab-public.scss')
    .pipe(autoprefixer({
        browsers: ['last 2 versions'],
        cascade: false
    }))
    .pipe(sass({outputStyle: 'compressed'})) // Converts Sass to CSS with gulp-sass
    .pipe(gulp.dest('public/css'))
    .pipe(browserSync.reload({
      stream: true
    }))
});

gulp.task('browserSync', function() {
  browserSync.init({
      proxy: 'local.instagrabagram.dev/test', // or project.dev/app/
  })
})

gulp.task('watch', ['browserSync', 'sass'], function(){
  gulp.watch('public/sass/**/*.scss', ['sass']); 
  // Other watchers
})
