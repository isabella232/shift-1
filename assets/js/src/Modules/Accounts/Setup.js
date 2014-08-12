(function() {
	'use strict';

	var module = angular.module('Shift.Accounts.Setup', ['Shift.Library.Defaults']);

	module.config(['ShiftRouteProvider', function(ShiftRouteProvider) {
		ShiftRouteProvider('accounts', 'shift');
	}]);
})();
