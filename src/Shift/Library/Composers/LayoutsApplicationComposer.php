<?php 

namespace Tectonic\Shift\Library\Composers;

use App;
use Config;

class LayoutsApplicationComposer
{
	public function compose($view)
	{
        $languageDictionary = App::make('shift.translator')
            ->setUICustomisations(Config::get('shift::language.locales'))
            ->allToJson();

		$view->with('settings', []);
        $view->with('language', $languageDictionary);
	}
}
