(function() {
    'use strict';

    angular
	    .module('Shift.Home', ['ngRoute', 'Shift.Home.Controllers'])
	    .config(['$routeProvider', function($routeProvider) {

	        // The Shift Router isn't working yet. As a test user ngRoute
	        /*ShiftRoute('/', {
	            templateUrl: '/packages/tectonic/shift/views/home.html',
	            controller: 'Shift.Home'
	        });*/

	        $routeProvider.when('/', {
	            templateUrl: '/packages/tectonic/shift/views/home.html',
	            controller: 'Shift.Home'
	        });

            $routeProvider.when('/test', {
                templateUrl: '/packages/tectonic/shift/views/test.html',
                controller: 'Shift.Test'
            })
	    }]);
})();