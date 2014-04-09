<?php
/**
 * Shift-specific routes and routing, rules and filter definitions.
 */

// Register all /api/ routes. All application requests for data basically
// go via the API route group collection.
Route::group(['prefix' => Config::get('shift.api.url')], function() {
	Route::collection('roles', 'Tectonic\Shift\Modules\Security\Controllers\RoleController');
});

Route::filter('shift.view', 'Tectonic\Shift\Library\Filters\ViewFilter');
Route::when('*', 'shift.view');
