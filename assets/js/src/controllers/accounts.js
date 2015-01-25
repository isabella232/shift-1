(function() {
	'use strict';

	var router = Pjax.Router;

	var accountForm = function() {
		$('#owner').select2({
			ajax: {
				url: '/users/autocomplete',
				dataType: 'json',
				delay: 250,
				data: function(searchTerm) {
					return {
						name: searchTerm
					}
				},
				results: function(data) {
					return {
						results: data
					}
				},
				cache: true
			},
			formatResult: function(object) {
				return object.firstName + ' ' + object.lastName
			},
			formatSelection: function(object) {
				return object.firstName + ' ' + object.lastName
			},
			minimumInputLength: 3
		});
	};

	var editAccount = function() {

	};

	router.get('accounts/new', accountForm);
	router.get('accounts/:alphanum', editAccount);
})();
