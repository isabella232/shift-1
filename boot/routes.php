<?php
/**
 * Shift-specific routing rules and filter definitions.
 */

Route::filter('shift.auth', 'Tectonic\Shift\Library\Filters\AuthFilter');
Route::filter('shift.account', 'Tectonic\Shift\Library\Filters\AccountFilter');
Route::filter('shift.install', 'Tectonic\Shift\Library\Filters\InstallationFilter');

Route::whenRegex('/^(?!install)/i', 'shift.account');
