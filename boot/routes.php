<?php
/**
 * Shift-specific routes and routing, rules and filter definitions.
 */
Route::filter('shift.view', 'Tectonic\Shift\Library\Filters\ViewFilter');
Route::filter('shift.account', 'Tectonic\Shift\Library\Filters\AccountFilter');
Route::filter('shift.install', 'Tectonic\Shift\Library\Filters\NoAccountFilter');
Route::filter('shift.view', 'Tectonic\Shift\Library\Filters\ViewFilter');
Route::filter('shift.account', 'Tectonic\Shift\Library\Filters\AccountFilter');

/**
 * Register all /api/ routes. All application requests for data go via the API route
 */
Route::group(['prefix' => Config::get('shift::url', '')], function() {
    Route::group(['before' => 'shift.view'], function() {
        Route::get('/', function() {});

        Route::collection('users', 'Tectonic\Shift\Controllers\UserController');
        Route::collection('roles', 'Tectonic\Shift\Controllers\RoleController');
        Route::collection('locales', 'Tectonic\Shift\Controllers\LocaleController');
        Route::collection('fields', 'Tectonic\Shift\Controllers\FieldController');
        Route::collection('localisations', 'Tectonic\Shift\Controllers\LocalisationController');
        Route::collection('sessions', 'Tectonic\Shift\Controllers\SessionController');
        Route::get('languages', 'Tectonic\Shift\Controllers\LanguageController@getLanguages');
        Route::post('languages', 'Tectonic\Shift\Controllers\LanguageController@postLanguages');
        Route::get('languages/supported', 'Tectonic\Shift\Controllers\LanguageController@getSupportedLanguages');
    });

    Route::group(['before' => 'shift.install'], function() {
        Route::get('install', 'Tectonic\Shift\Controllers\InstallationController@getInstall');
        Route::post('install', 'Tectonic\Shift\Controllers\InstallationController@postInstall');
    });

    Route::get('test', function() {
        $repoAccount = \Illuminate\Support\Facades\App::make('Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface');
        $repoLocale = \Illuminate\Support\Facades\App::make('Tectonic\Shift\Modules\Localisation\Contracts\LocaleRepositoryInterface');

        $dataOne = $repoAccount->getById(1);
        $dataTwo = $repoLocale->getById(2);

        $dataOne->addLocale($dataTwo);
        $repoAccount->save($dataOne);
        return $dataOne->getLocales()[1];
    });
});
