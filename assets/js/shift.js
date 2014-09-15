// Required for underscore string module
_.mixin(_.str.exports());

(function() {
	'use strict';

	var module = angular.module('shift', [
        'Shift.Home.Setup',
        'Shift.Home.Controllers',
        'Shift.Library.Core.Services'
    ]);

	module.config(['$locationProvider', function($location) {
        $location.html5Mode(true);
    }]);

    module.run(['$rootScope', 'Language', function($rootScope, Language) {
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

    }]);

})();
