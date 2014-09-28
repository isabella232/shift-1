(function() {
    'use strict';

    var dependencies = [];

    angular
        .module( 'Shift.Users.Filters', dependencies )
        .filter('userStatus', UserStatus);

    /**
     * Determine a users current status
     *
     * @returns {String}
     * @constructor
     */
    function UserStatus(){

        return function( user ) {
            if ( user.confirmation_token && !user.confirmed_at ) {
                return 'Awaiting confirmation';
            }
            if ( !user.confirmation_token && user.confirmed_at ) {
                return 'Active';
            }

            return 'ACTIVATION ERROR';
        };
    };

})();
