(function () {
    'use strict';

    var dependencies = [];

    angular
        .module('Shift.Fields.Services', dependencies)
        .service('Fields', FieldsService);

    FieldsService.$inject = ['$http'];
    function FieldsService($http){

        var service = {
            getFieldsByResource: getFieldsByResource,
            getUserRegistrationFields: getUserRegistrationFields
        };

        return service;

        //////////

        /**
         * Return a collection of Fields based on resource type.
         *
         * @param resource
         * @returns {*}
         */
        function getFieldsByResource(resource){
            return $http.get(apiUrl('fields', true), { resource: resource }).then(function(data) { return data; });
        }

        /**
         * Get an array of custom fields required for user registration.
         *
         * @returns {Array}
         */
        function getUserRegistrationFields(){
            var fields = this.getFieldsByResource('User');
            var userFields = [];

            for ( var i = 0, j = fields.length; i < j; i++ ) {
                if ( fields[i].registration == '1' ) {
                    // Clear out the value of the custom field if the user has just logged out.
                    if ( !$rootScope.user ) fields[i].value = null;
                    userFields.push( fields[i] );
                }
            }

            return userFields;
        };
    }

})();