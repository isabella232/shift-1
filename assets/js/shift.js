// Required for underscore string module
_.mixin(_.str.exports());

(function() {
	'use strict';

	var dependencies = [
		'Shift.Home',
		'Shift.Library.Core.Services'
	];

	angular
		.module('Shift', dependencies)
		.config(Configuration)
	    .run(Runner);

	Configuration.$inject = ['$locationProvider'];

	function Configuration($locationProvider) {
		$locationProvider.html5Mode(true);
	}

	Runner.$inject = ['$rootScope', 'Language'];

	function Runner($rootScope, Language) {
		$rootScope.language = window.language;

		// These config setting will be set dynamically either based upon
		// user or installation settings.
		$rootScope.config = {};
		$rootScope.config.localeCode = 'en_GB';

		/**
		 * Return a localised string for a specific bundle language item.
		 *
		 * @param {string} bundle
		 * @param {string} item
		 * @returns {string}
		 */
		$rootScope.lang = function(bundle, item) {
			var locales = [
				'',                             // User specific locale code
				$rootScope.config.localeCode,   // Installation specific locale code
				'en_GB',                        // Base/default locale code
			];
			return Language.find($rootScope.language, locales, bundle, item);
		};
	}
})();
