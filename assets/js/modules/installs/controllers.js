(function() {
	'use strict';

	var module = angular.module('shift.installs.controllers', ['shift.library.defaults']);

	module.controller('shift.installs', [
		'$rootScope',
		'$scope',
		'$filter',
		'Seeker',
		'Deletism',
		'Filter',
		'Install',
		DefaultControllers.index
	]);

	module.controller('shift.installs.new', [
		'$rootScope',
		'$scope',
		'$filter',
		'Install',
		DefaultControllers.create
	]);

	module.controller('shift.installs.edit', [
		'$rootScope',
		'$scope',
		'$filter',
		'install',
		DefaultControllers.update
	]);
})();