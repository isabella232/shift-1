(function() {
    'use strict';

    var dependencies = [];

    angular
        .module('Shift.Home.Controllers', dependencies)
        .controller('Shift.Home', Home);

    Home.$inject = ['$scope'];
    function Home($scope) {
        $scope.title = 'Shift 2.0';
    }

})();
