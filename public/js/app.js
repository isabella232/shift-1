(function() {
    'use strict';

    var app = angular.module( 'application', ['shift'] );

    // Initialize
    app.run( [ '$rootScope', function( $rootScope ) {
        $rootScope.abc = function() {
            return x = y;
        };
    }]);

})();
