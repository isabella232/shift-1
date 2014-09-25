(function () {
    'use strict';

    var dependencies = [
        'ngCookies'
    ];

    angular
        .module('Shift.Sessions.Controllers', dependencies)
        .controller('Sessions.Auth', Auth)
        .controller('Sessions.New', NewSession)
        .controller('Sessions.Forgot', ForgotSession);

    Auth.$inject = ['$scope'];
    function Auth($scope) {
        $scope.forgotten = false;

        // Handles toggling the state of the form.
        $scope.toggle = function () {
            $scope.forgotten = !$scope.forgotten;
        }
    }

    // Handles the creation of new session
    NewSession.$inject = ['$scope', '$rootScope', '$http', '$cookies', 'LoginService'];
    function NewSession($scope, $rootScope, $http, $cookies, LoginService) {
        // Set the default values, otherwise the '$watch' below won't listen to the variable as it does not exist yet.
        $scope.session = {};
        $scope.session.remember = '';
        $scope.session.username = '';

        if ( $cookies.username ) {
            $scope.session.remember = '1';
            $scope.session.username = $cookies.username;
        }

        $scope.login = function( data ) {
            if ( data.remember ) {
                $cookies.remember = data.remember;
                $cookies.username = data.username;
            }

            var req = $http.post( apiUrl('sessions') , data );

            // Set the user object
            req.success( function( user ) {
                $rootScope.user = user;
                $rootScope.$broadcast( 'user.authorised', user );
                $rootScope.$broadcast( 'menu.refresh' );
            });
        };

        // Watch for the username, whenever it changes and it's valid, we want
        // to save the value in the LoginService service.
        $scope.$watch( 'session.username' , function( newValue ) {
            if ( !angular.isUndefined( newValue ) ) {
                LoginService.email = newValue;
            }
        });
    }

    // Handles forgot password section.
    ForgotSession.$inject = ['$scope', '$http', 'LoginService'];
    function ForgotSession($scope, $http, LoginService) {
        // Initial value.
        $scope.resetData = {};
        $scope.resetData.username = '';

        $scope.reset = function( data ) {
            $http.put( apiUrl( 'users/reset' ) , $scope.resetData );
        };

        // Watch whenever the forgotten attribute is changed, then check that the
        // value of it is 'true', indicating that we're on the password reset form
        // then we will apply the value of the email to what was saved in the sevice.
        $scope.$watch( 'forgotten' , function( newValue ) {
            if ( newValue === true ) {
                $scope.resetData.username = LoginService.email;
            }
        });
    }

})();