(function() {
	'use strict';

	var module = angular.module('Shift.Accounts.Controllers', ['shift.library.defaults']);

	module.controller('shift.accounts', [
		'$rootScope',
		'$scope',
		'$filter',
		'Seeker',
		'Deletism',
		'Filter',
		'Account',
		DefaultControllers.index
	]);

	module.controller('shift.accounts.new', [
		'$rootScope',
		'$scope',
		'$filter',
		'Account',
		DefaultControllers.create
	]);

	module.controller('shift.accounts.edit', [
		'$rootScope',
		'$scope',
		'$filter',
		'install',
		DefaultControllers.update
	]);
})();
