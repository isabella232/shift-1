(function() {
	'use strict';

	var module = angular.module('Shift.Library.Core.View', []);

	module.provider('View', function() {
		return {
			$get: ['Config', function(Config) {
				return {
					path: function(template, pkg) {
						if (angular.isUndefined(pkg)) {
							var chunks = ['tpl'];
						}
						else {
							var chunks = ['packages', pkg, 'tpl'];
						}

						chunks.push(Config.get('app.skin'));
						chunks.push(template);

						return '/' + chunks.join('/');;
					}
				};
			}]
		};
	});
})();
