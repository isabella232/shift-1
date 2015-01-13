(function() {
	'use strict';

	var router = Pjax.Router;

	var accountForm = function() {
		console.log('@TODO: Implement user autocomplete functionality using select2 for defining the user of an account.');
	};

	var editAccount = function() {

	};

	router.get('accounts/new', accountForm);
	router.get('accounts/:alphanum', editAccount);
})();
