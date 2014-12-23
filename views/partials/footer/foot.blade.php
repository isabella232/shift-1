<!--[if lt IE 9]><script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script><![endif]-->
<!--[if gte IE 9]><!--><script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script><!--<![endif]-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.min.js"></script>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

{{-- Load Assets --}}
@foreach(Asset::containers(['custom']) as $container)
    {{ $container->scripts() }}
@endforeach
{{ Asset::container('custom')->scripts() }}

<script>
    function formatResult(repo) {
        return repo.text;
    }

    function formatSelection(repo) {
        return repo.text;
    }

    $("#accountSwitcher").select2({
        placeholder: "Search",
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
        formatResult: formatResult, // omitted for brevity, see the source of this page
        formatSelection: formatSelection, // omitted for brevity, see the source of this page
        dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
        //escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
    });

    $('#accountSwitcher').on("select2-selecting", function(e) {
        // TODO: On select do something...
    });
</script>
