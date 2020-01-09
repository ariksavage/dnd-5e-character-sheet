const gulp = require( "gulp" );
const angularModule = require('./gulp/angular.module.js');
const SCSSmodule = require('./gulp/scss.module.js');
const PHPmodule = require('./gulp/php.module.js');

const paths = {}
paths.src = 'build/**';
const destRoot = 'html';
paths.index = {
  src: 'build/index.php',
  dest: destRoot
};

paths.templates = {
  src: 'build/**/*.template.html',
  dest: destRoot+'/templates'
};
paths.favicons = {
  src: './build/favicons/**/*.{png,xml,ico,svg,webmanifest}',
  dest: destRoot+'/img/favicons'
}
paths.js = {
  libraries: ['node_modules/angular/angular.min.js', 'node_modules/angular/angular.min.js.map', 'node_modules/angular-route/angular-route.min.js', 'node_modules/angular-route/angular-route.min.js.map'],
  dest: destRoot+'/js'
};
paths.scss = {
  src: 'build/**/*.scss',
  dest: destRoot+'/css'
};
paths.api = {
  src: 'build/api/**/*',
  dest: destRoot + '/api'
}

const api = function(){
  return gulp.src(paths.api.src)
  .pipe(gulp.dest(paths.api.dest));
}
Object.assign(api, {displayName: 'API'});
gulp.task(api);

const favicons = function(){
  return gulp.src(paths.favicons.src)
  .pipe(gulp.dest(paths.favicons.dest));
}
Object.assign(favicons, {displayName: 'Favicons'});
gulp.task(favicons);

const SCSS = function(){
  return SCSSmodule.compileLint(gulp.src(paths.scss.src))
  .pipe(gulp.dest(paths.scss.dest));
}
Object.assign(SCSS, {displayName: 'SCSS'});
gulp.task(SCSS);

const index = function(){
  return gulp
  .src( paths.index.src )
  .pipe( gulp.dest( paths.index.dest ) );
}
Object.assign(index, {displayName: 'Index'});
gulp.task(index );

const jsLibraries = function(){
  return gulp
  .src(paths.js.libraries)
  .pipe(gulp.dest( paths.js.dest))
}
Object.assign(jsLibraries, {displayName: "JS: Libraries"});
gulp.task( jsLibraries );

const angularApp = function(){
  return angularModule.app(paths.src, paths.js.dest);
}
Object.assign(angularApp, {displayName: "JS: Angular: App"});
gulp.task( angularApp );

const angularTemplates = function() {
  return angularModule.templates(paths.src, destRoot);
}
Object.assign(angularTemplates, {displayName: "JS: Angular: Templates"});
gulp.task( angularTemplates );

const angularControllers = function() {
  return angularModule.controllers(paths.src, paths.js.dest);
}
Object.assign(angularControllers, {displayName: "JS: Angular: Controllers"});
gulp.task( angularControllers );

const angularDirectives = function() {
  return angularModule.directives(paths.src, paths.js.dest);
}
Object.assign(angularDirectives, {displayName: "JS: Angular: Directives"});
gulp.task( angularDirectives );

const angularServices = function() {
  return angularModule.services(paths.src, paths.js.dest);
}
Object.assign(angularServices, {displayName: "JS: Angular: Services" });
gulp.task( angularServices );


const watch = function() {
  gulp.watch( paths.index.src, { usePolling: true }, index );
  gulp.watch( paths.api.src, { usePolling: true }, api );
  gulp.watch( paths.scss.src, { usePolling: true }, SCSS );
  gulp.watch( 'build/**/*.template.html', { usePolling: true }, angularTemplates );
  gulp.watch( 'build/**/*.app.js', { usePolling: true }, angularApp );
  gulp.watch( 'build/**/*.controller.js', { usePolling: true }, angularControllers );
  gulp.watch( 'build/**/*.directive.js', { usePolling: true }, angularDirectives );
  gulp.watch( 'build/**/*.service.js', { usePolling: true }, angularServices );
}
gulp.task( watch );

gulp.task( "default", gulp.series( index, api, angularTemplates, jsLibraries, angularApp, angularControllers, angularDirectives, angularServices, SCSS, favicons, watch));
