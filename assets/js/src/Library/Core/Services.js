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

		/**
		 * Hydrate the configuration object with a JSON object of configuration options.
		 *
		 * @param configurationOptions
		 */
		this.hydrate = function(configurationOptions) {
			angular.forEach(configurationOptions, function(value, key) {
				self.add(key, value);
			});
		};

		/**
		 * Register a new configuration option and its associated value.
		 *
		 * @param key
		 * @param value
		 */
		this.add = function(key, value) {
			config[key] = value;
		};

		/**
		 * Return a given configuration key's value
		 *
		 * @param key
		 * @returns {*}
		 */
		this.get = function(key) {
			if (angular.isUndefined(config[key])) return null;

			return config[key];
		};

		/**
		 * Returns all configuration options
		 *
		 * @returns {{}}
		 */
		this.all = function() {
			return config;
		};

		/**
		 * Hydrates the Config service with a string that was Base64-encoded.
		 *
		 * @param string
		 */
		this.hydrateBase64 = function(base64String) {
			var configuration = window.atob(base64String);

			try {
				var json = JSON.parse(configuration);

				this.hydrate(json);
			}
			catch(error) {
				console.log(error);
			}
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

    /**
     * This service deals will language and localisation for UI elements. It will find/retrieve
     * a language element/item from the language object stored on the $rootScope.
     */
    module.service('Language', ['$rootScope', function($rootScope) {

        /**
         * Error string to display is language item is NOT found.
         *
         * @type {string}
         */
        this.errorString = "ERROR: ITEM NOT FOUND!";

        /**
         * Find a language item and return it as a string for
         * display on the UI. If no item is found return an
         * easy to spot string so it can be added or corrected.
         *
         * @param {object} language
         * @param {string} local
         * @param {string} bundle
         * @param {string} item
         *
         * @returns {string}
         */
        this.find = function(language, locale, bundle, item) {
            var object = language[bundle].lang[locale];

            return this.getPropertyByString(object, item);
        };

        /**
         * Return a property in object by dot notated string. If the access string is empty,
         * returns the object. Otherwise, keeps going along access path until second last accessor.
         * If that's an object, returns the last object[accessor] value. Otherwise, return the value
         * of this.errorString.
         * .
         * @param {object} obj
         * @param {string} propertyString
         *
         * @returns {string}
         */
        this.getPropertyByString = function(obj, propertyString) {
            if (!propertyString)
                return obj;

            var prop, props = propertyString.split('.');

            for (var i = 0, iLen = props.length - 1; i < iLen; i++) {
                prop = props[i];

                var candidate = obj[prop];
                if (candidate !== undefined) {
                    obj = candidate;
                } else {
                    break;
                }
            }

            var string = obj[props[i]];

            if(angular.isUndefined(string))
                return this.errorString;

            return string;
        };

    }]);

})();
