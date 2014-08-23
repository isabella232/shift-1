'use strict';

describe('module: Shift.Library.Core.Services', function() {
	beforeEach(module('Shift.Library.Core.Services'));

	describe('service: Config', function() {
		var Config;

		beforeEach(inject(function(_Config_) {
			Config = _Config_;
		}));

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

	describe('service: DateTimeFormats', function() {
		var DateTimeFormats;

		beforeEach(inject(function(_DateTimeFormats_) {
			DateTimeFormats = _DateTimeFormats_;
		}));

		it('should have the correct date format', function() {
			expect(DateTimeFormats.dateFormat).toBe('YYYY-MM-DD');
		});

		it('should have the correct time format', function() {
			expect(DateTimeFormats.timeFormat).toBe('HH:mm:ss');
		});

		it('should have the correct server datetime format', function() {
			expect(DateTimeFormats.serverFormat).toBe('YYYY-MM-DD HH:mm:ss');
		});

		it('should have the correct server datetime format', function() {
			expect(DateTimeFormats.clientFormat).toBe('YYYY-MM-DD HH:mm');
		});
	});

	describe('service: Resource', function() {
		var Resource, $mockRestangular;
		
		beforeEach(function() {
			$mockRestangular = function() {};

			module('Shift.Library.Core.Services', function($provide) {
				$provide.value('Restangular', $mockRestangular);
			});

			inject(function(_Resource_) {
				Resource = _Resource_;
			});
		});

		it('should instantiate a restangular resource', function() {
			$mockRestangular.all = jasmine.createSpy('all');

			new Resource('users');

			expect($mockRestangular.all).toHaveBeenCalled();
		});

		describe('methods', function() {
			var $mockServiceModel = {};

			beforeEach(function() {
				$mockRestangular.all = jasmine.createSpy('all').andReturn($mockServiceModel);
			});

			it('should create an item', function() {
				$mockServiceModel.post = jasmine.createSpy('post');

				var user = new Resource('users');
				var params = {name: 'Kirk'};

				user.create(params);

				expect($mockServiceModel.post).toHaveBeenCalledWith(params);
			});

			it('should destroy an item', function() {
				var item = {remove: function(){}};
				var user = new Resource('users');

				spyOn(item, 'remove');

				user.destroy(item);

				expect(item.remove).toHaveBeenCalled();
			});

			it('should get an existing item', function() {
				$mockServiceModel.get = jasmine.createSpy('get');

				var resource = new Resource('users');

				resource.get(1);

				expect($mockServiceModel.get).toHaveBeenCalledWith(1);
			});

			it('should get all items', function() {
				$mockServiceModel.getList = jasmine.createSpy('getList');

				var resource = new Resource('users');

				resource.all();

				expect($mockServiceModel.getList).toHaveBeenCalled();
			});

			it('should update an existing item', function() {
				var item = {put: function(){}};
				var user = new Resource('users');

				spyOn(item, 'put');
				
				user.update(item);

				expect(item.put).toHaveBeenCalled();
			});

			it('should save a new item', function() {
				$mockServiceModel.post = jasmine.createSpy('post');

				var resource = new Resource('users');
				var params = {name: 'Kirk'};

				resource.save(params);

				expect($mockServiceModel.post).toHaveBeenCalledWith(params);
			});

			it('should save an existing item', function() {
				var item = {id: 1, name: 'Kirk', put: function(){}};
				var resource = new Resource('users');

				spyOn(item, 'put');

				resource.save(item);

				expect(item.put).toHaveBeenCalled();
			});
		});
	});
});
