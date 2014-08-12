'use strict';

// A little configuration required for setting up the underscore.string module
_.mixin(_.str.exports());

// Now let's begin.
(function() {
	var dependencies = [];

	var module = angular.module('Shift', dependencies);

	module.config([function() {
//		Router.register('404', {
//			templateUrl: '404.html',
//			bundle: 'shift'
//		});
	}]);
})();
