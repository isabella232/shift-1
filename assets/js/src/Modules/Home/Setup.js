(function() {
    'use strict';

    var module = angular.module('Shift.Home.Setup', ['Shift.Library.Defaults']);

    module.config(['ShiftRouteProvider', function(ShiftRouteProvider) {
        ShiftRouteProvider('home', {
            templateUrl: '/packages/tectonic/shift/views/home.html'
        });
    }]);

})();