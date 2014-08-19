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

        $rootScope.config = {};

        $rootScope.config.localeCode = 'en_GB';

        $rootScope.lang = function(bundle, item) {
            return Language.find(bundle, item);
        };

    }]);

})();
