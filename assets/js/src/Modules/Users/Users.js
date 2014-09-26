(function () {
    'use strict';

    var dependencies = [
        'Shift.Users.Services',
        'Shift.Users.Controllers'
    ];

    angular
        .module('Shift.Users', dependencies)
        .config(Configuration)
        .run(Runner);

    function Configuration(){}

    function Runner(){}

})();