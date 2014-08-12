(function() {
	'use strict';

	var module = angular.module('Shift.Library.Core.Services', ['ngResource']);

	/**
	 * The Config service simply manages all configuration options for a given application,
	 * and the current account.
	 */
	module.service('Config', [function() {
		var config = {};
		var self = this;

		// Hydrate the configuration service with the required options
		this.hydrate = function(configurationOptions) {
			angular.forEach(configurationOptions, function(value, key) {
				self.add(key, value);
			});
		};

		// Register a new configuration option and its associated value
		this.add = function(key, value) {
			config[key] = value;
		};

		// Return a given configuration key's value
		this.get = function(key) {
			if (angular.isUndefined(config[key])) return null;

			return config[key];
		};

		// Returns all configuration options
		this.all = function() {
			return config;
		};
	}]);

	/**
	 * The Resource service extends AngularJS' default $ngResource and makes it more compliant with modern RESTful
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

			resource.lower = function() {
				return this.name.toLowerCase();
			};

			resource.lowerPlural = function() {
				return this.lower().pluralize();
			};

			return resource;
		};
	}]);
})();
