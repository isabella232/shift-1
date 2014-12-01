(function() {
	Controllers.home = function() {
		Recaptcha.create( $rootScope.config[ 'recaptcha_public_key' ], attributes.id, { theme: "white" } );
	};
})();
