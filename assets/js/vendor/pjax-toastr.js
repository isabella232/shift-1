/**
 * Setup the module namespace and name. In this case, Tectonic.Pjax;
 *
 * @type object
 */
var Pjax = Pjax || {};

(function($) {

	$(function() {

		var prev;

		// Store originating route in case of error
		Pjax.Eventer.listen('pjax:beforeSend', function( event, xhr, textStatus, options ) {
			prev = window.location.pathname;
		});

		// Listen for pjax errors
	    Pjax.Eventer.listen('pjax:error', function( event, xhr, textStatus, options ) {

			// Cancel pjax on error
			event.preventDefault();

			// Show error details in notification
			toastr.error( xhr.statusText, 'Error: ' + xhr.status );

			// Remove invalid route from url, can set this to a 404 page or something similar
			// with $.pjax in the future
			history.pushState( null, null, prev );
		});

	    // Force an invalid request
		$.pjax({ url: 'test-url', container: '#content' });

	});
	

})(jQuery);