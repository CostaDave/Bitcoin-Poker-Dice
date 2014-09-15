module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    copy: {
      dist: {
        files: [
        {src: 'application/views/home.php', dest: 'application/views/build.php'},
        {expand: true, flatten: true, src: 'assets/img/*', dest: 'dist/img'},
        {expand: true, flatten: true, src: 'assets/fonts/*', dest: 'dist/fonts'},
        {expand: true, flatten: true, src: 'assets/img/dice/*', dest: 'dist/img/dice'},
        {expand: true, flatten: true, src: 'assets/mp3/*', dest: 'dist/mp3'},
        {expand: true, flatten: true, src: 'bower_components/font-awesome/fonts/*', dest: 'dist/fonts'},
        {expand: true, flatten: true, src: 'bower_components/bootstrap/fonts/*', dest: 'dist/fonts'},
        {expand: true, flatten: true, src: 'bower_components/CSS-Playing-Cards/faces/*', dest: 'dist/faces'}
          ],
      }
    },
    replace: {
      styles: {
        src: ['.tmp/concat/app.min.css'],             // source files array (supports minimatch)
        dest: '.tmp/concat/app.min.css',             // destination directory or file
        replacements: [{
          from: '/assets/',                   // string replacement
          to: '/dist/'
        }]
      },
      js: {
        src: ['.tmp/concat/app.min.js'],             // source files array (supports minimatch)
        dest: '.tmp/concat/app.min.js',             // destination directory or file
        replacements: [{
          from: '/assets/',                   // string replacement
          to: '/dist/'
        }]
      }
    },
    removelogging: {
      dist: {
        src: "dist/app.min.js"
      }
    },
    'useminPrepare': {
      options: {
        root: '/home/wsadmin/bitzee/',
        dest: 'dist'
      },
      html: 'application/views/home.php'
    },

    usemin: {
      options: {
        assetDirs: '/dist/'
      },
      html: ['application/views/build.php']
    },

    cssmin: {
      combine: {
        files: {
          'dist/app.min.css': ['.tmp/concat/app.min.css']
        }
      }
    }


  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-usemin');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-text-replace');
  grunt.loadNpmTasks('grunt-remove-logging');

  grunt.registerTask('default', ['useminPrepare', 'copy',  'concat', 'replace', 'uglify', 'usemin', 'cssmin']);
};