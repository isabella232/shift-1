// Required for underscore string module
(function() {
	// When menu parents are clicked, simply toggle the active class
	$('.menu .parent span').click(function() {
		$(this).parent().toggleClass('active');
	});

	// PJAX configuration and setup - links, and forms.
	// The long timeout is to ensure that we don't get weird cancellation effects for
	// semi-long requests (a few hundred ms). Also helps with slow connections.
	var timeout = 4000;

	var submissionCallback = function(event) {
		$.pjax.submit(event, '#content');
	};

	$(document).pjax('#content a', '#content', {"timeout": timeout});
	$(document).on('submit', 'form[data-pjax]', submissionCallback, {"timeout": timeout});
})();
