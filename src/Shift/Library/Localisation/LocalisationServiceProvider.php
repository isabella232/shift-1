<?php
namespace Tectonic\Shift\Library\Localisation;

use Illuminate\Translation\FileLoader;
use Illuminate\Translation\TranslationServiceProvider;
use Tectonic\Localisation\Contracts\TranslationRepositoryInterface;

class LocalisationServiceProvider extends TranslationServiceProvider
{
    protected function registerLoader()
    {
        $this->app->bindShared('translation.loader', function($app) {
            $fileLoader = new FileLoader($app['files'], $app['path'].'/lang');

            return new TranslationLoader($fileLoader, $app->make(TranslationRepositoryInterface::class));
        });
    }
}
