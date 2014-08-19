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
         * @param bundle
         * @param item
         * @returns {string}
         */
        this.find = function(bundle, item) {
            var locale = this.getLocale();
            var object = $rootScope.language[bundle].lang[locale];

            return this.getPropertyByString(object, item);
        };

        /**
         * Return a property in object by dot notated string. If the access string is empty,
         * returns the object. Otherwise, keeps going along access path until second last accessor.
         * If that's an object, returns the last object[accessor] value. Otherwise, return the value
         * of this.errorString.
         * .
         * @param obj
         * @param propertyString
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

        /**
         * Return the current locale code in use. E.g. 'en_GB'.
         *
         * @returns {string}
         */
        this.getLocale = function() {
            return $rootScope.config.localeCode;
        };

    }]);

})();
