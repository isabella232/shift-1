<?php namespace Tectonic\Shift\Library;

use App;
use Illuminate\Support\ServiceProvider;
use Tectonic\Shift\Library\Support\Asset;


class LibraryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerUtility();
        $this->registerAssetContainer();
    }

    /**
     * Register Utility binding
     *
     * @returns void
     */
    protected function registerUtility()
    {
        $this->app->singleton('Tectonic\Shift\Library\Utility');
    }

    /**
     * Register the Asset container. This is an extended version of
     * Orchetra\Asset\Factory
     *
     * @returns void
     */
    public function registerAssetContainer()
    {
        $this->app->bindShared('shift.asset', function($app) {
            return new Asset($app['orchestra.asset.dispatcher']);
        });
    }
}
