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

    NewSession.$inject = ['$scope', 'LoginService'];
    function NewSession($scope, LoginService) {

        $scope.session = LoginService.getSessionData();

        /**
         * Handle logging in a user.
         *
         * @param data
         */
        $scope.login = function( data ) {
            LoginService.login(data);
        };

        /**
         * Watch for changes to username, and update email property
         * on the LoginService with new value if it's not undefined.
         */
        $scope.$watch( 'session.username' , function(username) {
            LoginService.updateUsername(username)
        });
    }

    // Handles forgot password section.
    ForgotSession.$inject = ['$scope', '$http', 'LoginService'];
    function ForgotSession($scope, $http, LoginService) {
        // Initial value.
        $scope.resetData = {};

        $scope.resetData.username = '';
        $scope.reset = function( data ) {

            // Watch for the username, whenever it changes and it's valid, we want
            // to save the value in the LoginService service.
            // Handles the creation of new session
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