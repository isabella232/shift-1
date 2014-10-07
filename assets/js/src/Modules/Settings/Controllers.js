(function () {
    'use strict';

    var dependencies = [];

    angular
        .module('Shift.Settings.Controllers', dependencies)
        .controller('Settings.General', General)
        .controller('Settings.Language', Language);

    function General() {

    }

    Language.$inject = ['LanguageService'];
    function Language(LanguageService) {
        var vm = this;

        LanguageService.getAllLanguages().then(function(response) {
            vm.languages = response.data;
        });

        LanguageService.getSupportedLanguages().then(function(response) {
            vm.supportedLanguages = response.data;
        });

        vm.removeSupportedLanguage = remove;

        function remove(id) {
            console.log(id);
        }
    }

})();