<?php
/**
 * Shift-specific routes and routing, rules and filter definitions.
 */

// Register all /api/ routes. All application requests for data basically
// go via the API route group collection.
Route::group(['prefix' => Config::get('shift.api.url'), 'before' => 'shift.account|shift.view'], function() {
	Route::collection('roles', 'Tectonic\Shift\Controllers\RoleController');
	Route::collection('users', 'Tectonic\Shift\Controllers\UserController');
    Route::collection('customfields', 'Tectonic\Shift\Modules\CustomFields\Controllers\CustomFieldController');
});

Route::get('install', 'Tectonic\Shift\Modules\Security\Controllers\InstallationController@getInstall');

Route::filter('shift.view', 'Tectonic\Shift\Library\Filters\ViewFilter');
Route::filter('shift.account', 'Tectonic\Shift\Library\Filters\AccountFilter');

Route::get('/', function()
{
    return View::make('shift::home.index');
});

Route::get('test', function()
{
    $cf = new Tectonic\Shift\Modules\CustomFields\Entities\CustomField();
    $cf->setGroup('Group');
    $cf->setResource('Resource');
    $cf->setType('Type');
    $cf->setFieldTitle('FieldTitle');
    $cf->setFieldCode('FieldCode');
    $cf->setLabel('Label');
    $cf->setOptions('Options');
    $cf->setValidation('Validation');
    $cf->setSettings('Settings');
    $cf->setRequired(true);
    $cf->setRegistration(true);
    $cf->setOrder(1);

    $em = App::make('Doctrine\ORM\EntityManagerInterface');
    $em->persist($cf);
    $em->flush();
});