(function(){
	'use strict';

	var module = angular.module('Shift.Library.Defaults', ['ngResource', 'Shift.Library.Router']);
	
	/**
	 * The DefaultRoutes factory object provides routes for the the most common application requests. These include
	 * the index view (list view), create, and update. These routes also point to the most common resource views
	 * based on the package they represent. As a result, every time the Router is called, it must also be provided
	 * with the package it is currently representing.
	 */
	module.provider('DefaultRoute', ['ShiftRouteProvider', function(Router) {
		return function(resource, pack) {
			// Register the main list route
			Router.register(resource, {
				templateUrl: resource+'/index.html',
				controller: resource,
				package: pack
			});
			
			// Register the create resource route
			Router.register(resource+'/new', {
				templateUrl: resource+'/form.html',
				controller: resource+'.new',
				package: pack
			});

			// Register the update resource route
			Router.register(resource+'/:id', {
				templateUrl: resource+'/form.html',
				controller: resource+'.edit',
				package: pack
			});
		};
	}]);

	module.provider('DefaultResolver', [function() {
		return {
			$get: []
		}
	}]);
})();

