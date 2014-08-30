<?php

// Register Utility Binding
$this->app->singleton('Tectonic\Shift\Library\Utility');
$this->app->singleton('Tectonic\Shift\Models\Accounts\Services\AccountsService');

// Register UserRepositoryInterface binding
$this->app->bindShared('Tectonic\Shift\Modules\Accounts\Repositories\AccountRepositoryInterface', function() {
    return App::make('Tectonic\Shift\Modules\Accounts\Repositories\SqlAccountRepository');
});

$this->app->bindShared('Tectonic\Shift\Modules\Accounts\Repositories\UserRepositoryInterface', function() {
    return App::make('Tectonic\Shift\Modules\Accounts\Repositories\SqlUserRepository');
});

$this->app->bindShared('Tectonic\Shift\Modules\CustomFields\Repositories\CustomFieldRepositoryInterface', function() {
    return App::make('Tectonic\Shift\Modules\CustomFields\Repositories\CustomFieldRepository');
});

$this->app->bindShared('Tectonic\Shift\Modules\Security\Repositories\RoleRepositoryInterface', function() {
    return App::make('Tectonic\Shift\Modules\Security\Repositories\SqlRoleRepository');
});

