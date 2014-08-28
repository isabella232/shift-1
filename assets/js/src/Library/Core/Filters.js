(function() {
	'use strict';

	var module = angular.module('Shift.Library.Core.Filters', ['Shift.Library.Core.Services']);

	/**
	 * Identical to PHP's ucfirst function - converts the entire string to a lowercase version,
	 * and then capitalizes the first letter of the phrase.
	 *
	 * @param string input
	 * @return string
	 */
	module.filter('ucfirst', ['$filter', function($filter) {
		return function(input) {
			var lc = $filter('lowercase')(input);
			
			return _.capitalize(lc);
		};
	}]);

	/**
	 * The markdown filter takes a string that has been formatted with markdown text, and
	 * returns that value, converting the markdown to the appropriate HTML.
	 *
	 * @param string input
	 * @return string (as HTML)
	 */
	module.filter('markdown', function() {
		return function(input) {
			if (input) {
				var converter = new Markdown.Converter();

				return converter.makeHtml(input);
			}

			return input;
		};
	});

	/**
	 * The mandatory filter creates a small HTML snippet based on whether or not the second parameter is true.
	 *
	 * @param string input
	 * @param boolean mandatory
	 * @return string
	 */
	module.filter('mandatory', function() {
		var span = ' <span class="required">*</span>';

		return function(input, mandatory) {
			if (mandatory === true) {
				return input + span;
			}

			return input;
		};
	});

	// Filter for formatting dates to a local-friendly format, for technical date formats.
	module.filter('localDate', function(DateTimeFormats) {
		return function(datetime) {
			if (datetime) {
				return moment.utc(datetime, DateTimeFormats.serverFormat, 'en').local().format(DateTimeFormats.clientFormat);
			}

			return datetime;
		};
	});

	/**
	 * Humanifies a given string. Most resources throughout the application are represented like so: SomeResource.
	 * This filter simply takes that string and injects spaces where necessary.
	 *
	 * @param string input
	 * @return string
	 */
	module.filter('humanize', [function() {
		return function(input) {
			return _.humanize(input);
		};
	}]);

	/**
	 * Sets a default value for a given input.
	 *
	 * @param mixed input
	 * @param string defaultValue
	 * @return string
	 */
	module.filter('default', [function() {
		return function(input, defaultValue) {
			if (!input) return defaultValue;
			
			return input;
		};
	}]);


	/**
	 * Filter to nicely format dateTime using moment.js
	 *
	 * Takes a single boolean parameter to determine whether to return
	 * a relative time (eg. 2 days ago) or a date time string.
	 *
	 * @param boolean relative
	 * @return string
	 */
	module.filter('niceDate', [function() {
		return function(input, relative, format) {
			if (input === null) return;
			
			var thisMoment = moment.utc(input).local();
			
			if (angular.isUndefined(relative)) relative = true;
			
			if (relative) {
				return thisMoment.fromNow();
			}

			if (!format) format = "Do MMMM YYYY @ h:mm a";
			
			return thisMoment.format(format);
		};
	}]);

	/**
	 * Easy helper filter for providing date output of common date formats. There is 
	 * no extensibility provided or necessary for this filter. If you want more options,
	 * use the niceDate filter provided above.
	 */
	module.filter('commonDate', ['$filter', function($filter) {
		return function(input) {
			return $filter('niceDate')(input, false, 'ha, Do MMMM');
		}
	}]);

	/**
	 * Converts a file size from bytes to KB/MB/GB with optional precision
	 * to allow a few decimal points if needed.
	 * 
	 * @param {String} unit      Unit expects either 'kb', 'mb' or 'gb'.
	 * @param {Number} precision Number of decimal points.
	 * 
	 * @return {String}
	 */
	module.filter('filesize' , [function() {
		return function(input , unit , precision) {
			unit = !unit ? 'kb' : unit.toLowerCase();

			if (!precision) precision = 0;
			
			// Default units.
			var kb = 1024,
				mb = kb * 1024,
				gb = mb * 1024;
			
			if (unit == 'gb') {
				return (input / gb).toFixed(precision) + ' GB';
			}
			else if (unit == 'mb') {
				return (input / mb).toFixed(precision) + ' MB';
			}
			else {
				return (input / kb).toFixed(precision) + ' KB';
			}
		}
	}]);

	/**
	 * Parses and returns a file extension from a valid file name.
	 *
	 * @return {string}
	 */
	module.filter('extension' , [function() {
		return function(input) {
			if (!input.length) return input;

			if (input.indexOf('.') == -1) return null;
			
			// Return the last part of the array.
			// Assuming that the filename provided is valid, we should have no issues.
			return input.split('.').pop();
		};
	}]);

	/**
	 * Expects the input to be either 0 or 1 and based on that
	 * it returns either 'Active' or 'Inactive'.
	 *
	 * @return {string}
	 */
	module.filter('activeIndicator' , [function() {
		return function(input) {
			return input ? 'Active' : 'Inactive';
		};
	}]);

	/**
	 * Provies a more versatile filter than the one above, allowing developers to define
	 * what text to use for both truthy and falsy statements.
	 * 
	 * @return string
	 */
	module.filter('enabledIndicator', [function() {
		return function(input, truthy, falsy) {
			if (angular.isUndefined(truthy)) truthy = 'Enabled';
			if (angular.isUndefined(falsy)) falsy = 'Disabled';

			return input ? truthy : falsy;
		};
	}]);

	/**
	 * Truncate a long piece of string into a limited number of words.
	 * 
	 * @param {string}  input
	 * @param {integer} limit Defaults to 10 words.
	 * @param {string}  end   Defualts to '…'
	 * 
	 * @return {string}
	 */
	module.filter('truncate', [function() {
		return function(input, limit, end) {
			if (!input) return input;
			
			// Parameter defaults.
			if (isNaN(limit)) limit = 10;
			if (!angular.isString(end)) end = '…';
			
			// Replace line breaks with spaces.
			input = input.replace(/\n/g , ' ');
			
			// Get all the words, ignoring space and linebreaks.
			var words = _.filter(input.split(' ') , function(w) { return $.trim(w); });
			
			// The input is within the limit.
			if (words.length <= limit) return input;
			
			// The input is larger than the limit.
			return _.first(words, limit).join(' ') + end;
		};
	}]);
	
	/**
	 * Replaces new lines to html line breaks.
	 * This must be used within a 'ng-bind-html-unsafe' directive.
	 */
	module.filter('nl2br', [function() {
		return function(input) {
			return input.split("\n").join('<br>');
		};
	}]);
})();
