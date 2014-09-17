<?php
/**
 * Shift-specific routes and routing, rules and filter definitions.
 */
Route::filter('shift.view', 'Tectonic\Shift\Library\Filters\ViewFilter');
Route::filter('shift.account', 'Tectonic\Shift\Library\Filters\AccountFilter');

/**
 * Register all /api/ routes. All application requests for data go via the API route
 */
Route::group(['prefix' => Config::get('shift.api.url'), 'before' => 'shift.account|shift.view'], function() {
    Route::collection('users', 'Tectonic\Shift\Controllers\UserController');
    Route::collection('roles', 'Tectonic\Shift\Controllers\RoleController');
    Route::collection('locales', 'Tectonic\Shift\Modules\Localisation\Controllers\LocaleController');
    Route::collection('customfields', 'Tectonic\Shift\Modules\CustomFields\Controllers\CustomFieldController');
    Route::collection('localisations', 'Tectonic\Shift\Modules\Localisation\Controllers\LocalisationController');
});

/**
 * Home & non API routes
 */
Route::get('/', function() { return View::make('shift::home.index'); });
Route::get('install', 'Tectonic\Shift\Modules\Security\Controllers\InstallationController@getInstall');

Route::filter('shift.view', 'Tectonic\Shift\Library\Filters\ViewFilter');
Route::filter('shift.account', 'Tectonic\Shift\Library\Filters\AccountFilter');

Route::get('/', function()
{
    return View::make('shift::home.index');
});

Route::get('test', function()
{
    return App::make('shift.translator')
        ->setUICustomisations(Config::get('shift::language.locales'))
        ->allToJson();
});
