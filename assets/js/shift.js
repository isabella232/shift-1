// Required for underscore string module
_.mixin(_.str.exports());

(function() {
	'use strict';

	var module = angular.module('shift', [
        'Shift.Home.Setup',
        'Shift.Home.Controllers'
    ]);

	module.config(['$locationProvider', function($location) {
        $location.html5Mode(true);
    }]);

})();
