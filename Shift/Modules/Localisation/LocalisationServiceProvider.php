<?php namespace Tectonic\Shift\Modules\Localisation;

use Illuminate\Support\ServiceProvider;

class LocalisationServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAssetContainer();
        $this->registerTranslator();
        $this->registerLangSingleton();
        $this->registerLocaleRepository();
        $this->registerLocalisationRepository();
        $this->registerCustomValidationRules();
    }

    /**
     * Register the Asset container. This is an extended version of Orchestra\Asset\Factory
     *
     * @return void
     */
    public function registerAssetContainer()
    {
        $this->app->bindShared('shift.asset', function($app) {
            return new \Tectonic\Shift\Library\Support\Asset($app['orchestra.asset.dispatcher']);
        });
    }

    /**
     * Register Translator
     *
     * @return void
     */
    protected function registerTranslator()
    {
        $this->app->bindShared('shift.translator', function($app)
        {
            return new \Tectonic\Shift\Library\Translation\Translator(
                $this->app['translation.loader'],
                $this->app['Tectonic\Shift\Modules\Localisation\Repositories\LocalisationRepositoryInterface'],
                $this->app['config']['app.locale'],
                $this->app['config']['shift::language.autoloads'],
                $this->app['config']['shift::language.locales']
            );
        });

        $this->app->bind('Symfony\Component\Translation\TranslatorInterface', function($app) {
            return $app['shift.translator'];
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
     * Register locale repository
     *
     * @return void
     */
    protected function registerLocaleRepository()
    {
        $this->app->bindShared('Tectonic\Shift\Modules\Localisation\Repositories\LocaleRepositoryInterface', function()
        {
            return App::make('Tectonic\Shift\Modules\Localisation\Repositories\LocaleRepository');
        });
    }

    /**
     * Register localisation repository
     *
     * @return void
     */
    protected function registerLocalisationRepository()
    {
        $this->app->bindShared('Tectonic\Shift\Modules\Localisation\Repositories\LocalisationRepositoryInterface', function()
        {
            return App::make('Tectonic\Shift\Modules\Localisation\Repositories\LocalisationRepository');
        });
    }

    /**
     * Register custom validation rules
     *
     * @return void
     */
    private function registerCustomValidationRules()
    {
        // Add validation rule to validating ISO language codes (en-GB)
        $this->app['Illuminate\Validation\Factory']
            ->extend('localeCode', 'Tectonic\Shift\Modules\Localisation\Validators\LocaleCustomValidationRules@localeCode');
    }
}
