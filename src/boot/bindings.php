<?php
/**
 * This file is simply for grouping all our bindings together in a list format.
 */

$this->app->bind('utility', 'Tectonic\Shift\Library\Utility');

$this->app->bind('Tectonic\Shift\Modules\Security\Repositories\RoleRepositoryInterface', 'Tectonic\Shift\Modules\Security\Repositories\RoleRepository');

$this->app->bind('Tectonic\Shift\Modules\Accounts\Repositories\UserRepositoryInterface', 'Tectonic\Shift\Modules\Accounts\Repositories\UserRepository');
