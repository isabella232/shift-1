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

    RegisterUser.$inject = ['User', 'RegistrationService', 'Fields'];
    function RegisterUser(User, RegistrationService, Fields){
        var vm = this;

        vm.form = 'registerUser';
        //vm.customfields = Fields.getUserRegistrationFields();
        vm.registrationsEnabled = registrationsEnabled;
        vm.user = new User;
        vm.register = register;

        function register() {
            RegistrationService.register(vm.user);
        }

        /**
         * Based on the registration being enabled and the the user being
         * within the opening/closing dates, we determine whether or not
         * to display the registration form.
         *
         * @return {Boolean}
         */
        function registrationsEnabled() {
            var registration = settings['app.site.registrations'];

            return registration ? true : false;
        }
    }

    function Users(){}
    function NewUser(){}
    function EditUser(){}

})();