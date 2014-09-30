(function () {
    'use strict';

    var dependencies = [];

    angular
        .module('Shift.Users.Services', dependencies)
        .factory('User', User);

    User.$inject = ['$resource'];
    function User($resource) {
        return $resource( routeUrl( 'users/:id', true ), { id: '@id' } );
    };

})();