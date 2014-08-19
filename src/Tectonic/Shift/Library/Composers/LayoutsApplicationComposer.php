<?php 

namespace Tectonic\Shift\Library\Composers;

use App;

class LayoutsApplicationComposer
{
	public function compose($view)
	{
		$view->with('settings', []);
        $view->with('language', App::make('shift.translator')->setUICustomisations()->allToJson());
	}
}
