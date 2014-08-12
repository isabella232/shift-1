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
})();
