(function () {
    'use strict';

    var dependencies = [
        'Shift.Settings.Controllers',
        'Shift.Settings.Services'
    ];

    angular
        .module('Shift.Settings', dependencies)
        .config(Configuration);

    Configuration.$inject = ['$routeProvider'];
    function Configuration($routeProvider) {
        $routeProvider
            .when('/settings/general', {
                templateUrl: '/packages/tectonic/shift/views/settings/general/general.html',
                controller: 'Settings.General'
            })
            .when('/settings/language', {
                templateUrl: '/packages/tectonic/shift/views/settings/language/language.html',
                controller: 'Settings.Language'
            });
    }

})();