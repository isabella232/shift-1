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
		function Resource(serviceName) {
			this.serviceModel = Restangular.all(serviceName);
		}

		/**
		 * Create an item based on the parameters provided.
		 * 
		 * @param params
		 * @returns {*}
		 */
		Resource.prototype.create = function(params) {
			return this.serviceModel.post(params);
		};
		
		/**
		 * Destroy a specific item.
		 * 
		 * @param item
		 * @returns {*}
		 */
		Resource.prototype.destroy = function(item) {
			return item.remove();
		};

		/**
		 * Return a single item based on the id provided.
		 * 
		 * @param id
		 * @returns {*|Array|Mixed|promise}
		 */
		Resource.prototype.get = function(id) {
			return this.serviceModel.get(id);
		};

		/**
		 * Returns all items, without pagination.
		 *
		 * @returns {*}
		 */
		Resource.prototype.all = function() {
			return this.serviceModel.getList();
		};

		/**
		 * Update a specific item.
		 *
		 * @param item
		 * @returns {*}
		 */
		Resource.prototype.update = function(item) {
			return item.put();
		};

		/**
		 * Save an existing item. The difference between this and say, create/update, is that
		 * save has a little logic tied in. If an id is present on the object, then it will
		 * do an update call. If there is no id, it will do a create call.
		 *
		 * @param item
		 * @returns {*}
		 */
		Resource.prototype.save = function(item) {
			if (angular.isUndefined(item.id)) {
				return this.create(item);
			}
			else {
				return this.update(item);
			}
		};

		return Resource;
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
