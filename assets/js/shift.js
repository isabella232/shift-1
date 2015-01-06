// Required for underscore string module
(function() {
	// Setup jquery pjax
	$(document).pjax('a[data-pjax], #content a', '#content');

	$(document).on('submit', 'form[data-pjax]', function(event) {
		$.pjax.submit(event, '#content');
	});
})();
