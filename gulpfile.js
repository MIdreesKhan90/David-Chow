"use strict";

// Load plugins
const autoprefixer = require("autoprefixer");
const browsersync = require("browser-sync").create();
const cssnano = require("cssnano");
const concat = require("gulp-concat");
const gulp = require("gulp");
const plumber = require("gulp-plumber");
const postcss = require("gulp-postcss");
const rename = require("gulp-rename");
const sass = require("gulp-sass")(require("sass"));
const livereload = require("gulp-livereload");
const notify = require("gulp-notify");
const reload = browsersync.reload;

// == Browser-sync task
gulp.task("browser-sync", function (done) {
  browsersync.init({
    proxy: "http:/localhost:4200",
    startPath: "index.php",
    open: true,
    tunnel: true,
  });
  gulp.watch(["./**/*.php"]).on("change", reload);
  done();
});
// == Browser-sync task

// CSS task
gulp.task("css", () => {
  return gulp
    .src("src/assets/scss/style.scss")
    .pipe(plumber())
    .pipe(sass({ outputStyle: "expanded" }))
    .pipe(rename({ suffix: ".min" }))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(gulp.dest("dist/css"))
    .pipe(
      notify({
        message: "main SCSS processed",
      })
    )
    .pipe(browsersync.stream())
    .pipe(livereload());
});

// Webfonts task
gulp.task("webfonts", () => {
  return gulp
    .src("assets/scss/vendor/fontawesome/webfonts/*.{ttf,woff,woff2,eot,svg}")
    .pipe(gulp.dest("dist/webfonts"));
});

// Transpile, concatenate and minify scripts
gulp.task("js", () => {
  return (
    gulp
      .src([
        "src/assets/js/jquery-3.6.0.min.js",
        "src/assets/js/menu.js",
         "src/assets/js/jquery.fancybox.min.js",
        "src/assets/js/general.js",
      ])
      .pipe(plumber())

      // folder only, filename is specified in webpack config
      .pipe(concat("app.js"))
      .pipe(gulp.dest("dist/js"))
      .pipe(browsersync.stream())
      .pipe(livereload())
  );
});

gulp.task(
  "default",
  gulp.series("css", "js", "webfonts", "browser-sync", () => {
    livereload.listen();
    gulp.watch(["src/assets/scss/**/*"], gulp.series("css"));
    gulp.watch(["src/assets/js/**/*"], gulp.series("js"));
    gulp.watch(
      ["src/assets/scss/vendor/fontawesome/webfonts/*"],
      gulp.series("webfonts")
    );
  })
);
