<?php
namespace Tectonic\Shift\Library\Localisation;

use Illuminate\Translation\FileLoader;
use Illuminate\Translation\TranslationServiceProvider;
use Tectonic\Localisation\Contracts\TranslationRepositoryInterface;

class LocalisationServiceProvider extends TranslationServiceProvider
{
    /**
     * Here we're overloading the registerLoader method by Laravel, and creating our own
     * translation loader, which manages not only lang files, but database language value customisations
     * as well.
     */
    protected function registerLoader()
    {
        $this->app->bindShared('translation.loader', function($app) {
            $fileLoader = new FileLoader($app['files'], base_path().'/resources/lang');

            return new TranslationLoader($fileLoader, $app->make(TranslationRepositoryInterface::class));
        });
    }
}
