<?php namespace Tectonic\Shift\Modules\Authentication;

use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Modules\Authentication\Contracts\TokenRepositoryInterface;
use Tectonic\Shift\Modules\Authentication\Repositories\EloquentTokenRepository;

class AuthenticationServiceProvider extends ServiceProvider
{
    /**
     * The repository bindings for the Accounts module.
     *
     * @var array
     */
    protected $repositories = [
        TokenRepositoryInterface::class => EloquentTokenRepository::class
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
    }

    public $defer = true;
}
