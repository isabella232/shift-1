(function() {
	'use strict';

	var module = angular.module('Shift.Library.Core.Services', ['restangular']);

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
	 * The Resource factory service creates a more involved resource object that can be used and extended by children,
	 * without having to hack in weird or strange endpoint implementations on the AngularJS ngResource module.
	 *
	 * The Resource service extends AngularJS' default $ngResource and makes it more compliant with modern RESTful
	 * standards and practises. What this means is, $save will call the appropriate method whether the records exists
	 * or not (PUT for update and POST for create).
	 */
	module.factory('Resource', ['Restangular', function(Restangular) {
		function Model(serviceName) {
			this.serviceModel = Restangular.all(serviceName);
		}

		Model.prototype.create = function(item) {
			return this.serviceModel.post(item);
		};

		Model.prototype.destroy = function(item) {
			return item.remove();
		};

		Model.prototype.get = function(id) {
			return this.serviceModel.get(id);
		};

		Model.prototype.all = function() {
			return this.serviceModel.getList();
		};

		Model.prototype.update = function(item) {
			return item.put();
		};

		Model.prototype.save = function(item) {
			if (angular.isUndefined(item.id)) {
				return this.create(item);
			}
			else {
				return this.update(item);
			}
		};

		return Model;
	}]);

	/**
	 * This is a simple service that simply returns the relevant date time formats for both
	 * the client, and the server. It's used mainly for doing date-time operations using
	 * a library such as moment.js.
	 */
	module.service('DateTimeFormats', [function() {
		this.dateFormat   = 'YYYY-MM-DD';
		this.timeFormat   = 'HH:mm:ss';
		this.serverFormat = 'YYYY-MM-DD HH:mm:ss';
		this.clientFormat = 'YYYY-MM-DD HH:mm';
	}]);
})();
