<?php
namespace Tectonic\Shift\Modules\Localisation\Listeners;

use App;
use Config;
use Tectonic\Shift\Library\Support\Listener;

class StartupListener extends Listener
{
    /**
     * Binds the language requirements to the configuration array when bootstrapping
     * the application (required by the front-end).
     *
     * @param array $configuration
     */
    public function whenConfigurationHasStarted($configuration)
    {
        $languageDictionary = App::make('shift.translator')
            ->setUICustomisations(Config::get('shift::language.locales'))
            ->allToJson();

        $configuration['language'] = $languageDictionary;
    }

    /**
     * Returns an array containing the events the listener will hook into. The key is the event,
     * and the value is the event handler method on the class.
     *
     * @returns array
     */
    public function hooks()
    {
        return [
            'shift.configuration' => 'whenConfigurationHasStarted'
        ];
    }
}
