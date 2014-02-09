(function(){
	'use strict';

	var module = angular.module('shift.library.defaults', ['$ngResource']);
	
	/**
	 * The DefaultRoutes factory object provides routes for the the most common application requests. These include
	 * the index view (list view), create, and update. These routes also point to the most common resource views
	 * based on the package they represent. As a result, every time the Router is called, it must also be provided
	 * with the package it is currently representing.
	 */
	module.provider('DefaultRoute', ['ShiftRouteProvider', function(Router) {
		return function(resource, package) {
			// Register the main list route
			Router.register(resource, {
				templateUrl: resource+'/index.html',
				controller: resource,
				package: package
			});
			
			// Register the create resource route
			Router.register(resource+'/new', {
				templateUrl: resource+'/form.html',
				controller: resource+'.new',
				package: package
			});
			
			// Register the update resource route
			Router.register(resource+'/:id', {
				templateUrl: resource+'/form.html',
				controller: resource+'.edit',
				package: package
			});
		};
	}]);

	module.provider('DefaultResolver', [function() {
		return {
			$get: []
		}
	}]);

	/**
	 * The Resource service extends AngularJS's default $ngResource and makes it more susceptable to modern REST
	 * standards and practises. What this means is, $save will call the appropriate method whether the records exists
	 * or not (PUT for update and POST for create).
	 */
	module.service('Resource', ['$resource', function($resource) {
		return function(url, params, methods) {
			var defaults = {
				update: {method: 'put', isArray: false},
				create: {method: 'post'}
			};
			
			methods = _.extend(defaults, methods);

			var resource = $resource(url, params, methods);

			resource.prototype.$save = function(data, callback) {
				if (!this.id) {
					this.$create(data, callback);
				}
				else {
					this.$update(data, callback);
				}
			};

			return resource;
		};
	}]);
})();

