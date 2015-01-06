// Required for underscore string module
(function() {
<<<<<<< HEAD

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

=======
	// Setup jquery pjax
	$(document).pjax('[data-pjax], #content a', '#content');
>>>>>>> master
})();
