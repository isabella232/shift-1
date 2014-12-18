<?php
namespace Tectonic\Shift\Library;

use App;
use Tectonic\Shift\Library\Authorization\Consumer;
use Tectonic\Shift\Library\Localisation\CurrentLocaleService;
use Tectonic\Shift\Library\Localisation\Translator;
use Tectonic\Shift\Library\Support\AssetFactory;
use Tectonic\Shift\Modules\Localisation\Services\TranslationService;

class LibraryServiceProvider extends ServiceProvider
{
    protected $aliases = [
        'Consumer' => 'Tectonic\Shift\Library\Facades\Consumer',
        'CurrentLocale' => 'Tectonic\Shift\Library\Facades\CurrentLocale',
    ];

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
        $this->registerConsumer();
        $this->registerCurrentLocale();
        $this->registerDeferredProviders();
    }

    protected function registerConsumer()
    {
        $this->app->singleton('consumer', Consumer::class);
    }

    protected function registerCurrentLocale()
    {
        $this->app->singleton('currentLocale', CurrentLocaleService::class);
    }

    protected function registerDeferredProviders()
    {
        $this->app->registerDeferredProvider('Tectonic\Shift\Library\Localisation\LocalisationServiceProvider');
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
