(function () {
    'use strict';

    var dependencies = [];

    angular
        .module('Shift.Settings.Services', dependencies)
        .service('LanguageService', LanguageService);

    LanguageService.$inject = ['$http'];
    function LanguageService($http) {

        var service = {
            getAllLanguages: getAllLanguages,
            getSupportedLanguages: getSupportedLanguages
        };

        function getAllLanguages() {
            return $http.get('/locales');
        }

        function getSupportedLanguages() {
            return $http.get('/languages/supported');
        }

        return service;
    }

})();