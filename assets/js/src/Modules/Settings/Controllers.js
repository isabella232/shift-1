(function () {
    'use strict';

    var dependencies = [];

    angular
        .module('Shift.Settings.Controllers', dependencies)
        .controller('Settings.General', General)
        .controller('Settings.Language', Language);

    function General() {

    }

    Language.$inject = ['LanguageService', 'Modalize'];
    function Language(LanguageService, Modalize) {
        var vm = this;

        LanguageService.getAllLanguages().then(function(response) {
            vm.languages = response.data;
        });

        LanguageService.getSupportedLanguages().then(function(response) {
            vm.supportedLanguages = response.data;
        });

        vm.removeSupportedLanguage = removeSupportedLanguage;
        vm.addSupportedLanguage = addSupportedLanguage;

        function removeSupportedLanguage(language) {
            vm.supportedLanguages.splice(vm.supportedLanguages.indexOf(language), 1);
        }

        function addSupportedLanguage() {
            setUnsupportedLanguages();
            Modalize.open( '/packages/tectonic/shift/views/settings/language/add.html', '600x420' );
        }

        function setUnsupportedLanguages() {
            var arr = vm.languages.slice(0);

            _.each(vm.supportedLanguages, function(obj) {
                arr = _.without(arr, _.findWhere(arr, {id: obj.id}));
            });

            vm.unsupportedLocales = arr;
        }
    }

})();