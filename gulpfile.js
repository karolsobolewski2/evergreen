const gulp = require('gulp')
const babel = require('gulp-babel')
const sass = require('gulp-sass')
const browserSync = require('browser-sync').create()
const autoprefixer = require('gulp-autoprefixer')
const minify = require('gulp-clean-css')
const uglify = require('gulp-uglify')
const rename = require('gulp-rename')
const gcmq = require('gulp-group-css-media-queries')


const autoprefixerOptions = {
	browsers: ['last 2 versions', '> 5%', 'Firefox ESR']
}


gulp.task('browserSync', function () {
	browserSync.init({
		proxy: 'http://localhost/evergreen'
	})
})


gulp.task('build-css', function () {
	return gulp.src('src/scss/**/*.scss')
		//.pipe(sourcemaps.init())
		.pipe(sass({
			outputStyle: 'expanded'
		}).on('error', sass.logError))
		.pipe(autoprefixer(autoprefixerOptions))
		.pipe(gcmq())
		.pipe(rename({ extname: '.min.css' }))
		.pipe(minify())
		//.pipe(sourcemaps.write())
		.pipe(gulp.dest('assets/css'))
		.pipe(browserSync.stream());
})


gulp.task('build-js', function () {
	return gulp.src('src/js/**/*.js')
		//.pipe(sourcemaps.init())
		.pipe(babel({ presets: ['es2015'] }))
		.pipe(uglify())
		.pipe(rename({ suffix: '.min' }))
		//.pipe(sourcemaps.write())
		.pipe(gulp.dest('assets/js'));
})


gulp.task('watch', ['browserSync', 'build-css', 'build-js'], function () {
	gulp.watch('src/scss/**/*.scss', ['build-css'])
	gulp.watch('src/js/**/*.js', ['build-js'])
	gulp.watch('*.html', browserSync.reload)
	gulp.watch('**/*.php', browserSync.reload)
	gulp.watch('assets/js/**/*.js', browserSync.reload)
	//gulp.watch('css/**/*.css', browserSync.reload)
	gulp.watch('assets/img/**/*.*', browserSync.reload)
})
