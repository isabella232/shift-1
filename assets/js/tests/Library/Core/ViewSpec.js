'use strict';

describe('provider: ViewProvider', function() {
	var viewProvider, $mockConfig;

	$mockConfig = {};
	$mockConfig.get = jasmine.createSpy('get').andReturn('tectonic');

	beforeEach(function() {
		module('Shift.Library.Core.View', function($provide) {
			$provide.value('Config', $mockConfig);
		});

		inject(['View', function(_viewProvider_) {
			viewProvider = _viewProvider_;
		}]);
	});

	it('should retrieve a configuration value for the application skin', function() {
		viewProvider.path('index.html');

		expect($mockConfig.get).toHaveBeenCalledWith('app.skin', 'tectonic');
	});

	it('should provide a base template location when no package is provided', function() {
		var path = viewProvider.path('index.html');

		expect(path).toEqual('/tpl/tectonic/index.html');
	});

	it('should provide a template location when a package is provided', function() {
		var path = viewProvider.path('index.html', 'tectonic/shift');

		expect(path).toEqual('/packages/tectonic/shift/tpl/tectonic/index.html');
	});
});
