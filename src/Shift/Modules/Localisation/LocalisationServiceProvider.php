<?php
namespace Tectonic\Shift\Modules\Localisation;

use App;
use Event;
use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Modules\Localisation\Listeners\StartupListener;
use Tectonic\Shift\Modules\Localisation\Contracts\LanguageRepositoryInterface;
use Tectonic\Shift\Modules\Localisation\Contracts\TranslationRepositoryInterface;
use Tectonic\Shift\Modules\Localisation\Repositories\EloquentLanguageRepository;
use Tectonic\Shift\Modules\Localisation\Repositories\EloquentTranslationRepository;

class LocalisationServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Required listeners for the system.
     *
     * @var array
     */
    protected $listeners = [
        StartupListener::class
    ];

    /**
     * Registers the repositories assigned to the localisation module.
     *
     * @var array
     */
    protected $repositories = [
        LanguageRepositoryInterface::class => EloquentLanguageRepository::class,
        TranslationRepositoryInterface::class => EloquentTranslationRepository::class
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
	    parent::register();

        $this->registerAssetContainer();
        $this->registerTranslator();
        $this->registerLangSingleton();
        $this->registerLocaliserInterface();
    }

    public function boot()
    {
	    parent::boot();

        $this->registerCustomValidationRules();
    }

    /**
     * Register the Asset container. This is an extended version of Orchestra\Asset\Factory
     *
     * @return void
     */
    public function registerAssetContainer()
    {
        $this->app->singleton('shift.asset', function($app) {
            return new \Tectonic\Shift\Library\Support\AssetFactory($app['orchestra.asset.dispatcher']);
        });
    }

    /**
     * Register Engine
     *
     * @return void
     */
    protected function registerTranslator()
    {
        $this->app->singleton('shift.translator', function($app)
        {
            return new \Tectonic\Shift\Library\Translation\Translator(
                $app['translation.loader'],
                $app['Tectonic\Shift\Modules\Localisation\Services\UILocalisationService'],
                $app['config']['app.locale'],
                $app['config']['shift::language.autoloads'],
                $app['config']['shift::language.locales']
            );
        });

        $this->app->bind('Symfony\Component\Translation\TranslatorInterface', function($app) {
            return $app['shift.translator'];
        });

        // Setup our Translator instance and facade
        $this->app->singleton('Translator', function($app) {
            $translatorEngine = new Engine;

            $translatorEngine->registerTransformer(
                new CollectionTransformer,
                new ModelTransformer
            );

            return $translatorEngine;
        });
    }

    /**
     * Register lang singleton
     *
     * @return void
     */
    protected function registerLangSingleton()
    {
        $this->app->singleton('lang', function($app) {
            return $app['shift.translator'];
        });
    }

    /**
     * Register the localiser and bind and implementation to interface
     *
     * @return void
     */
    protected function registerLocaliserInterface()
    {
        $this->app->singleton('Tectonic\Shift\Modules\Localisation\Contracts\LocaliserInterface', function()
        {
            return $this->app->make('Tectonic\Shift\Modules\Localisation\Services\Localiser');
        });
    }

    /**
     * Register custom validation rules
     *
     * @return void
     */
    protected function registerCustomValidationRules()
    {
        // Add validation rule to validating ISO language codes (en-GB)
        $this->app['Illuminate\Validation\Factory']
            ->extend('localeCode', 'Tectonic\Shift\Modules\Localisation\Validators\LocaleCustomValidationRules@localeCode');
    }
}
