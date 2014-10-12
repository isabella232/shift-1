(function() {
    'use strict';

    angular
	    .module('Shift.Home', ['ngRoute', 'Shift.Home.Controllers'])
	    .config(Configuration);

	/**
	 * Sets up the required routes and configuration for the Home module.
	 */
	Configuration.$inject = ['$routeProvider'];
	function Configuration($routeProvider) {
        $routeProvider.when('/', {
            templateUrl: '/packages/tectonic/shift/views/home.html',
            controller: 'Shift.Home'
        });
    };
})();
