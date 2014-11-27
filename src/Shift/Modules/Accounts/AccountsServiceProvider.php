<?php
namespace Tectonic\Shift\Modules\Accounts;

use App;
use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Modules\Accounts\Contracts\AccountRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Contracts\SupportedLanguageRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Facades\CurrentAccount;
use Tectonic\Shift\Modules\Accounts\Repositories\EloquentAccountRepository;
use Tectonic\Shift\Modules\Accounts\Contracts\DomainRepositoryInterface;
use Tectonic\Shift\Modules\Accounts\Repositories\EloquentDomainRepository;
use Tectonic\Shift\Modules\Accounts\Repositories\EloquentSupportedLanguagesRepository;
use Tectonic\Shift\Modules\Accounts\Services\CurrentAccountService;

class AccountsServiceProvider extends ServiceProvider
{
    protected $aliases = [
        'CurrentAccount' => CurrentAccount::class
    ];

    /**
     * The repository bindings for the Accounts module.
     *
     * @var array
     */
    protected $repositories = [
        AccountRepositoryInterface::class => EloquentAccountRepository::class,
        DomainRepositoryInterface::class => EloquentDomainRepository::class,
        SupportedLanguageRepositoryInterface::class => EloquentSupportedLanguagesRepository::class,
    ];

    /**
     * A list of listeners that are setup as subscribers within Laravel.
     *
     * @var array
     */
    protected $listeners = [];

    /**
     * Register any required bindings.
     */
    public function register()
    {
        $this->registerCurrentAccountService();

        parent::register();
    }

    /**
     * Register the current account service as a singleton.
     */
    public function registerCurrentAccountService()
    {
        $this->app->singleton('current.account', CurrentAccountService::class);
    }
}
