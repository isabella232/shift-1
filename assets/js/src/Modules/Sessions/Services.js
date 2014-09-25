(function () {
    'use strict';

    angular
        .module('Shift.Sessions.Services', [])
        .service('LoginService', LoginService);

    function LoginService() {
        var service = { email: '' };

        return service;
    }
})();