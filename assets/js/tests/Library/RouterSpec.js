'use strict';

describe('provider: ShiftRouteProvider', function() {
	var shiftRouteProvider;

	beforeEach(module('Shift.Library.Router'));

	beforeEach(inject(['ShiftRoute', function($s) {
		shiftRouteProvider = $s;
	}]));

	it('should be able to register new routes', function() {
		shiftRouteProvider.register('path', {});

		var routes = shiftRouteProvider.get();

		expect(routes).toEqual([{url: '/path', order: 0}]);
	});

	it('get should return registered routes', function() {
		expect(shiftRouteProvider.get()).toEqual([]);
	});

	it('sorting should return items in numerical order', function() {
		var routes = [
			{order: 1},
			{order: 0}
		];

		var sortedRoutes = shiftRouteProvider.sortItems(routes);

		expect(sortedRoutes[0]).toEqual(routes[1]);
		expect(sortedRoutes[1]).toEqual(routes[0]);
	});
});
