'use strict';

describe('module: Shift.Core.Filters', function() {
	var $filter;

	beforeEach(module('Shift.Library.Core.Filters'));

	beforeEach(inject(function(_$filter_) {
		$filter = _$filter_;
	}));

	describe('filter: ucfirst', function() {
		it('should exist', function() {
			expect($filter('ucfirst')).not.toBe(null);
		});

		it('should lowercase and capitalize a string', function() {
			var string = 'Some thing Yeah';

			expect($filter('ucfirst')(string)).toEqual('Some thing yeah');
		});
	});

	describe('filter: markdown', function() {
		it('should exist', function() {
			expect($filter('markdown')).not.toBe(null);
		});

		it('should convert a markdown text string to HTML', function() {
			var string = '## This is markdown';

			expect($filter('markdown')(string)).toEqual('<h2>This is markdown</h2>');
		});
	});

	describe('filter: mandatory', function() {
		it('should exist', function() {
			expect($filter('mandatory')).not.toBe(null);
		});

		it('should not suffix the text if no parameter is provided', function() {
			expect($filter('mandatory')('input')).toEqual('input');
		});

		it('should not suffix the text if the mandatory parameter is false', function() {
			expect($filter('mandatory')('input', false)).toEqual('input');
		});

		it('should suffix the mandatory text when required', function() {
			expect($filter('mandatory')('input', true)).toEqual('input <span class="required">*</span>');
		});
	});

	describe('filter: localDate', function() {
		it('should exist', function() {
			expect($filter('localDate')).not.toBe(null);
		});

		it('should format a given server date, to a local client date format', function() {
			expect($filter('localDate')('1982-12-09 00:54:13')).toBe('1982-12-09 00:54');
		});

		it('should return any value that is falsy', function() {
			expect($filter('localDate')(null)).toBe(null);
		});
	});

	describe('filter: humanize', function() {
		it('should exist', function() {
			expect($filter('humanize')).not.toBe(null);
		});

		it('should format a coded string into a humanized format', function() {
			expect($filter('humanize')('whyHello!')).toBe('Why hello!');
			expect($filter('humanize')('why-hello!')).toBe('Why hello!');
			expect($filter('humanize')('why hello!')).toBe('Why hello!');
		});
	});

	describe('filter: default', function() {
		it('should exist', function() {
			expect($filter('default')).not.toBe(null);
		});

		it('should return a default value if a falsy value is provided', function() {
			expect($filter('default')(false, 'Default value')).toBe('Default value');
			expect($filter('default')(null, 'No')).toBe('No');
			expect($filter('default')(0, 'Zero')).toBe('Zero');
		});
	});

	describe('filter: niceDate', function() {
		it('should exist', function() {
			expect($filter('niceDate')).not.toBe(null);
		});

		it('should return an undefined value if a null input is provided', function() {
			expect($filter('niceDate')(null)).toBeUndefined();
		});

		it('should return a relative value when requested', function() {
			var thisMoment = moment().startOf('hour').utc();
			var thatMoment = moment().startOf('hour').utc();

			expect($filter('niceDate')(thisMoment.format('YYYY-MM-DD HH:mm:ss'))).toEqual(thatMoment.fromNow());
		});

		it('should return a specifically formatted date when requested', function() {
			var thisMoment = moment().startOf('hour').utc();
			var thatMoment = moment().startOf('hour').utc();

			expect($filter('niceDate')(thisMoment.format('YYYY-MM-DD HH:mm:ss'), false, 'YYYY')).toEqual(thatMoment.format('YYYY'));
		});
	});

	describe('filter: commonDate', function() {
		it('should exist', function() {
			expect($filter('commonDate')).not.toBe(null);
		});

		it('should return a date-based common format', function() {
			expect($filter('commonDate')('2012-12-11 07:56:23')).toEqual('7am, 11th December');
		});
	});

	describe('filter: filesize', function() {
		it('should exist', function() {
			expect($filter('filesize')).not.toBe(null);
		});

		it('should convert the value to the correct number of kilobytes', function() {
			expect($filter('filesize')(1057687, 'kb')).toEqual('1033 KB');
		});

		it('should convert the value to the correct number of megabytes', function() {
			expect($filter('filesize')(12354123123, 'mb')).toEqual('11782 MB');
		});

		it('should convert the value to the correct number of gigabytes', function() {
			expect($filter('filesize')(1057687, 'gb')).toEqual('0 GB');
		});

		it('should respect the precision requirement', function() {
			expect($filter('filesize')(10457757687, 'gb', 2)).toEqual('9.74 GB');
		});
	});

	describe('filter: extension', function() {
		it('should exist', function() {
			expect($filter('extension')).not.toBe(null);
		});

		it('should return the file extension from a string', function() {
			expect($filter('extension')('filename.jpeg')).toEqual('jpeg');
		});

		it('should return null if an extension is not found', function() {
			expect($filter('extension')('filename')).toBe(null);
		});
	});

	describe('filter: activeIndicator', function() {
		it('should exist', function() {
			expect($filter('activeIndicator')).not.toBe(null);
		});

		it('should show a truthy value as active', function() {
			expect($filter('activeIndicator')(true)).toEqual('Active');
		});

		it('should show a falsey value as inactive', function() {
			expect($filter('activeIndicator')(0)).toEqual('Inactive');
		});
	});

	describe('filter: enabledIndicator', function() {
		it('should exist', function() {
			expect($filter('enabledIndicator')).not.toBe(null);
		});

		it('should show a truthy value as the selected string', function() {
			expect($filter('enabledIndicator')(1, 'Yeah!', 'Na :(')).toEqual('Yeah!');
		});

		it('should show a falsey value as the selected string', function() {
			expect($filter('enabledIndicator')(0, 'Yes', 'No')).toEqual('No');
		});

		it('should show the default "Enabled" string if no requested string is provided', function() {
			expect($filter('enabledIndicator')(1)).toEqual('Enabled');
		});

		it('should show the default "Disabled" string if no requested string is provided', function() {
			expect($filter('enabledIndicator')(0)).toEqual('Disabled');
		});
	});
});
