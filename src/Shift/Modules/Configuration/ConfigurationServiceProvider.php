<?php namespace Tectonic\Shift\Modules\Configuration;

use App;
use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Modules\Configuration\Repositories\SettingRepositoryInterface;
use Tectonic\Shift\Modules\Configuration\Repositories\DoctrineSettingRepository;

class ConfigurationServiceProvider extends ServiceProvider
{
    public function register()
    {
        parent::register();

        $this->registerSettingRepository();
    }

    private function registerSettingRepository()
    {
        $this->app->singleton(SettingRepositoryInterface::class, DoctrineSettingRepository::class);
    }
}