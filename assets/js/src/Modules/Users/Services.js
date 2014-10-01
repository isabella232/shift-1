(function () {
    'use strict';

    var dependencies = [];

    angular
        .module('Shift.Users.Services', dependencies)
        .factory('User', User);

    User.$inject = ['$resource'];

    function User($resource) {
        return $resource( apiUrl( 'users/:id', true ), { id: '@id' } );
    };

})();