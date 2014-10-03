<?php namespace Tectonic\Shift\Library\Composers;

use App;
use Config;
use Tectonic\Shift\Modules\Startup\StartupService;

class LayoutsApplicationComposer
{
    /**
     * @var StartupService
     */
    private $startupService;

    /**
     * @param StartupService $startupService
     */
    function __construct(StartupService $startupService)
    {
        $this->startupService = $startupService;
    }

    public function compose($view)
	{
        $configuration = $this->startupService->configuration();

		$view->with('configuration', $configuration);

        $languageDictionary = App::make('shift.translator')
            ->setUICustomisations(Config::get('shift::language.locales'))
            ->allToJson();

        $view->with('language', $languageDictionary);
	}
}
