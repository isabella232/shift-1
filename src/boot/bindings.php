<?php
/**
 * This file is simply for grouping all our bindings together in a list format.
 */

$this->bind('utility', 'Library\Utility');

// Repository bindings
$this->app->bind('Modules\Security\Repositories\RoleRepositoryInterface', 'Modules\Security\Repositories\RoleRepository');
$this->app->bind('Modules\Accounts\Repositories\UserRepositoryInterface', 'Modules\Accounts\Repositories\UserRepository');
