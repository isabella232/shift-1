<?php
/**
 * Shift-specific routes and routing, rules and filter definitions.
 */
Route::group(['prefix' => Config::get('shift.url')], function() {
    Route::group(['before' => 'shift.view'], function() {
        Route::get('/', 'Tectonic\Shift\Controllers\DashboardController@index');

        Route::collection('users', 'Tectonic\Shift\Controllers\UserController');
        Route::collection('roles', 'Tectonic\Shift\Controllers\RoleController');
        Route::collection('locales', 'Tectonic\Shift\Controllers\LocaleController');
        Route::collection('fields', 'Tectonic\Shift\Controllers\FieldController');
        Route::collection('localisations', 'Tectonic\Shift\Controllers\LocalisationController');
    });

    Route::group(['before' => 'shift.noAccount'], function() {
        Route::get('install', 'Tectonic\Shift\Controllers\InstallationController@getInstall');
        Route::post('install', 'Tectonic\Shift\Controllers\InstallationController@postInstall');
    });
});

Route::filter('shift.view', 'Tectonic\Shift\Library\Filters\ViewFilter');
Route::filter('shift.account', 'Tectonic\Shift\Library\Filters\AccountFilter');
Route::filter('shift.noAccount', 'Tectonic\Shift\Library\Filters\NoAccountFilter');

Route::whenRegex('/^(?!install)/i', 'shift.account');
