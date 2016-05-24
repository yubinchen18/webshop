module.exports = function(grunt) {

    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-less');

    grunt.registerTask('dev', ['concat', 'less']);
    grunt.registerTask('default', ['concat', 'less', 'uglify']);


    grunt.initConfig({
        concat: {
            options: {
                seperator: '\r\n',
            },
            front: {
                src: [
                    './node_modules/jquery/dist/jquery.min.js',
                    './vendor/twbs/bootstrap/dist/js/bootstrap.min.js',
                    './src/webroot/js/*.js',
                ],
                dest: './webroot/js/main.js'
            },
            admin: {
                src: [
                    './node_modules/jquery/dist/jquery.min.js',
                    './vendor/twbs/bootstrap/dist/js/bootstrap.min.js',
                    './src/webroot/js/admin/*.js',
                ],
                dest: './webroot/js/admin.js'
            }
        },
        less: {
            front: {
                options: {
                    compress: true,
                },
                files: {
                    './webroot/css/layout.css': './src/webroot/css/style.less',
                    './webroot/css/admin.css': './src/webroot/css/admin.less'
                }
            }
        },
        uglify : {
            options: {
                mangle: false
            },
            front: {
                files: {
                    './webroot/js/main.js': './webroot/js/main.js',
                    './webroot/js/admin.js': './webroot/js/admin.js'
                }
            }
        },
        watch: {
            less: {
                files: ['./src/webroot/css/less/**', './src/webroot/css/**' ],
                tasks: ['less:front']
            },
            js: {
                files: ['<%= concat.front.src %>'],
                tasks: ['concat:front']
            },
            admin: {
                files: ['<%= concat.admin.src %>'],
                tasks: ['concat:admin']
            }
        }
    });

};
