(function () {
    'use strict';

    var dependencies = [
        'Shift.Fields.Services'
    ];

    angular
        .module('Shift.Users.Controllers', dependencies)
        .controller('Users.Register', RegisterUser)
        .controller('Users.New', NewUser)
        .controller('Users.Edit', EditUser);

    RegisterUser.$inject = ['User', 'Fields'];
    function RegisterUser(User, Fields){
        var vm = this;

        vm.form = 'registerUser';
        vm.customfields = Fields.getUserRegistrationFields();
        vm.user = new User;

        vm.save = function(){};


        $scope.save = function() {
            $scope.user = CustomFields.save( 'user', $scope.user );

            var req = $http.post( routeUrl( 'users/register' ), $scope.user );

            // When the request is successful, log the user in and send them to the dashboard
            req.success( function( user ) {
                $rootScope.user = user;

                $rootScope.$broadcast( 'menu.refresh' );
                $scope.go( 'dashboard' );
            });

        };

        /**
         * Based on the registration being enabled and the the user being
         * within the opening/closing dates, we determine whether or not
         * to display the registration form.
         *
         * @return {boolean}
         */
        $scope.registrationsEnabled = function() {
            var registration = settings['app.site.registrations'];

            return registration ? true : false;
        }
    }

    function Users(){}
    function NewUser(){}
    function EditUser(){}

})();