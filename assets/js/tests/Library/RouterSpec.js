'use strict';

describe('provider: ShiftRouteProvider', function() {
	var Config,
		shiftRouteProvider;

	beforeEach(function() {
		var app = angular.module('Shift.Library.Router');

		app.config(function(_ShiftRouteProvider_) {
			Config = jasmine.createSpyObj('Config', ['get']);

			shiftRouteProvider = _ShiftRouteProvider_.$get[1](Config);
		});

		module('Shift.Library.Router');
		inject();
	});

	describe('method: register', function() {
		it('should register new routes', function() {
			shiftRouteProvider.register('path', {});

			var routes = shiftRouteProvider.get();

			expect(routes).toEqual([{url: '/path', order: 0}]);
		});
	});

	it('should return registered routes', function() {
		expect(shiftRouteProvider.get()).toEqual([]);
	});

});
