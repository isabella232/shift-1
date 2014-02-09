(function() {
	'use strict';

	var module = angular.module('shift.library.core', []);

	/**
	 * Router
	 *
	 * This is used by the Shift and other libraries to help register routes that are then later used
	 * by angular to match routes with controllers. Arguments provided should be identical to the routeProvider
	 * used in angularjs. This is simply a register to ensure we can define routes across modulse, and have our
	 * main module (app) have them executed.
	 *
	 * @author Kirk Bushell
	 * @date 27th March 2013
	 */
	module.provider('ShiftRoute', function() {
		return {
			$get: function() {
				var routes = [];
				var order = 0;
				
				/**
				 * Registers a route and stores it on the internal routes variable.
				 */
				this.register = function(route, options) {
					var thisOptions = clone(options);
					var url = this.routeUrl(route);

					thisOptions.url = url;
					
					// push the templateurl option through our viewPath code
					if (thisOptions.templateUrl) thisOptions.templateUrl = this.viewPath(thisOptions);
					
					if (typeof thisOptions.order == 'undefined') {
						thisOptions.order = order;
						order = order + 10;
					}

					routes.push(thisOptions);
				};
				
				/**
				 * Returns the routes that have been registered.
				 */
				this.get = function() {
					return this.sortItems(routes);
				};

				/**
				 * Sorts routes based on their order property and returns the ordered routes.
				 * 
				 * @return array
				 */
				this.sortItems = function(routes) {
					return _.sortBy(routes, function(route) {
						return route.order;
					});
				};
				
				/**
				 * Determines the actual URL (based on bootstrap pathing prefix) which is used for the route.
				 *
				 * @return string
				 */
				this.routeUrl = function(url, baseUrl) {
					baseUrl = (!baseUrl) ? config.app.base : config.app.url;
					if (url.substr(-1, 1) == '/') url = url.substr(0, url.length-1);
					url = [config.app.base, url].join('/');
					
					return url;
				};
				
				/**
				 * Looks at the provided options (should contain the property: temkplateUrl) and determines where a
				 * view path may be found.
				 * 
				 * @param object options
				 * @return string
				 */
				this.viewPath = function(options) {
					if (options.bundle) {
						return viewPath(options.templateUrl, options.bundle);
					}
					
					return viewPath(options.templateUrl);
				};
				
				/*
					Function: init
					
					Based on all registered routes, Router will now register them all with angular. This should be called once the app is ready.
				*/
				this.init = function($routeProvider) {
					angular.forEach(this.get() , function(route) {
						$routeProvider.when(route.url, route);
					});
				};
			}
		}
	});
})();
