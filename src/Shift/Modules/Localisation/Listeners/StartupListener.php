<?php

namespace Tectonic\Shift\Modules\Localisation\Listeners;

class StartupListener
{
	public function whenConfigurationHasStarted(&$configuration)
    {
        $languageDictionary = App::make('shift.translator')
            ->setUICustomisations(Config::get('shift::language.locales'))
            ->allToJson();

        $configuration['language'] = $languageDictionary;
    }

    public function subscribe($events)
    {
        $events->listen('Startup.Configuration.Started', self::class.'@whenConfigurationHasStarted');
    }
}
