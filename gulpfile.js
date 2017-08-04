var path = require('path');
var fs = require('fs');
var gulp = require('gulp');
var less = require('gulp-less');
var header = require('gulp-header');
var tap = require('gulp-tap');
var nano = require('gulp-cssnano');
var postcss = require('gulp-postcss');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var cssmin = require('gulp-cssmin');
var uglify = require('gulp-uglify');
var autoprefixer = require('autoprefixer');
var comments = require('postcss-discard-comments');
var rename = require('gulp-rename');
var sourcemaps = require('gulp-sourcemaps');
var browserSync = require('browser-sync');
var pkg = require('./package.json');
var yargs = require('yargs').options({
    w: {
        alias: 'watch',
        type: 'boolean'
    },
    s: {
        alias: 'server',
        type: 'boolean'
    },
    p: {
        alias: 'port',
        type: 'number'
    }
}).argv;

var srcstyle =  'resources/assets/weui';
var diststyle = 'public/weui';
var srcexample =  'mobile/example';
var distexample = 'resources/views/mobile/example';
var srcapp =  'resources/assets';
var distapp = 'public';

gulp.task('build:style', function() {
    var banner = [
        '/*!',
        ' * WeUI v<%= pkg.version %> (<%= pkg.homepage %>)',
        ' * Copyright <%= new Date().getFullYear() %> Tencent, Inc.',
        ' * Licensed under the <%= pkg.license %> license',
        ' */',
        ''
    ].join('\n');

    gulp
        .src(srcstyle+'/*.js', { base: srcstyle })
        .pipe(gulp.dest(diststyle))
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(diststyle))
        .pipe(browserSync.reload({ stream: true }));

    gulp
        .src(srcstyle + '/weui.less', { base: srcstyle })
        .pipe(sourcemaps.init())
        .pipe(
            less().on('error', function(e) {
                console.error(e.message);
                this.emit('end');
            })
        )
        .pipe(postcss([autoprefixer(['iOS >= 7', 'Android >= 4.1']), comments()]))
        .pipe(header(banner, { pkg: pkg }))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(diststyle))
        .pipe(browserSync.reload({ stream: true }))
        .pipe(
            nano({
                zindex: false,
                autoprefixer: false
            })
        )
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(diststyle));
});

gulp.task('build:example:assets', function() {
    gulp
        .src(srcexample+'/**/*.?(png|jpg|gif)', { base: srcexample })
        .pipe(gulp.dest(diststyle))
        .pipe(browserSync.reload({ stream: true }));

    gulp
        .src(srcexample+'/**/*.js', { base: srcexample })
        .pipe(concat('example.js'))
        .pipe(gulp.dest(diststyle))
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(diststyle))
        .pipe(browserSync.reload({ stream: true }));
});

gulp.task('build:example:style', function() {
    gulp
        .src(srcexample+'/example.less', { base: srcexample })
        .pipe(
            less().on('error', function(e) {
                console.error(e.message);
                this.emit('end');
            })
        )
        .pipe(postcss([autoprefixer(['iOS >= 7', 'Android >= 4.1'])]))
        .pipe(gulp.dest(diststyle))
        .pipe(browserSync.reload({ stream: true }))
        .pipe(
            nano({
                zindex: false,
                autoprefixer: false
            })
        )
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(diststyle))
        .pipe(browserSync.reload({ stream: true }));
});

gulp.task('build:example:html', function() {
    gulp
        .src(srcexample+'/*.blade.php', { base: srcexample })
        .pipe(rename(function (path) {
            path.extname = ".php"
        }))
        .pipe(gulp.dest(distexample))

    gulp
        .src(srcexample+'/index.html', { base: srcexample })
        .pipe(
            tap(function(file) {
                var dir = path.dirname(file.path);
                var contents = file.contents.toString();
                contents = contents.replace(
                    /<link\s+rel="import"\s+href="(.*)">/gi,
                    function(match, $1) {
                        var filename = path.join(dir, $1);
                        var id = path.basename(filename, '.html');
                        var content = fs.readFileSync(filename, 'utf-8');
                        return (
                            '<script type="text/html" id="tpl_' +
                            id +
                            '">\n' +
                            content +
                            '\n</script>'
                        );
                    }
                );
                file.contents = new Buffer(contents);
            })
        )
        .pipe(rename(function (path) {
            path.extname = ".blade.php"
        }))
        .pipe(gulp.dest(distexample))
        .pipe(browserSync.reload({ stream: true }));
});

gulp.task('build:example', [
    'build:example:assets',
    'build:example:style',
    'build:example:html'
]);

gulp.task('build:app', function() {
    gulp
        .src(srcapp+'/sass/app.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(concat('app.css'))
        .pipe(gulp.dest(distapp+'/css'))
        .pipe(cssmin())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(distapp+'/css'))
        .pipe(browserSync.reload({ stream: true }));

    // gulp
    //     .src(srcapp+'/sass/bootstrap.css')
    //     .pipe(rename(function(path) {
    //         path.basename = 'app';
    //     }))
    //     .pipe(gulp.dest(distapp+'/css'))
    //     .pipe(cssmin())
    //     .pipe(rename({suffix: '.min'}))
    //     .pipe(gulp.dest(distapp+'/css'))
    //     .pipe(browserSync.reload({ stream: true }));

    gulp
        .src([srcapp+'/js/jquery.js',srcapp+'/js/bootstrap.js'])
        .pipe(concat('app.js'))
        .pipe(gulp.dest(distapp+'/js'))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest(distapp+'/js'))
        .pipe(browserSync.reload({ stream: true }));
});

gulp.task('release', ['build:style', 'build:example', 'build:app']);

// gulp.task('watch', ['release'], function() {
//     gulp.watch('src/style/**/*', ['build:style']);
//     gulp.watch('src/example/example.less', ['build:example:style']);
//     gulp.watch('src/example/**/*.?(png|jpg|gif|js)', ['build:example:assets']);
//     gulp.watch('src/**/*.html', ['build:example:html']);
// });
//
// gulp.task('server', function() {
//     yargs.p = yargs.p || 8080;
//     browserSync.init({
//         server: {
//             baseDir: './dist'
//         },
//         ui: {
//             port: yargs.p + 1,
//             weinre: {
//                 port: yargs.p + 2
//             }
//         },
//         port: yargs.p,
//         startPath: '/example'
//     });
// });

// 参数说明
//  -w: 实时监听
//  -s: 启动服务器
//  -p: 服务器启动端口，默认8080
gulp.task('default', ['release'], function() {
    // if (yargs.s) {
    //     gulp.start('server');
    // }
    //
    // if (yargs.w) {
    //     gulp.start('watch');
    // }
});
