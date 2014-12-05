<?php
namespace Tectonic\Shift\Library;

use App;
use Tectonic\Shift\Library\Support\AssetFactory;

class LibraryServiceProvider extends ServiceProvider
{
    protected $serviceProviders = [
        'Tectonic\Shift\Library\Html\HtmlServiceProvider',
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
	    parent::register();

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
        $this->app->bindShared('orchestra.asset', function($app) {
            return new AssetFactory($app['orchestra.asset.dispatcher']);
        });
    }
}
