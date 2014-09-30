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

    /**
     * Handle auth form state
     *
     * @param $scope
     * @constructor
     */
    function Auth($scope) {
        $scope.forgotten = false;

        // Handles toggling the state of the form.
        $scope.toggle = function () {
            $scope.forgotten = !$scope.forgotten;
        }
    }

    NewSession.$inject = ['$scope', 'LoginService'];

    /**
     * Handles the Login form
     *
     * @param $scope
     * @param LoginService
     * @constructor
     */
    function NewSession($scope, LoginService) {

        var vm = this;
        vm.session = LoginService.getSessionData();
        vm.login = login;

        /**
         * Handle logging in a user.
         *
         * @param data
         */
        function login() {
            LoginService.login(vm.session);
        }

        /**
         * Watch for changes to username, and update email property
         * on the LoginService with new value if it's not undefined.
         */
        $scope.$watch( 'session.username' , function(username) {
            LoginService.updateUsername(username)
        });
    }

    ForgotSession.$inject = ['$scope', '$http', 'LoginService'];

    /**
     * Handles the forgotten password form.
     *
     * @param $scope
     * @param $http
     * @param LoginService
     * @constructor
     */
    function ForgotSession($scope, $http, LoginService) {

        var vm = this;
        vm.resetData = { username: ''};
        vm.reset = reset;

        function reset() {
            // Watch for the username, whenever it changes and it's valid, we want
            // to save the value in the LoginService service.
            // Handles the creation of new session
            $http.put( apiUrl( 'users/reset' ) , vm.resetData );
        }

        // Watch whenever the forgotten attribute is changed, then check that the
        // value of it is 'true', indicating that we're on the password reset form
        // then we will apply the value of the email to what was saved in the service.
        $scope.$watch( 'forgotten' , function( newValue ) {
            if ( newValue === true ) {
                vm.resetData.username = LoginService.email;
            }
        });
    }


})();