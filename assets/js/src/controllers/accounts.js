(function() {
	'use strict';

	var router = Pjax.Router;

	var accountForm = function() {
		$('#owner').select2({
			ajax: {
				url: '/users/',
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						name: params.term
					}
				},
				processResults: function(data) {
					return {
						results: data.data
					}
				},
				cache: true
			},
			minimumInputLength: 3
		});
	};

	var editAccount = function() {

	};

	router.get('accounts/new', accountForm);
	router.get('accounts/:alphanum', editAccount);
})();
