(function() {
	'use strict';

	var dependencies = [
		'shift.users',
		'shift.roles',
	];

	var module = angular.module('shift', dependencies);

	module.config(['$locationProvider', 'ShiftRouteProvider' function($location, Router) {
		$location.html5Mode(true);

		Router.register('404', {
			templateUrl: '404.html',
			bundle: 'shift'
		});
	}]);
})();
