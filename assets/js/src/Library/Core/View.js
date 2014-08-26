(function() {
	'use strict';

	var module = angular.module('Shift.Library.Core.View', []);

	/**
	 * The ViewProvider helps the application with being able to retrieve templates from the correct
	 * locations. Packages each have their own view location that follows the normal Laravel package
	 * assets, see: http://laravel.com/docs/packages#package-assets
	 *
	 * The provider also depends on the Config service - as it needs to know which skin is currently
	 * in use (defaulting to tectonic).
	 */
	module.provider('View', function() {
		return {
			$get: ['Config', function(Config) {
				return {
					/**
					 * When requiring a path to a template, it's important to remember that template
					 * is required, and pkg is optional. If no pkg is provided, then the path returned
					 * will be to the default tpl location, which is simply public/tpl within the
					 * document root of the application.
					 *
					 * @param template
					 * @param pkg
					 * @returns {string}
					 */
					path: function(template, pkg) {
						if (angular.isUndefined(pkg)) {
							var chunks = ['tpl'];
						}
						else {
							var chunks = ['packages', pkg, 'tpl'];
						}

						chunks.push(Config.get('app.skin', 'tectonic'));
						chunks.push(template);

						return '/' + chunks.join('/');;
					}
				};
			}]
		};
	});
})();
