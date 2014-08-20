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

    describe('service: Language', function() {

        var $rootScope, Language;

        beforeEach(inject(function(_$rootScope_, _Language_) {
            $rootScope = {
                getConfig: function() {
                    return { localeCode: 'en_GB' };
                }
            };
            $rootScope.config = { localeCode: 'en_GB' };
            Language = _Language_;
        }));

        it('should return the correct error string', function() {
            expect(Language.errorString).toBe('ERROR: ITEM NOT FOUND!');
        });

        it('should return the correct language item', function() {
            var language = {
                shift: {
                    lang: {
                        en_GB: {
                            labels: {
                                first_name: 'John',
                                last_name: 'Smith'
                            }
                        }
                    }
                }
            };

            expect(Language.find(language, 'en_GB', 'shift', 'labels.first_name')).toBe('John');
            expect(Language.find(language, 'en_GB', 'shift', 'labels.last_name')).toBe('Smith');
            expect(Language.find(language, 'en_GB', 'shift', 'labels.age')).toBe(Language.errorString);
        });

    });
});
