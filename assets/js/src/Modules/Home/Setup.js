(function() {
    'use strict';

    var module = angular.module('Shift.Home.Setup', ['ngRoute']); // 'Shift.Library.Router'

    module.config(['$routeProvider', function($routeProvider) {

        // The Shift Router isn't working yet. As a test user ngRoute
        /*ShiftRoute('/', {
            templateUrl: '/packages/tectonic/shift/views/home.html',
            controller: 'Shift.Home'
        });*/

        $routeProvider.when('/', {
            templateUrl: '/packages/tectonic/shift/views/home.html',
            controller: 'Shift.Home'
        });
    }]);

})();