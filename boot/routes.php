<?php
/**
 * Shift-specific routes and routing, rules and filter definitions.
 */
Route::group(['prefix' => Config::get('shift.url', ''), 'namespace' => 'Tectonic\Shift\Controllers'], function() {
    Route::get('/', 'HomeController@index');

    Route::get('register', 'RegistrationController@form');
    Route::post('register', 'RegistrationController@register');

    // Authentication routes
    Route::post('login', 'AuthenticationController@login');
    Route::get('logout', ['uses' => 'AuthenticationController@logout', 'before' => 'auth']);

    // User profile routes
    Route::get('profile', 'UserController@profile');
    Route::post('profile', 'UserController@updateProfile');

    Route::collection('fields', 'FieldController');
    Route::collection('roles', 'RoleController');
    Route::collection('sessions', 'AuthenticationController');
    Route::collection('users', 'UserController');

    Route::group(['before' => 'shift.install'], function() {
        Route::get('install', 'InstallationController@getInstall');
        Route::post('install', 'InstallationController@postInstall');
    });
});

Route::filter('shift.account', 'Tectonic\Shift\Library\Filters\AccountFilter');
Route::filter('shift.install', 'Tectonic\Shift\Library\Filters\InstallationFilter');

Route::whenRegex('/^(?!install)/i', 'shift.account');

Route::get('settings', function() {
    \Tectonic\Shift\Modules\Configuration\Models\Setting::register('Group One', [
        ['name' => 'app.site.name', 'text' => 'Site name', 'type' => 'text'],
        ['name' => 'app.site.desc', 'text' => 'Site desc', 'type' => 'textarea'],
    ]);

    return \Tectonic\Shift\Modules\Configuration\Models\Setting::$registry;
});