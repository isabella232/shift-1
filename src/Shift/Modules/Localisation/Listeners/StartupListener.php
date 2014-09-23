<?php

namespace Tectonic\Shift\Modules\Localisation\Listeners;

use Tectonic\Shift\Library\Support\Listener;

class StartupListener extends Listener
{
    /**
     * Array of events and their handlers.
     *
     * @var array
     */
    protected $hooks = [
        'Startup.Configuration.Started' => 'whenConfigurationHasStarted'
    ];

    /**
     * Binds the language requirements to the configuration array when bootstrapping
     * the application (required by the front-end).
     *
     * @param $configuration
     */
    public function whenConfigurationHasStarted(&$configuration)
    {
        $languageDictionary = App::make('shift.translator')
            ->setUICustomisations(Config::get('shift::language.locales'))
            ->allToJson();

        $configuration['language'] = $languageDictionary;
    }
}
