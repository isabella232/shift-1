<?php namespace Tectonic\Shift\Modules\Configuration;

use App;
use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Modules\Configuration\Contracts\SettingRepositoryInterface;
use Tectonic\Shift\Modules\Configuration\Repositories\EloquentSettingRepository;

class ConfigurationServiceProvider extends ServiceProvider
{
    public function register()
    {
        parent::register();

        $this->registerSettingRepository();
    }

    private function registerSettingRepository()
    {
        $this->app->singleton(SettingRepositoryInterface::class, EloquentSettingRepository::class);
    }
}