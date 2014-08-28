<?php
// Register Utility Binding
$this->app->singleton('Tectonic\Shift\Library\Utility');
$this->app->singleton('Tectonic\Shift\Models\Accounts\Services\AccountsService');

// Register UserRepositoryInterface binding
$this->app->bind('Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface', 'Tectonic\Shift\Modules\Accounts\Repositories\SqlAccountRepository');
$this->app->bind('Tectonic\Shift\Modules\Accounts\Repositories\UserRepositoryInterface', 'Tectonic\Shift\Modules\Accounts\Repositories\SqlUserRepository');
$this->app->bind('Tectonic\Shift\Modules\CustomFields\Repositories\CustomFieldRepositoryInterface', 'Tectonic\Shift\Modules\CustomFields\Repositories\CustomFieldRepository');
$this->app->bind('Tectonic\Shift\Modules\Security\Repositories\RoleRepositoryInterface', 'Tectonic\Shift\Modules\Security\Repositories\SqlRoleRepository');
