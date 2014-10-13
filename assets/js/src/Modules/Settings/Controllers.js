(function () {
    'use strict';

    var dependencies = [];

    angular
        .module('Shift.Settings.Controllers', dependencies)
        .controller('Settings.General', General)
        .controller('Settings.Language', Language);

    General.$inject = ['$scope', 'Tabs'];
    function General($scope) {
        $scope.tabsResource = 'setting';

        // Set up the Settings tabulation
        var tabs = new Tabs( 'setting' );

        for( var tabName in $scope.settings ) {
            var tabOptions = {
                name: tabName.titleize(),
                templateUrl: viewPath( 'settings/tab.html', 'shift' ),
                settings: $scope.settings[ tabName ],
                enabled: true
            };

            tabs.register( tabOptions );
        }

        tabs.finalize();
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