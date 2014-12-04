<?php
/**
 * Shift-specific routes and routing, rules and filter definitions.
 */
Route::group(['prefix' => Config::get('shift.url', ''), 'namespace' => 'Tectonic\Shift\Controllers'], function() {
    Route::get('/', 'HomeController@index');

    Route::get('register', 'RegistrationController@form');
    Route::post('register', 'RegistrationController@register');

    // Authentication routes
    Route::get('login', 'AuthenticationController@form');
    Route::post('login', 'AuthenticationController@login');
    Route::get('logout', ['uses' => 'AuthenticationController@logout', 'before' => 'auth']);

    // User profile routes
    Route::get('profile', 'UserController@profile');
    Route::post('profile', 'UserController@updateProfile');

    Route::collection('fields', 'FieldController');
    Route::collection('roles', 'RoleController');
    Route::collection('sessions', 'AuthenticationController');
    Route::collection('users', 'UserController');
    
    Route::get('languages', 'LanguageController@getLanguages');
    Route::post('languages', 'LanguageController@postLanguages');
    Route::get('languages/supported', 'LanguageController@getSupportedLanguages');

    Route::group(['before' => 'shift.install'], function() {
        Route::get('install', 'InstallationController@getInstall');
        Route::post('install', 'InstallationController@postInstall');
    });
});

Route::filter('shift.account', 'Tectonic\Shift\Library\Filters\AccountFilter');
Route::filter('shift.install', 'Tectonic\Shift\Library\Filters\InstallationFilter');

Route::whenRegex('/^(?!install)/i', 'shift.account');
