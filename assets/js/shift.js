// Required for underscore string module
_.mixin(_.str.exports());

(function() {
	'use strict';

	var module = angular.module('shift', [
        'Shift.Library.Core.Services',
        'Shift.Library.DefaultControllers',
        'Shift.Library.Defaults',
        'Shift.Library.Router',
        'Shift.Home.Setup',
        'Shift.Home.Controllers'
    ]);

	module.config(['$locationProvider', 'ShiftRouteProvider', function($location, Router) {
//        $location.html5Mode(true);
//
//        Route.init();
	}]);
})();
