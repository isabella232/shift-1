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
});
