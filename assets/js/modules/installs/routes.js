(function() {
	'use strict';

	var module = angular.module('shift.installs.routes', ['shift.library.defaults']);

	module.config(['ShiftRouteProvider', function(ShiftRouteProvider) {
		ShiftRouteProvider('installs', 'shift');
	}]);
})();
