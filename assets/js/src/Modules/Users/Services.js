(function () {
    'use strict';

    var dependencies = [];

    angular
        .module('Shift.Users.Services', dependencies)
        .factory('User', User)
        .service('RegistrationService', RegistrationService);

    /**
     * @type {string[]}
     */
    User.$inject = ['$resource'];

    /**
     * User service for getting a user.
     *
     * @param $resource
     * @returns {Object}
     * @constructor
     */
    function User($resource) {
        return $resource( apiUrl( 'users/:id', true ), { id: '@id' } );
    }

    /**
     * @type {string[]}
     */
    RegistrationService.$inject = ['$rootScope', '$http'];

    /**
     * Registration service
     *
     * @param $rootScope
     * @param $http
     * @returns {{register: register}}
     * @constructor
     */
    function RegistrationService($rootScope, $http) {
        var service = {
            register: register
        };

        function register(user) {
            return $http.post(apiUrl('users'), user).success(function(response) {
                $rootScope.user = response.data;
                $rootScope.$broadcast('menu.refresh');
            });
        }

        return service;
    }

})();