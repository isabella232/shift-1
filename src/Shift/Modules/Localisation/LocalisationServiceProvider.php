<?php
namespace Tectonic\Shift\Modules\Localisation;

use App;
use Event;
use Tectonic\Localisation\Contracts\TranslationRepositoryInterface;
use Tectonic\Shift\Library\ServiceProvider;
use Tectonic\Shift\Modules\Localisation\Listeners\StartupListener;
use Tectonic\Shift\Modules\Localisation\Contracts\LanguageRepositoryInterface;
use Tectonic\Shift\Modules\Localisation\Repositories\ConfigLanguageRepository;
use Tectonic\Shift\Modules\Localisation\Repositories\EloquentTranslationRepository;

class LocalisationServiceProvider extends ServiceProvider
{
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
        LanguageRepositoryInterface::class => ConfigLanguageRepository::class,
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
        $this->registerLangSingleton();
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
