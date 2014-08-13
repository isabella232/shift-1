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


	});
});
