(function () {
    'use strict';

    angular
        .module('Shift.Sessions.Services', [])
        .service('LoginService', LoginService);

    /**
     * A service to handle aspects of User login such as;
     *   - setting remember me to session,
     *   - updating username in session,
     *   - collecting current users session data,
     *   - ...and logging in of course.
     *
     * @param $http
     * @param $rootScope
     * @param $cookies
     * @returns {{login: Function, updateUsername: Function, setRememberMe: Function, getSessionData: Function}}
     * @constructor
     */
    LoginService.$inject = ['$http', '$rootScope', '$cookies'];
    function LoginService($http, $rootScope, $cookies) {

        this.username = '';

        var service = {

            /**
             * Handle login
             *
             * @param data
             */
            login: function(data) {
                this.setRememberMe(data);

                var req = $http.post( apiUrl('sessions'), data);

                req.success( function( user ) {
                    // Set the user object
                    $rootScope.user = user;
                    $rootScope.$broadcast( 'user.authorised', user );
                    $rootScope.$broadcast( 'menu.refresh' );
                });
            },

            /**
             * Update email to represent new username
             *
             * @param {string} username
             */
            updateUsername: function(username) {
                if ( !angular.isUndefined( username ) ) {
                    this.username = username;
                }
            },

            /**
             * Save username to cookie "if" remember me is set to true
             *
             * @param data
             */
            setRememberMe: function(data) {
                if(data.remember) {
                    $cookies.remember = data.remember;
                    $cookies.username = data.username;
                }
            },

            /**
             * Return a users session details if they exist in the cookie
             *
             * @returns {{remember: string, username: string}}
             */
            getSessionData: function() {
                var session = { remember: '', username: '' };

                if ( $cookies.username ) {
                    session.remember = '1';
                    session.username = $cookies.username;
                }

                return session;
            }


        };

        return service;
    }


})();