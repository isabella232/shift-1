'use strict';

describe('service: Config', function() {
	var Config;

	beforeEach(module('Shift.Library.Core.Services'));

	beforeEach(inject(['Config', function($c) {
		Config = $c;
	}]));

	it('should add new configuration keys and values', function() {
		expect(Config.add('something', 'value')).toBeUndefined();
		expect(Config.get('something')).toEqual('value');
	});

	it('should be able to hydrate the configuration with a json object of options', function() {
		var options = {
			test: 'value',
			config: 'option'
		};

		Config.hydrate(options);

		expect(Config.get('test')).toEqual('value');
		expect(Config.get('config')).toEqual('option');
	});

	it('should be able to return all options', function() {
		var options = {
			testing: 'all',
			options: 'hydrated'
		};

		Config.hydrate(options);

		expect(Config.all()).toEqual(options);
	});
});
