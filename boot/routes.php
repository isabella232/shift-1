<?php
/**
 * Shift-specific routes and routing, rules and filter definitions.
 */
Route::group(['prefix' => Config::get('shift.url')], function() {
    Route::get('/', 'Tectonic\Shift\Controllers\HomeController@index');

    Route::get('register', 'Tectonic\Shift\Controllers\RegistrationController@form');
    Route::post('register', 'Tectonic\Shift\Controllers\RegistrationController@register');

    Route::get('login', 'Tectonic\Shift\Controllers\AuthenticationController@form');
    Route::post('login', 'Tectonic\Shift\Controllers\AuthenticationController@login');

    Route::collection('fields', 'Tectonic\Shift\Controllers\FieldController');
    Route::collection('roles', 'Tectonic\Shift\Controllers\RoleController');
    Route::collection('sessions', 'Tectonic\Shift\Controllers\AuthenticationController');
    Route::collection('users', 'Tectonic\Shift\Controllers\UserController');
    
    Route::get('languages', 'Tectonic\Shift\Controllers\LanguageController@getLanguages');
    Route::post('languages', 'Tectonic\Shift\Controllers\LanguageController@postLanguages');
    Route::get('languages/supported', 'Tectonic\Shift\Controllers\LanguageController@getSupportedLanguages');

    Route::group(['before' => 'shift.install'], function() {
        Route::get('install', 'Tectonic\Shift\Controllers\InstallationController@getInstall');
        Route::post('install', 'Tectonic\Shift\Controllers\InstallationController@postInstall');
    });
});

Route::filter('shift.account', 'Tectonic\Shift\Library\Filters\AccountFilter');
Route::filter('shift.install', 'Tectonic\Shift\Library\Filters\InstallationFilter');

Route::whenRegex('/^(?!install)/i', 'shift.account');
