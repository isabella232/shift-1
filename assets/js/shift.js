// Required for underscore string module
(function($) {
	// When menu parents are clicked, simply toggle the active class
	$('.menu .parent span').click(function() {
		$(this).parent().toggleClass('active');
	});

	// PJAX configuration and setup - links, and forms.
	// The long timeout is to ensure that we don't get weird cancellation effects for
	// semi-long requests (a few hundred ms). Also helps with slow connections.
	var timeout = 4000;
    var pjaxContainer = '#pjaxContainer';
    var loader = $('#loader');

	var submissionCallback = function(event) {
        // Setup our ladda button animations for submission type events. For some reason PJAX
        // doesn't play nicely with this if it's bound outside of this callback, so we set it up
        // here and manually start the animation once the form has been submitted.
        var button = $('.ladda-button').ladda();

        button.ladda('start');

		$.pjax.submit(event, pjaxContainer);
	};

	$(document).pjax('#content a, #navigation a', pjaxContainer, {"timeout": timeout});
	$(document).on('submit', 'form[data-pjax]', submissionCallback);

    // Just in case the load time is really fast, we don't bother showing the loader. Give
    // it a slight delay in case of really fast load times. We don't want loaders flickering
    // in and out of existence, do we? //- Kirk
    $(document).on('pjax:send', function() {
        loader.show().fadeTo(250, 0.8);
    });

    $(document).on('pjax:end', function() {
        loader.fadeTo(250, 0, function() { $(this).hide(); });
    });

    // Handles navigation clicks
    $('#navigation a').click(function() {
        $('#navigation a').removeClass('active');

        $(this).addClass('active');
    });

    $('#accountName').click(function() {
        $('#accountName').hide();

        $("#accountSwitcher").select2({
            placeholder: "",
            minimumInputLength: 1,
            ajax: {
                url: "http://shift2.app/auth/accounts",
                dataType: 'json',
                quietMillis: 250,
                data: function (term, page) { // page is the one-based page number tracked by Select2
                    return {
                        q: term // search term
                    };
                },
                results: function (data, page) {
                    // notice we return the value of more so Select2 knows if more results can be loaded
                    return { results: data };
                }
            },
            formatResult: function(repo) {
                return '<span class="account-switcher-result">' + repo.text + '</span>';
            },
            formatSelection: function(repo) {
                return repo.text;
            }
            //dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
            // escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
        });

        $('#accountSwitcher').on("select2-selecting", function(e) {
            // On select redirect to new account.
            window.location.href = "/auth/account/" + e.val;
        });

        $('#accountSwitcher').on("select2-close", function(e) {
            $('#accountName').show();
            $("#accountSwitcher").select2('destroy');
        });
    });

	// Setup jquery pjax
	$(document).pjax('[data-pjax], #content a', '#content');
})();
